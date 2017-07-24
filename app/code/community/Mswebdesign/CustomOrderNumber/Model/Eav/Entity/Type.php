<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Mswebdesign
 * @package    Mswebdesign_Mswebdesign_CustomOrderNumber
 * @copyright  Copyright (c) 2013 münster-webdesign.net (http://www.muenster-webdesign.net)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author     Christian Grugel <cgrugel@muenster-webdesign.net>
 */
class Mswebdesign_CustomOrderNumber_Model_Eav_Entity_Type extends Mage_Eav_Model_Entity_Type
{
    /**
     * @var int
     */
    protected $_storeId;

    /**
     * @var string
     */
    protected $_entityTypeCode;

    /**
     * @var array
     */
    protected $_entityStoreConfig = array();

    /**
     * @var string
     */
    protected $_prefix = '';

    /**
     * @var string
     */
    protected $_datePrefix = '';

    /**
     * @var string
     */
    protected $_incrementId = '';

    /**
     * @var object
     */
    protected $_incrementInstance;

    /**
     * @var array
     */
    protected $_processedEntityTypeCodes = array(
        'order',
        'invoice',
        'shipment',
        'creditmemo'
    );

    /**
     * Retreive new incrementId
     *
     * @param int $storeId
     * @return string
     */
    public function fetchNewIncrementId($storeId = null)
    {
        $this->_storeId = $storeId;
        $this->_entityTypeCode = $this->getEntityTypeCode();

        $incrementPerStore = Mage::getStoreConfigFlag('mswebdesign_customordernumber/'.$this->_entityTypeCode.'/increment_per_store', $this->_storeId);
        $this->setIncrementPerStore($incrementPerStore);

        if (!$this->getIncrementModel()) {
            return false;
        }
        if(!in_array($this->_entityTypeCode, $this->_processedEntityTypeCodes)) {
            return parent::fetchNewIncrementId($this->_storeId);
        }
        if (!$this->getIncrementPerStore() || ($this->_storeId === null)) {
            $this->_storeId = 0;
        }

        $this->_computeAndPersistNewIncrementId();

        return $this->_incrementId;
    }

    protected function _computeAndPersistNewIncrementId()
    {
        $this->_getResource()->beginTransaction();
        $this->_loadEntityStoreConfig();

        if (!$this->_entityStoreConfig->getId()) {
            $this->_saveDefaultEntityStoreConfig();
        }

        $this->_loadAndConfigureIncrementInstance();
        $this->_incrementId = $this->_incrementInstance->getNextId();
        $this->_appendDefaultNumberConstraint();

        if(false === $this->_isIncrementIdUinique()) {
            $this->_generateUniqueIncrementId();
        }

        $this->_updateEntityStoreConfig();
        $this->_getResource()->commit();
    }

    protected function _loadEntityStoreConfig()
    {
        $this->_entityStoreConfig = Mage::getModel('eav/entity_store')
            ->loadByEntityStore($this->getId(), $this->_storeId);
    }

    protected function _saveDefaultEntityStoreConfig() {
        $this->_entityStoreConfig
            ->setEntityTypeId($this->getId())
            ->setStoreId($this->_storeId)
            ->setIncrementPrefix($this->_storeId)
            ->save();
    }

    protected function _loadAndConfigureIncrementInstance()
    {
        $this->_incrementInstance = Mage::getModel($this->getIncrementModel())
            ->setPrefix($this->_getIncrementPrefix())
            ->setPadLength($this->_getIncrementPadLength())
            ->setPadChar($this->getIncrementPadChar())
            ->setLastId($this->_getIncrementLastId())
            ->setEntityTypeId($this->_entityStoreConfig->getEntityTypeId())
            ->setStoreId($this->_entityStoreConfig->getStoreId());
    }

    protected function _updateEntityStoreConfig()
    {
        $this->_entityStoreConfig->setIncrementLastId($this->_incrementId);
        $this->_entityStoreConfig->setIncrementPrefix($this->_getIncrementPrefix());
        $this->_entityStoreConfig->save();
    }

    /**
     * @return mixed|string
     */
    protected function _getIncrementPrefix()
    {
        $prefix = Mage::getStoreConfig('mswebdesign_customordernumber/'.$this->_entityTypeCode.'/prefix', $this->_storeId);
        $datePrefix = Mage::getStoreConfig('mswebdesign_customordernumber/'.$this->_entityTypeCode.'/date_prefix', $this->_storeId);

        if('' !== $datePrefix) {
            return $this->_datePrefix = $this->_convertDatePrefixToDate($datePrefix);
        }

        if('' !== $prefix) {
            return $this->_prefix = $prefix;
        }

        return null;
    }

    /**
     * @param $datePrefix
     *
     * @return string
     */
    protected function _convertDatePrefixToDate($datePrefix)
    {
        return date($datePrefix);
    }

    /**
     * @return int
     */
    protected function _getIncrementPadLength()
    {
        return intval(Mage::getStoreConfig('mswebdesign_customordernumber/'.$this->_entityTypeCode.'/padding_length', $this->_storeId));
    }

    /**
     * @return int
     */
    protected function _getIncrementLastId()
    {
        if('' !== $this->_datePrefix) {
            $this->_handleIncrementLastIdIfDateHasChanged();
        } else {
            $this->_handleIncrementLastIdIfPrefixLengthHasChanged();
        }

        return $this->_entityStoreConfig->getIncrementLastId();
    }


    protected function _handleIncrementLastIdIfDateHasChanged()
    {
        if($this->_entityStoreConfig->getIncrementPrefix() !== $this->_datePrefix) {
            if (1 === intval(Mage::getStoreConfig('mswebdesign_customordernumber/'.$this->_entityTypeCode.'/date_prefix_reset_enabled', $this->_storeId))) {
                $this->_entityStoreConfig->setIncrementLastId(0);
            } else {
                $this->_entityStoreConfig->setIncrementLastId($this->_datePrefix . substr($this->_entityStoreConfig->getIncrementLastId(), strlen($this->_datePrefix)));
            }
        }
    }

    protected function _handleIncrementLastIdIfPrefixLengthHasChanged()
    {
        if(strlen($this->_prefix) !== $this->_entityStoreConfig->getIncrementPrefix()) {
            $this->_entityStoreConfig->setIncrementLastId($this->_prefix.substr($this->_entityStoreConfig->getIncrementLastId(), strlen($this->_entityStoreConfig->getIncrementPrefix())));
        }
    }

    /**
     * @return bool
     */
    protected function _isIncrementIdUinique()
    {
        switch($this->_entityTypeCode) {
            case('order'):
                $collection = Mage::getSingleton('sales/'.$this->_entityTypeCode)->getCollection();
                break;
            default:
                $collection = Mage::getSingleton('sales/order_'.$this->_entityTypeCode)->getCollection();
        }

        $collection->clear();
        $count = $collection->addAttributeToFilter('increment_id', $this->_incrementId)->count();
        return ($count == 0)? true:false;
    }

    protected function _generateUniqueIncrementId()
    {
        do {
            $this->_incrementInstance->setLastId($this->_incrementId);
            $this->_incrementId = $this->_incrementInstance->getNextId();
        } while (false === $this->_isIncrementIdUinique());
    }

    protected function _appendDefaultNumberConstraint()
    {
        $defaultNumber = intval(Mage::getStoreConfig('mswebdesign_customordernumber/'.$this->_entityTypeCode.'/number', $this->_storeId));
        $currentNumber = $this->_getCurrentNumber();

        if($currentNumber < $defaultNumber) {
            $this->_incrementInstance->setLastId($this->_getIncrementPrefix() . ($defaultNumber - 1));
            $this->_incrementId = $this->_incrementInstance->getNextId();
        }
    }

    /**
     * @return int
     */
    protected function _getCurrentNumber()
    {
        if (strpos($this->_incrementId, $this->_getIncrementPrefix()) === 0) {
            $currentNumber = (int)substr($this->_incrementId, strlen($this->_getIncrementPrefix()));
        } else {
            $currentNumber = (int)$this->_incrementId;
        }

        return $currentNumber;
    }
}