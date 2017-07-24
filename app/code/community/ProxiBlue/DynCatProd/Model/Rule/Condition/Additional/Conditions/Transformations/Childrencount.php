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
class ProxiBlue_DynCatProd_Model_Rule_Condition_Additional_Conditions_Transformations_Childrencount
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
            'dyncatprod/rule_condition_additional_conditions_transformations_childrencount'
        )
            ->setValue(null);

    }

    /**
     * Populate the internal Operator data with accepatble operators
     */
    public function loadOperatorOptions()
    {
        $this->setOperatorOption(
            array(
                '==' => Mage::helper('rule')->__('equals to '),
                '>' => Mage::helper('rule')->__('more than '),
                '<' => Mage::helper('rule')->__('less than '),
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
            $this->getHelper()->__(
                "Keep the complex product if it has %s %s child products in stock",
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
            "Keep the complex product if it has %s %s child products in stock",
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
        mage::register('transform_by_count', $this, true);

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
                if (is_object($associatedProducts)) {
                    $inStock = 0;
                    foreach ($associatedProducts as $associatedProduct) {
                        if ($associatedProduct->getIsInStock()) {
                            $inStock++;
                        }
                    }
                    $result = $this->validateAttribute($inStock);
                    if ($result) {
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

}
