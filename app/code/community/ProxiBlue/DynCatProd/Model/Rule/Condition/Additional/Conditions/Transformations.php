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
class ProxiBlue_DynCatProd_Model_Rule_Condition_Additional_Conditions_Transformations
    extends
    ProxiBlue_DynCatProd_Model_Rule_Condition_Additional_Conditions_Combine
{
    /**
     * Internal cached helper object
     *
     * @var object
     */
    protected $_helper = null;

    public function __construct($args)
    {
        parent::__construct($args);
        $this->setType(
            'dyncatprod/rule_condition_additional_conditions_transformations'
        )
            ->setProcessingOrder(999999)
            ->setAggregator('all')
            ->setValue(true);
    }

    /**
     * All salesrules must validate for results
     *
     * @return string
     */
    public function getAggregator()
    {
        return 'all';
    }

    /**
     * All salesrules must validate for results
     *
     * @return string
     */
    public function getValue()
    {
        return true;
    }

    public function asHtml()
    {
        $html = $this->getTypeElement()->getHtml() . $this->getHelper()->__(
                "Filter the resulting data using the following rules:"
            );
        if ($this->getId() != '1') {
            $html .= $this->getRemoveLinkHtml();
        }

        return $html;
    }

    public function getHelper()
    {
        if ($this->_helper == null) {
            $this->_helper = mage::helper('dyncatprod');
        }

        return $this->_helper;
    }

    public function asString($format = '')
    {
        $str = $this->getHelper()->__(
            "Filter the resulting data using the following rules:"
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
                array('value' => 'dyncatprod/rule_condition_additional_conditions_transformations_parents',
                      'label'
                              => $this->getHelper()->__(
                          'If a simple product was found'
                      )),
                array('value' => 'dyncatprod/rule_condition_additional_conditions_transformations_simples',
                      'label'
                              => $this->getHelper()->__(
                          'If a complex product type was found'
                      )),
                array('value' => 'dyncatprod/rule_condition_additional_conditions_transformations_manual',
                      'label'
                              => $this->getHelper()->__(
                          'Remove manually assigned products from this category'
                      )),
                array('value' => 'dyncatprod/rule_condition_additional_conditions_transformations_productsmanual',
                      'label'
                              => $this->getHelper()->__(
                          'Remove manually assigned categories from products'
                      )),
                array('value' => 'dyncatprod/rule_condition_additional_conditions_transformations_saleable',
                      'label'
                              => $this->getHelper()->__(
                          'Check if product is saleable'
                      )),
                array('value' => 'dyncatprod/rule_condition_additional_conditions_transformations_childrencount',
                      'label'
                              => $this->getHelper()->__(
                          'Child product STOCK filter'
                      )),
                array('value' => 'dyncatprod/rule_condition_additional_conditions_transformations_finalprice',
                      'label'
                      => $this->getHelper()->__(
                          'Calculate a product final price...'
                      )),
            )
        );

        return $conditions;
    }

}
