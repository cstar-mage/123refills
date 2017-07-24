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
class ProxiBlue_DynCatProd_Model_Rule_Condition_Additional_Conditions_Transformations_Simples
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
            'dyncatprod/rule_condition_additional_conditions_transformations_simples'
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
                '+A' => Mage::helper('rule')->__(
                    'then also add its associated products'
                ),
                '+R' => Mage::helper('rule')->__(
                    'then replace it with its associated products'
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
                "If a complex product type was found %s",
                $this->getOperatorElement()->getHtml()
            );
        if ($this->getId() != '1') {
            $html .= $this->getRemoveLinkHtml();
        }

        return $html;
    }

    public function asString($format = '')
    {
        $str = Mage::helper('dyncatprod')->__(
            "If a complex product type was found <strong>%s</strong>",
            $this->getOperatorName()
        );

        return $str;
    }

    /**
     * Validate
     *
     * Simply place a flag to run this rules validatelater method after
     * collection was built.
     *
     * @param type $object
     *
     * @return boolean
     */
    public function validate(Varien_Object $object)
    {
        mage::register('transform_simples', $this ,true);
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
                switch ($product->getTypeId()) {
                    case Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE:
                        $conf = Mage::getModel(
                            'catalog/product_type_configurable'
                        )->setProduct($product);
                        $associatedProducts = $conf->getUsedProductCollection()
                            ->addAttributeToSelect('*')
                            ->addFilterByRequiredOptions();
                        break;
                    case Mage_Catalog_Model_Product_Type::TYPE_GROUPED:
                        $associatedProducts = $product->getTypeInstance(true)
                            ->getAssociatedProducts($product);
                        break;
                    case Mage_Catalog_Model_Product_Type::TYPE_BUNDLE:
                        $associatedProducts = $product->getTypeInstance(true)
                            ->getSelectionsCollection(
                                $product->getTypeInstance(true)->getOptionsIds(
                                    $product
                                ), $product
                            );
                        break;
                    default:
                        $associatedProducts = array();
                        $this->_subselectObject->addItem($product->getId());
                        break;
                }
                foreach ($associatedProducts as $associatedProduct) {
                    $this->_subselectObject->addItem(
                        $associatedProduct->getId()
                    );
                }
                if ($this->getOperator() == '+A') {
                    $this->_subselectObject->addItem($product->getId());
                }
            }
        } catch (Exception $e) {
            mage::logException($e);
        }
    }

}
