<?php
/**
 *  Dynamic Products rule
 *
 * @category  ProxiBlue
 * @package   DynCatProd
 * @author    Lucas van Staden <sales@proxiblue.com.au>
 * @copyright 2016 Lucas van Staden (ProxiBlue)
 * @license   http://www.proxiblue.com.au/eula EULA
 * @link      http://www.proxiblue.com.au
 */
abstract class ProxiBlue_DynCatProd_Model_Compatibility_Rule_Abstract extends Mage_Core_Model_Abstract
{
    /**
     * Store rule combine conditions model
     *
     * @var Mage_Rule_Model_Condition_Combine
     */
    protected $_conditions;

    /**
     * Store rule actions model
     *
     * @var Mage_Rule_Model_Action_Collection
     */
    protected $_actions;

    /**
     * Store rule form instance
     *
     * @var Varien_Data_Form
     */
    protected $_form;

    /**
     * Is model can be deleted flag
     *
     * @var bool
     */
    protected $_isDeleteable = true;

    /**
     * Is model readonly
     *
     * @var bool
     */
    protected $_isReadonly = false;

    /**
     * Getter for rule combine conditions instance
     *
     * @return Mage_Rule_Model_Condition_Combine
     */
    abstract public function getConditionsInstance();

    /**
     * Negates actions for this object
     *
     * @return string
     */
    public function getActionsInstance()
    {
        return 'No Actions'; // no actions in Dynamic Rules
    }


    /**
     * Prepare select for condition
     *
     * @param int $storeId
     * @return Varien_Db_Select
     */
    public function getProductFlatSelect($storeId)
    {
        /** @var $resource Mage_Rule_Model_Resource_Abstract */
        $resource = $this->getResource();

        return $resource->getProductFlatSelect($storeId, $this->getConditions());
    }

    /**
     * Prepare data before saving
     *
     * @return ProxiBlue_DynCatProd_Model_Compatibility_Rule_Abstract
     */
    protected function _beforeSave()
    {
        // Check if discount amount not negative
        if ($this->hasDiscountAmount()) {
            if ((int)$this->getDiscountAmount() < 0) {
                Mage::throwException(Mage::helper('rule')->__('Invalid discount amount.'));
            }
        }

        // Serialize conditions
        if ($this->getConditions()) {
            $this->setConditionsSerialized(serialize($this->getConditions()->asArray()));
            $this->unsConditions();
        }

        // Serialize actions
        if ($this->getActions()) {
            $this->setActionsSerialized(serialize($this->getActions()->asArray()));
            $this->unsActions();
        }

        /**
         * Prepare website Ids if applicable and if they were set as string in comma separated format.
         * Backwards compatibility.
         */
        if ($this->hasWebsiteIds()) {
            $websiteIds = $this->getWebsiteIds();
            if (is_string($websiteIds) && !empty($websiteIds)) {
                $this->setWebsiteIds(explode(',', $websiteIds));
            }
        }

        /**
         * Prepare customer group Ids if applicable and if they were set as string in comma separated format.
         * Backwards compatibility.
         */
        if ($this->hasCustomerGroupIds()) {
            $groupIds = $this->getCustomerGroupIds();
            if (is_string($groupIds) && !empty($groupIds)) {
                $this->setCustomerGroupIds(explode(',', $groupIds));
            }
        }

        parent::_beforeSave();
        return $this;
    }

    /**
     * Set rule combine conditions model
     *
     * @param Mage_Rule_Model_Condition_Combine $conditions
     *
     * @return ProxiBlue_DynCatProd_Model_Compatibility_Rule_Abstract
     */
    public function setConditions($conditions)
    {
        $this->_conditions = $conditions;
        return $this;
    }

