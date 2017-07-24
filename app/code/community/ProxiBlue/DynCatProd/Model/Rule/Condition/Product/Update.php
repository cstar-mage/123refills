<?php

/**
 *
 *
 * @category  ProxiBlue
 * @package   DynCatProd
 * @author    Lucas van Staden <sales@proxiblue.com.au>
 * @copyright 2016 Lucas van Staden (ProxiBlue)
 * @license   http://www.proxiblue.com.au/eula EULA
 * @link      http://www.proxiblue.com.au
 */
class ProxiBlue_DynCatProd_Model_Rule_Condition_Product_Update
    extends ProxiBlue_DynCatProd_Model_Rule_Condition_Backport
{

    public function __construct($args)
    {
        parent::__construct($args);
        $this->setType('dyncatprod/rule_condition_product_update')
            ->setProcessingOrder('999999999999' . rand(200, 500))
            ->setValue('')
            ->setAggregator('');
    }


    public function loadOperatorOptions()
    {
        $valueOption = ProxiBlue_DynCatProd_Model_Rule_Condition_Product_Abstract::_websiteOptionsList(true);
        $result = array();
        foreach($valueOption as $website => $id) {
            $result[$id] = $website;
        }
        $this->setOperatorOption(
            $result
        );

        return $this;
    }


    public function asHtml()
    {
        $html
            =
            $this->getTypeElement()->getHtml() . Mage::helper('dyncatprod')->__(
                "Update any product(s) found, to have the following attribute values, in the website %s",
                $this->getOperatorElement()->getHtml()
            );
        if ($this->getId() != '1') {
            $html .= $this->getRemoveLinkHtml();
        }

        return $html;
    }

    public function asString($format = '')
    {
        $str
            = Mage::helper('dyncatprod')->__(
            "Update any products found, to have the following attribute values"
        );

        return $str;
    }

    public function getNewChildSelectOptions()
    {
        $productCondition = Mage::getModel(
            'dyncatprod/rule_condition_product_conditions_update'
        );
        $productAttributes = $productCondition->loadAttributeOptions()
            ->getAttributeOption();
        $pAttributes = array();
        foreach ($productAttributes as $code => $label) {
            if (strpos($code, 'quote_item_') !== 0) {
                $pAttributes[] = array('value' =>
                                           'dyncatprod/rule_condition_product_conditions_update|'
                                           . $code,
                                       'label' => $label);
            }
        }

        $conditions = parent::getNewChildSelectOptions();
        $conditions = array_merge_recursive(
            $conditions, array(
                array('label' => Mage::helper('dyncatprod')->__(
                    'Product Attributes'
                ), 'value'    => $pAttributes),
            )
        );

        return $conditions;
    }

    public function validate(Varien_Object $object)
    {
        if (!$this->getConditions()) {
            return true;
        }
        $object->getCollection()->setFlag(
        'attributes_update',
        $this
    );

        return true;
    }

    /**
     * Build the condition array.
     *
     * From v3 this sets a processing order found form the class objects
     * This is set via a constant in the class named 'PROCESSING_ORDER';
     *
     * @param  type $condition
     *
     * @return \ProxiBlue_DynCatProd_Model_Rule_Condition_Product_Found
     */
    public function addCondition($condition)
    {
        $condition->setRule($this->getRule());
        $condition->setObject($this->getObject());
        $condition->setPrefix($this->getPrefix());

        $conditions = $this->getConditions();
        if (array_key_exists(
            $this->getProcessingOrder($condition), $conditions
        )) {
            $condition->setProcessingOrder(
                $this->getProcessingOrder($condition) + 1
            );
        }
        $conditions[$this->getProcessingOrder($condition)] = $condition;
        if (!$condition->getId()) {
            $condition->setId($this->getId() . '--' . sizeof($conditions));
        }
        $this->setData($this->getPrefix(), $conditions);

        return $this;
    }

    protected function getProcessingOrder($condition)
    {
        if ($condition->getProcessingOrder() === false
            || is_null(
                $condition->getProcessingOrder()
            )
        ) {
            $this->_startProcessingorder = $this->_startProcessingorder + 1;
            $condition->setProcessingOrder($this->_startProcessingorder);
        }

        return $condition->getProcessingOrder();
    }

}
