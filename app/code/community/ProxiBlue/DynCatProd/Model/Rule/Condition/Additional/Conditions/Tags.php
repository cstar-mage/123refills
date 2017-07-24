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
class ProxiBlue_DynCatProd_Model_Rule_Condition_Additional_Conditions_Tags
    extends
    ProxiBlue_DynCatProd_Model_Rule_Condition_Additional_Conditions_Combine
{

    public function __construct($args)
    {
        parent::__construct($args);
        $this->setType(
            'dyncatprod/rule_condition_additional_conditions_tags'
        )
            ->setProcessingOrder(200);
    }

    public function asHtml()
    {
        $html
            =
            $this->getTypeElement()->getHtml() . Mage::helper('dyncatprod')->__(
                "Any product that matches the following conditions:",
                $this->getAggregatorElement()->getHtml()
            );
        if ($this->getId() != '1') {
            $html .= $this->getRemoveLinkHtml();
        }

        return $html;
    }

    public function asString($format = '')
    {
        $str = Mage::helper('dyncatprod')->__(
            "<br/>Any product that matches the following conditions:",
            $this->getAggregatorName()
        );

        return $str;
    }

    /**
     * Conditions child rules
     * Current supported:
     * Cart Subtotal
     *
     * @return array
     */
    public function getNewChildSelectOptions()
    {
        $conditions = parent::getNewChildSelectOptions();
        $conditions = array_merge_recursive(
            $conditions, array(
                array('value' => 'dyncatprod/rule_condition_additional_conditions_tags_value',
                      'label' => Mage::helper('dyncatprod')->__(
                          'Specific tag(s)'
                      )),
                array('value' => 'dyncatprod/rule_condition_additional_conditions_tags_popular',
                      'label' => Mage::helper('dyncatprod')->__(
                          'Popular tags'
                      )),
            )
        );

        return $conditions;
    }

}
