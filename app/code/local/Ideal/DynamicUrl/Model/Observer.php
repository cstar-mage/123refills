<?php

class Ideal_DynamicUrl_Model_Observer
{
    public function layoutGenerateBlocksAfter()
    {
        if (Mage::app()->getStore()->isAdmin()) {
            return;
        }

        $app = Mage::app();

        $urlKey = $app->getRequest()->getParam('pid');

        if (empty($urlKey)) {
            return;
        }

        $productUrlSuffix = Mage::helper('catalog/product')->getProductUrlSuffix();

        $rewrite = Mage::getModel('core/url_rewrite')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->loadByRequestPath($urlKey.$productUrlSuffix);
        $productModel = Mage::getModel('catalog/product');
        $product = $productModel->load($rewrite->getProductId());

        if (empty($product->getId())) {
            $productModel = Mage::getModel('catalog/product');
            $productId = $productModel->getIdBySku($urlKey);
            $product = $productModel->load($productId);
        }

        if (empty($product->getId()) || empty($product->getUrlKey())) {
            return;
        }

        Mage::register('dynamic_url_product', $product);

        Mage::app()->getLayout()->getBlock('content')->insert(
            Mage::app()->getLayout()->createBlock('IdealDynamicUrl/Product'), 'product.info'
        );
    }
}