    /**
     * Retrieve rule combine conditions model
     *
     * @return Mage_Rule_Model_Condition_Combine
     */
    public function getConditions()
    {
        if (empty($this->_conditions)) {
            $this->_resetConditions();
        }

        // Load rule conditions if it is applicable
        if ($this->hasConditionsSerialized()) {
            $conditions = $this->getConditionsSerialized();
            if (!empty($conditions)) {
                $conditions = unserialize($conditions);
                if (is_array($conditions) && !empty($conditions)) {
                    $this->_conditions->loadArray($conditions);
                }
            }
            $this->unsConditionsSerialized();
        }

        return $this->_conditions;
    }

    /**
     * Set rule actions model
     *
     * @param Mage_Rule_Model_Action_Collection $actions
     *
     * @return ProxiBlue_DynCatProd_Model_Compatibility_Rule_Abstract
     */
    public function setActions($actions)
    {
        $this->_actions = $actions;
        return $this;
    }

    /**
     * Retrieve rule actions model
     *
     * @return Mage_Rule_Model_Action_Collection
     */
    public function getActions()
    {
        if (!$this->_actions) {
            $this->_resetActions();
        }

        // Load rule actions if it is applicable
        if ($this->hasActionsSerialized()) {
            $actions = $this->getActionsSerialized();
            if (!empty($actions)) {
                $actions = unserialize($actions);
                if (is_array($actions) && !empty($actions)) {
                    $this->_actions->loadArray($actions);
                }
            }
            $this->unsActionsSerialized();
        }

        return $this->_actions;
    }

    /**
     * Reset rule combine conditions
     *
     * @param null|Mage_Rule_Model_Condition_Combine $conditions
     *
     * @return Mage_Rule_Model_Abstract
     */
    protected function _resetConditions(
        $conditions = null
    ) {
        if (is_null($conditions)) {
            $conditions = $this->getConditionsInstance();
        }
        $conditions->setRule($this)->setId('1');
        $this->setConditions($conditions);

        return $this;
    }

    /**
     * Reset rule actions
     *
     * @param null|Mage_Rule_Model_Action_Collection $actions
     *
     * @return ProxiBlue_DynCatProd_Model_Compatibility_Rule_Abstract
     */
    protected function _resetActions($actions = null)
    {
        if (is_null($actions)) {
            $actions = $this->getActionsInstance();
        }
        $actions->setRule($this)->setId('1')->setPrefix('actions');
        $this->setActions($actions);

        return $this;
    }

    /**
     * Rule form getter
     *
     * @return Varien_Data_Form
     */
    public function getForm()
    {
        if (!$this->_form) {
            $this->_form = new Varien_Data_Form();
        }
        return $this->_form;
    }

    /**
     * Initialize rule model data from array.
     * Set store labels if applicable.
     *
     * @param array $conditions Array holding the conditions
     *
     * @return Mage_SalesRule_Model_Rule
     */
    public function loadPost($conditions)
    {
        $arr = $this->_convertFlatToRecursive(
            array('conditions' => $conditions)
        );
        if (isset($arr['conditions'])) {
            if (array_key_exists("1", $arr['conditions'])) {
                $this->getConditions()->setConditions(array())->loadArray(
                    $arr['conditions'][1]
                );
            }
        }

        return $this;
    }

    /**
     * Set specified data to current rule.
     * Set conditions and actions recursively.
     * Convert dates into Zend_Date.
     *
     * @param array $data
     *
     * @return array
     */
    protected function _convertFlatToRecursive(array $data)
    {
        $arr = array();
        foreach ($data as $key => $value) {
            if (($key === 'conditions' || $key === 'actions') && is_array($value)) {
                foreach ($value as $id=>$data) {
                    $path = explode('--', $id);
                    $node =& $arr;
                    for ($i=0, $l=sizeof($path); $i<$l; $i++) {
                        if (!isset($node[$key][$path[$i]])) {
                            $node[$key][$path[$i]] = array();
                        }
                        $node =& $node[$key][$path[$i]];
                    }
                    foreach ($data as $k => $v) {
                        $node[$k] = $v;
                    }
                }
            } else {
                /**
                 * Convert dates into Zend_Date
                 */
                if (in_array($key, array('from_date', 'to_date')) && $value) {
                    $value = Mage::app()->getLocale()->date(
                        $value,
                        Varien_Date::DATE_INTERNAL_FORMAT,
                        null,
                        false
                    );
                }
                $this->setData($key, $value);
            }
        }

        return $arr;
    }

