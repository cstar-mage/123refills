<?php

/**
 * Catalog Rule Conditions
 *
 * @category  ProxiBlue
 * @package   DynCatProd
 * @author    Lucas van Staden <sales@proxiblue.com.au>
 * @copyright 2016 Lucas van Staden (ProxiBlue)
 * @license   http://www.proxiblue.com.au/eula EULA
 * @link      http://www.proxiblue.com.au
 */
class ProxiBlue_DynCatProd_Model_Rule_Condition_Additional_Conditions_Discount_Catalogrule
    extends
    ProxiBlue_DynCatProd_Model_Rule_Condition_Additional_Conditions_Abstract
{

    protected $_inputType = 'text';
    protected $_subselectObject;

    /**
     * Set rule type
     */
    public function __construct()
    {
        parent::__construct();
        $this->setType(
            'dyncatprod/rule_condition_additional_conditions_discount_catalogrule'
        )
            ->setWebsite(null)
            ->setValue(null)
            ->setConditions(array())
            ->setActions(array());
    }

    /**
     * Populate the internal Operator data with accepatble operators
     */
    public function loadOperatorOptions()
    {
        $this->setOperatorOption(
            array(
                '==' => Mage::helper('rule')->__('equals to '),
                '>'  => Mage::helper('rule')->__('more than '),
                '<'  => Mage::helper('rule')->__('less than '),
                '>=' => Mage::helper('rule')->__('more than or equals to'),
                '<=' => Mage::helper('rule')->__('less than or equals to'),
            )
        );

        return $this;
    }


    /**
     * Render this as html
     *
     * @return string
     */
    public function asHtml()
    {
        $html = $this->getTypeElement()->getHtml() .
            Mage::helper('dyncatprod')->__(
                "If a product has a Catalog Price Rule, for the website(s) %s, which gives %s %s off the product price",
                $this->getWebsiteElement()->getHtml(),
                $this->getOperatorElement()->getHtml(),
                $this->getValueElement()->getHtml()
            );
        if ($this->getId() != '1') {
            $html .= $this->getRemoveLinkHtml();
        }

        return $html;
    }

    public function asString($format = '')
    {
        $str = Mage::helper('dyncatprod')->__(
            "If a product has a Catalog Price Rule applied which gives <strong>%s</strong> "
            . "<strong>%s</strong> off the product price",
            $this->getOperatorName(),
            $this->getValueName()
        );

        return $str;
    }


    /**
     * validate
     *
     * @param  Varien_Object $object Quote
     *
     * @return boolean
     */
    public function _validate(Varien_Object $object)
    {
        $collection = $object->getCollection();
        $this->getHelper()->debug(
            'CATALOG RULE SQL BEFORE: ' . $collection->getSelect(), 5
        );
        $collection->getSelect()->distinct(true);
        $collection->getSelect()->group('e.entity_id');
        $value = $this->getValueParsed();
        $operator = $this->_operatorMapToSql[$this->getOperator()];
        $joinerConditions = " (price_rule_discounts.product_id = e.entity_id) ";
        $conditions = '';
        if (strpos($value, '%') > 0) {
            $value = str_replace('%', '', $value);
            $conditions .= " ( price_rule_discounts.action_operator = '"
                . ProxiBlue_DynCatProd_Model_Rule::BY_PERCENT_ACTION . "' ";
            $conditions .= " OR price_rule_discounts.action_operator = '"
                . ProxiBlue_DynCatProd_Model_Rule::TO_PERCENT_ACTION . "') ";
        } else {
            $conditions .= " ( price_rule_discounts.action_operator = '"
                . ProxiBlue_DynCatProd_Model_Rule::BY_FIXED_ACTION . "' ";
            $conditions .= " OR price_rule_discounts.action_operator = '"
                . ProxiBlue_DynCatProd_Model_Rule::TO_FIXED_ACTION . "') ";
        }
        $storeDate = Mage::app()->getLocale()->storeTimeStamp(
            $this->getStoreId()
        );
        $joinerConditions
            .= " AND (price_rule_discounts.from_time = 0
                    OR price_rule_discounts.from_time <= " . $storeDate . ")
                    AND (price_rule_discounts.to_time = 0
                    OR price_rule_discounts.to_time >= " . $storeDate . ") ";
        $conditions .= " AND (price_rule_discounts.action_amount " . $operator . " " . $value .")";
        $collection->getSelect()->joinInner(
            array('price_rule_discounts' => $collection->getTable(
                'catalogrule/rule_product'
            )), $joinerConditions
        );
        if (is_array($this->getWebsites()) && count($this->getWebsites()) > 0) {
            $collection->getSelect()->joinInner(
                array('price_rule_discounts_website' => $collection->getTable(
                    'catalogrule/website'
                )),
                "price_rule_discounts.rule_id = price_rule_discounts_website.rule_id
            AND price_rule_discounts_website.website_id IN (" . implode(',', $this->getWebsites()) . ")"
            );
        }
        $collection->getSelect()->where($conditions);
        $this->getHelper()->debug(
            'CATALOG RULE SQL Adjusted: ' . $collection->getSelect()
        );


        return true;
    }

    /**
     * Retrieve after element HTML
     *
     * @return string
     */
    public function getValueAfterElementHtml()
    {
        return ' ( use % to indicate percentage discount given )';
    }

}
