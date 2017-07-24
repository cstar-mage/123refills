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
class ProxiBlue_DynCatProd_Model_Rule_Condition_Additional_Conditions_Transformations_Parents
    extends
    ProxiBlue_DynCatProd_Model_Rule_Condition_Additional_Conditions_Transformations_Abstract
{

    protected $_inputType = 'select';

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setType(
            'dyncatprod/rule_condition_additional_conditions_transformations_parents'
        )
            ->setValue(null);
    }

    /**
     * Populate the internal Operator data with accepatble operators
     *
     * @return object ProxiBlue_DynCatProd_Model_Rule_Condition_Additional_Conditions_Transformations_Parents
     */
    public function loadOperatorOptions()
    {
        $this->setOperatorOption(
            array(
                'RS' => Mage::helper('rule')->__('then replace it with '),
                '+C' => Mage::helper('rule')->__(
                    'then add the simple and also add '
                ),
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
                "If a simple product was found %s %s",
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
        $str = $this->getHelper()->__(
            "If a simple product was found <strong>%s %s</strong>",
            $this->getOperatorName(),
            $this->getValueName()
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
        mage::register('transform_parents', $this ,true);
        return true;
    }

    /**
     * Get the parent data of the given product object
     *
     * @param object $product
     *
     * @return array
     */
    protected function getChildData($product)
    {
        try {
            if (is_object($product)) {
                if ($product->getTypeId()
                    == Mage_Catalog_Model_Product_Type::TYPE_SIMPLE
                ) {
                    $parentIds = Mage::getModel(
                        'catalog/product_type_configurable'
                    )
                        ->getParentIdsByChild(
                            $product->getId()
                        ); //check for config product
                    if (!$parentIds) {
                        $parentIds = Mage::getModel(
                            'catalog/product_type_grouped'
                        )
                            ->getParentIdsByChild(
                                $product->getId()
                            ); // check for grouped product
                    }
                    if ($parentIds) {
                        //some simples belong to multiple parents, so make sure they are all singular entries.
                        if (count($parentIds) > 1) {
                            mage::helper('dyncatprod')->debug(
                                'Found multiple parents for child '
                                . $product->getId(),
                                5
                            );
                            foreach ($parentIds as $parentId) {
                                $this->_subselectObject->addItem($parentId);
                            }
                        } else {
                            $parentId = array_pop($parentIds);
                            $this->_subselectObject->addItem($parentId);
                        }
                        if ($this->getOperator() != 'RS') {
                            mage::helper('dyncatprod')->debug(
                                'simple '
                                . $product->getId()
                                . ' was placed back after parent',
                                10
                            );
                            $this->_subselectObject->addItem($product->getId());
                        }
                    } else {
                        $this->_subselectObject->addItem($product->getId());
                    }
                } else {
                    $this->_subselectObject->addItem($product->getId());
                }
            }
        } catch (Exception $e) {
            mage::logException($e);
        }
    }

    /**
     * Populate the available Value options for the rule in admin
     *
     * @return \ProxiBlue_DynCatProd_Model_Rule_Condition_Additional_Conditions_Transformations_Parents
     */
    public function loadValueOptions()
    {
        $this->setValueOption(
            array(
                'parent' => Mage::helper('rule')->__(
                    'Configurable or Group Parent Product'
                )
            )
        );

        return $this;
    }

}
