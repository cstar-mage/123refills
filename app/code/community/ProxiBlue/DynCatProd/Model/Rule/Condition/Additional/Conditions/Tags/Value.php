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
class ProxiBlue_DynCatProd_Model_Rule_Condition_Additional_Conditions_Tags_Value
    extends
    ProxiBlue_DynCatProd_Model_Rule_Condition_Product
{

    protected $_inputType = 'text';

    public function __construct($args)
    {
        parent::__construct($args);
        $this->setType(
            'dyncatprod/rule_condition_additional_conditions_tags_value'
        )
            ->setProcessingOrder(120);
    }

    /**
     * Populate the internal Operator data with acceptable operators
     */
    public function loadOperatorOptions()
    {
        $this->setOperatorOption(
            array(
                '{}' => Mage::helper('rule')->__('is one of'),
                '!{}' => Mage::helper('rule')->__('is not one of')
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
        try {
            $html = $this->getTypeElement()->getHtml() .
                Mage::helper('dyncatprod')->__(
                    "Product tag %s %s",
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
            "Product tag <strong>%s</strong>:<strong>%s</strong>",
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
    public function validate(Varien_Object $object)
    {
        $collection = $object->getCollection();
        $operator = $this->_operatorMapToSql[$this->getOperator()];
        $tagString = $this->getValue();
        $tagString = explode(',', $tagString);
        $collection->joinTable(
            array('tag_relation' => 'tag/relation'), 'product_id = entity_id',
            array('tag_relation_id' => 'tag_relation_id', 'tag_id' => 'tag_id'), null, 'inner'
        );
        $collection->joinTable(
            array('tag' => 'tag/tag'), 'tag_id = tag_id', array('tag_name' => 'name'), null, 'inner'
        );
        $collection->getSelect()->where("tag.name {$operator} (?)", $tagString);
        $collection->getSelect()->where("tag.status = ?", Mage_Tag_Model_Tag::STATUS_APPROVED);

        $select = $object->getCollection()->getSelect();
        $this->getHelper()->debug(
            'TAG SQL: ' . $select, 5
        );

        return true;
    }


}
