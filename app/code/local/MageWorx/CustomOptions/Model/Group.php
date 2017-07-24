<?php

/**
 * MageWorx
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MageWorx EULA that is bundled with
 * this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.mageworx.com/LICENSE-1.0.html
 *
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@mageworx.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the extension
 * to newer versions in the future. If you wish to customize the extension
 * for your needs please refer to http://www.mageworx.com/ for more information
 * or send an email to sales@mageworx.com
 *
 * @category   MageWorx
 * @package    MageWorx_CustomOptions
 * @copyright  Copyright (c) 2009 MageWorx (http://www.mageworx.com/)
 * @license    http://www.mageworx.com/LICENSE-1.0.html
 */

/**
 * Custom Options extension
 *
 * @category   MageWorx
 * @package    MageWorx_CustomOptions
 * @author     MageWorx Dev Team <dev@mageworx.com>
 */
class MageWorx_CustomOptions_Model_Group extends Mage_Core_Model_Abstract {

    protected function _construct() {
        parent::_construct();
        $this->_init('customoptions/group');
    }

    public function getActiveGruopsIds($store = null) {
        $result = array();
        $collection = $this->getResourceCollection()
                        ->addStoreFilter($store)
                        ->addStatusFilter();

        $items = $collection->getItems();
        if ($items) {
            foreach ($items as $value) {
                $result[] = $value->getGroupId();
            }
        }
        return $result;
    }
    
    public function duplicate() {
        $tablePrefix = (string) Mage::getConfig()->getTablePrefix();
        $table = $tablePrefix . 'custom_options_group';
        $connection = Mage::getSingleton('core/resource')->getConnection('core_write');
        
        $connection->query("INSERT INTO {$table} (title, is_active, store_id, hash_options) 
                    SELECT title, is_active, store_id, hash_options 
                    FROM {$table} 
                    WHERE group_id = '{$this->getId()}'");
                    
        return $connection->lastInsertId();
    }

    public function delete() {
        $hashOptions = unserialize($this->getHashOptions());
        if (is_array($hashOptions) && !empty($hashOptions)) {
            foreach ($hashOptions as $hashOption) {
                Mage::getSingleton('catalog/product_option')->removeOptionFile($this->getId(), $hashOption['id'], false, true);
                @rmdir(Mage::helper('customoptions')->getCustomOptionsPath($this->getId()));
            }
        }

        parent::delete();
    }

    public function getStoreValues($store = null) {
        $result[] = array(
            'label' => Mage::helper('customoptions')->__('None'),
            'value' => ''
        );
        $collection = $this->getResourceCollection()
                        ->addStoreFilter($store)
                        //->addStatusFilter()
                        ->addSortOrder();

        $items = $collection->getItems();
        if ($items) {
            foreach ($items as $value) {
                $result[] = array(
                    'label' => $value->getTitle() . ($value->getIsActive()==2?' (disabled)':''),
                    'value' => $value->getGroupId(),
                );
            }
        } else {
            return '';
        }
        return $result;
    }

}
