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
class ProxiBlue_DynCatProd_Model_Rule_Condition_Additional_Conditions_Transformations_Finalprice
    extends
    ProxiBlue_DynCatProd_Model_Rule_Condition_Additional_Conditions_Transformations_Abstract
{


    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setType(
            'dyncatprod/rule_condition_additional_conditions_transformations_finalprice'
        )
            ->setValue(null);
        $this->loadActionOptions();
    }

    /**
     * Populate the internal Operator data with accepatble operators
     */
    public function loadOperatorOptions()
    {
        $this->setOperatorOption(
            array(
                '=='  => Mage::helper('rule')->__('is equal to'),
                '!='  => Mage::helper('rule')->__('is not equal to'),
                '>='  => Mage::helper('rule')->__('equals or greater than'),
                '<='  => Mage::helper('rule')->__('equals or less than'),
                '>'   => Mage::helper('rule')->__('greater than'),
                '<'   => Mage::helper('rule')->__('is less than'),
            )
        );

        return $this;
    }

    /**
     *
     *
     * @return object ProxiBlue_DynCatProd_Model_Rule_Condition_Additional_Conditions_Transformations_Parents
     */
    public function loadActionOptions()
    {
        $this->setActionOption(
            array(
                'RF' => Mage::helper('rule')->__('remove the product from the result')

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
            $this->getHelper()->__(
                "If a product final price %s %s, then %s",
                $this->getOperatorElement()->getHtml(),
                $this->getValueElement()->getHtml(),
                $this->getActionElement()->getHtml()
            );
        if ($this->getId() != '1') {
            $html .= $this->getRemoveLinkHtml();
        }

        return $html;
    }


    public function asString($format = '')
    {
        $str = $this->getHelper()->__(
            "If a product final price <strong>%s</strong> %s, then %s",
            $this->getOperatorName(),
            $this->getValueName(),
            $this->getActionName()
        );

        return $str;
    }

    /**
     * Validate
     *
     * Simply place a flag to run this rules vlidateLater method after
     * collection was built.
     *
     * @param $object
     *
     * @return boolean
     */
    public function validate(Varien_Object $object)
    {
        mage::register('transform_by_final_price', $this, true);

        return true;
    }

    /**
     * Get the child data of the given product object
     *
     * @param object $product
     *
     * @return array
     */
    protected function getChildData($product)
    {
        try {
            if (is_object($product)) {
                $finalPrice = $product->getFinalPrice();
                $result = $this->validateAttribute($finalPrice);
                if ($result) {
                    switch ($this->getAction()) {
                        case 'RF': //then remove the product from the result
                            $this->getHelper()->debug(
                                "product {$product->getSku()} removed
                                from result as {$finalPrice} {$this->getOperator()} {$this->getValue()} ",
                                10
                            );
                            break;
                    }
                } else {
                    // not validated so add in the item (works in reverse)
                    $this->_subselectObject->addItem($product->getId());
                }

            }
        } catch (Exception $e) {
            mage::logException($e);
        }
    }

}
