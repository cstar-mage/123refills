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
class ProxiBlue_DynCatProd_Model_Rule_Condition_Additional_Conditions_Sorter
    extends
    ProxiBlue_DynCatProd_Model_Rule_Condition_Additional_Conditions_Abstract
{

    protected $_inputType = 'multiselect';

    public function __construct($args)
    {
        parent::__construct($args);
        $this->setType(
            'dyncatprod/rule_condition_additional_conditions_sorter'
        )
            ->setProcessingOrder(9999999999999);
    }

    public function loadOperatorOptions()
    {
        $this->setOperatorOption(
            array(
                Varien_Data_Collection::SORT_ORDER_ASC  => Mage::helper('rule')->__('ASC'),
                Varien_Data_Collection::SORT_ORDER_DESC   => Mage::helper('rule')->__('DESC')
            )
        );

        return $this;
    }


    /**
     * Load value options
     *
     * @return Mage_SalesRule_Model_Rule_Condition_Product_Found
     */
    public function loadValueOptions()
    {
        $productCondition = Mage::getModel('dyncatprod/rule_condition_product');
        $productAttributes = $productCondition->loadAttributeOptions()
            ->getAttributeOption();
        foreach ($productAttributes as $type => $attributeData) {
            if($type == 'normal') {
                foreach ($attributeData as $code => $label) {
                    if (strpos($code, 'quote_item_') !== 0) {
                        $pAttributes[$code] = $label;
                    }
                }
            }
        }

        $this->setValueOption($pAttributes);
        return $this;
    }

    /**
     * Render this as html
     *
     * @return string
     */
    public function asHtml()
    {
        try {
            $html = $this->getTypeElement()->getHtml() .
                Mage::helper('dyncatprod')->__(
                    "Sort the result  %s by product attribute(s)  %s ",
                    $this->getOperatorElement()->getHtml(),
                    $this->getValueElement()->getHtml()
                );
            if ($this->getId() != '1') {
                $html .= $this->getRemoveLinkHtml();
            }
        } catch (Exception $e) {
            return '';
        }

        return $html;
    }

    public function asString($format = '')
    {
        $str
            = Mage::helper('dyncatprod')->__(
            "Sort the result <strong>%s</strong> by product attribute(s) <strong>%s</strong>",
            $this->getOperatorName(),
            implode(',', $this->getValueName())
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
    public function validate(Varien_Object $object)
    {
        $category = $object->getCategory();
        $category->setIgnoreManualPositions(true);

        $collection = $object->getCollection();
        foreach($this->getValue() as $attribute) {
            $collection->setOrder($attribute, $this->getOperator());
        }
        return true;
    }

}