    /**
     * Validate rule conditions to determine if rule can run
     *
     * @param Varien_Object $object
     *
     * @return bool
     */
    public function validate(Varien_Object $object)
    {
        return $this->getConditions()->validate($object);
    }

    /**
     * Validate rule data
     *
     * @param Varien_Object $object
     *
     * @return bool|array - return true if validation passed successfully. Array with errors description otherwise
     */
    public function validateData(Varien_Object $object)
    {
        $result   = array();
        $fromDate = $toDate = null;

        if ($object->hasFromDate() && $object->hasToDate()) {
            $fromDate = $object->getFromDate();
            $toDate = $object->getToDate();
        }

        if ($fromDate && $toDate) {
            $fromDate = new Zend_Date($fromDate, Varien_Date::DATE_INTERNAL_FORMAT);
            $toDate = new Zend_Date($toDate, Varien_Date::DATE_INTERNAL_FORMAT);

            if ($fromDate->compare($toDate) === 1) {
                $result[] = Mage::helper('rule')->__('End Date must be greater than Start Date.');
            }
        }

        if ($object->hasWebsiteIds()) {
            $websiteIds = $object->getWebsiteIds();
            if (empty($websiteIds)) {
                $result[] = Mage::helper('rule')->__('Websites must be specified.');
            }
        }
        if ($object->hasCustomerGroupIds()) {
            $customerGroupIds = $object->getCustomerGroupIds();
            if (empty($customerGroupIds)) {
                $result[] = Mage::helper('rule')->__('Customer Groups must be specified.');
            }
        }

        return !empty($result) ? $result : true;
    }

    /**
     * Check availability to delete rule
     *
     * @return bool
     */
    public function isDeleteable()
    {
        return $this->_isDeleteable;
    }

    /**
     * Set is rule can be deleted flag
     *
     * @param bool $value
     *
     * @return ProxiBlue_DynCatProd_Model_Compatibility_Rule_Abstract
     */
    public function setIsDeleteable($value)
    {
        $this->_isDeleteable = (bool) $value;
        return $this;
    }

    /**
     * Check if rule is readonly
     *
     * @return bool
     */
    public function isReadonly()
    {
        return $this->_isReadonly;
    }

    /**
     * Set is readonly flag to rule
     *
     * @param bool $value
     *
     * @return ProxiBlue_DynCatProd_Model_Compatibility_Rule_Abstract
     */
    public function setIsReadonly($value)
    {
        $this->_isReadonly = (bool) $value;
        return $this;
    }

    /**
     * Get rule associated website Ids
     *
     * @return array
     */
    public function getWebsiteIds()
    {
        if (!$this->hasWebsiteIds()) {
            $websiteIds = $this->_getResource()->getWebsiteIds($this->getId());
            $this->setData('website_ids', (array)$websiteIds);
        }
        return $this->_getData('website_ids');
    }


    public function asString($format = '')
    {
        $str = $this->getConditions()->asStringRecursive();

        return nl2br($str);
    }


    /**
     * @deprecated since 1.7.0.0
     *
     * @return string
     */
    public function asHtml()
    {
        return '';
    }

    /**
     * Returns rule as an array for admin interface
     *
     * @deprecated since 1.7.0.0
     *
     * @param array $arrAttributes
     *
     * @return array
     */
    public function asArray(array $arrAttributes = array())
    {
        return array();
    }

    /**
     * Combine website ids to string
     *
     * @deprecated since 1.7.0.0
     *
     * @return ProxiBlue_DynCatProd_Model_Compatibility_Rule_Abstract
     */
    protected function _prepareWebsiteIds()
    {
        return $this;
    }
}
