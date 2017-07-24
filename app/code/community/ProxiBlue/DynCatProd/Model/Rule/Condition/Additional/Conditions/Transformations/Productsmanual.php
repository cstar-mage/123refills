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
class ProxiBlue_DynCatProd_Model_Rule_Condition_Additional_Conditions_Transformations_Productsmanual
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
            'dyncatprod/rule_condition_additional_conditions_transformations_Productsmanual'
        )
            ->setValue(1);
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
                "For all products found, remove any manually assigned categories."
            );
        if ($this->getId() != '1') {
            $html .= $this->getRemoveLinkHtml();
        }

        return $html;
    }

    public function asString($format = '')
    {
        $str = Mage::helper('dyncatprod')->__(
            "Remove any Manually assigned products (non dynamic) upon save."
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
        $object->getCategory()->setRemoveProductsManualAssigned(true);

        return true;
    }

}
