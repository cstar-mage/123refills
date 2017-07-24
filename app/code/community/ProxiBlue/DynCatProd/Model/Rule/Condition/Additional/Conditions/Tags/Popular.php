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
class ProxiBlue_DynCatProd_Model_Rule_Condition_Additional_Conditions_Tags_Popular
    extends
    ProxiBlue_DynCatProd_Model_Rule_Condition_Product
{

    protected $_inputType = 'text';

    public function __construct($args)
    {
        parent::__construct($args);
        $this->setType(
            'dyncatprod/rule_condition_additional_conditions_tags_popular'
        )
            ->setProcessingOrder(121);
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
                    "Products by the top %s popular tags",
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
            "Product by the top %s popular tags",
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
        $popular_tags = array();
        $tags = Mage::getModel('tag/tag')->getPopularCollection()
            ->joinFields(Mage::app()->getStore()->getId())
            ->load($this->getValue())
            ->getItems();

        if (count($tags) == 0) {
            return false;
        }

        $_maxPopularity = reset($tags)->getPopularity();
        $_minPopularity = end($tags)->getPopularity();
        $range = $_maxPopularity - $_minPopularity;
        $range = ($range == 0) ? 1 : $range;
        foreach ($tags as $tag) {
            $tag->setRatio(($tag->getPopularity() - $_minPopularity) / $range);
            $popular_tags[] = $tag->getTagId();
        }

        $collection = $object->getCollection();
        $collection->joinTable(
            array('tag_relation' => 'tag/relation'), 'product_id = entity_id',
            array('tag_relation_id' => 'tag_relation_id', 'tag_id' => 'tag_id'), null, 'inner'
        );
        $collection->joinTable(
            array('tag' => 'tag/tag'), 'tag_id = tag_id', array('tag_name' => 'name'), null, 'inner'
        );
        $collection->getSelect()->where("tag.tag_id IN (?)", $popular_tags);
        $collection->getSelect()->where("tag.status = ?", Mage_Tag_Model_Tag::STATUS_APPROVED);
        $select = $object->getCollection()->getSelect();
        $this->getHelper()->debug(
            'TAG POPULAR SQL: ' . $select, 5
        );

        return true;
    }


}
