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
class ProxiBlue_DynCatProd_Model_Rule_Condition_Additional_Conditions_Transformations_Saleable
    extends
    ProxiBlue_DynCatProd_Model_Rule_Condition_Additional_Conditions_Abstract
{

    protected $_inputType = 'select';

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setType(
            'dyncatprod/rule_condition_additional_conditions_transformations_Saleable'
        )
            ->setValue(1);
    }


    /**
     * Populate the internal Operator data with operators
     *
     * @return object ProxiBlue_DynCatProd_Model_Rule_Condition_Additional_Conditions_Transformations_Saleable
     */
    public function loadOperatorOptions()
    {
        $this->setOperatorOption(
            array(
                '==' => Mage::helper('rule')->__('is'),
                '!=' => Mage::helper('rule')->__('is not'),
            )
        );

        return $this;
    }


    public function getValueSelectOptions()
    {
        $valueOption = ProxiBlue_DynCatProd_Model_Rule_Condition_Product_Abstract::_websiteOptionsList(false);
        $opt = array();
        foreach ($valueOption as $k => $v) {
            $opt[] = array('value' => $v['value'], 'label' => $v['label']);
        }

        return $opt;
    }


    /**
     * Render this as html
     *
     * @return string
     */
    public function asHtml()
    {
        $html = $this->getTypeElement()->getHtml() .
            $this->getDisplayHtml($this->getOperatorElement()->getHtml(), $this->getValueElement()->getHtml());
        if ($this->getId() != '1') {
            $html .= $this->getRemoveLinkHtml();
        }

        return $html;
    }

    public function getDisplayHtml($operator,$value) {
        return $this->getHelper()->__(
            "Check if product %s saleable in %s", $operator, $value
        );
    }

    public function asString($format = '')
    {
        $str = $this->getHelper()->__(
            "If a product <strong>%s</strong> saleable in <strong>%s</strong>",
            $this->getOperatorName(),
            $this->getValue()
        );

        return $str;
    }

    /**
     * validate
     * This is a special case rule.
     *
     * @param  Varien_Object $object Quote
     *
     * @return boolean
     */
    public function validate(Varien_Object $object)
    {
        $object->getCategory()->setCheckSaleableState(
            array('operator' => $this->getOperator(),
                  'website_id'  => $this->getValue())
        );

        return true;
    }

}
