<?php

class Ideal_DynamicUrl_Block_Product extends Mage_Core_Block_Template
{
    public function __construct()
    {
//        $this->setTemplate('idealdynamicurl/product.phtml');

        parent::__construct();
    }

    public function getProduct()
    {
        return Mage::registry('dynamic_url_product');
    }

    protected function _toHtml()
    {
        $productInRegistry = Mage::registry('product');
        Mage::unregister('product');

        Mage::register('product', $this->getProduct());

        $productBlock = $this->getLayout()->createBlock('catalog/product_view')->setTemplate('catalog/product/related_view.phtml');
        $addToCartBlock = $this->getLayout()->createBlock('catalog/product_view')->setTemplate('catalog/product/view/related_addtocart.phtml');
        $mediaBlock = $this->getLayout()->createBlock('catalog/product_view_media')->setTemplate('catalog/product/view/media.phtml');
        $productBlock->setChild('addtocart', $addToCartBlock);
        $productBlock->setChild('media', $mediaBlock);

        $blockHtml = $productBlock->toHtml();


        Mage::unregister('product');
        Mage::register('product', $productInRegistry);

        return $blockHtml;
    }
}