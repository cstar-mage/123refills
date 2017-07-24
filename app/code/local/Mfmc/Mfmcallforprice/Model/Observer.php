<?php

class Mfmc_mfmcallforprice_Model_Observer
{
    public function catalogProductSaveAfter($observer)
    {
        $product = $observer->getEvent()->getProduct();
        $item = Mage::getModel('mfmcallforprice/mfmcallforprice');
        $item->load($product->getId(), 'product_id');

        $item->setProductId($product->getId());

		$_product = Mage::getModel('catalog/product')->load($product->getId());
        $data = $_product->getData('mfm_cfp');
       
        if($data){
            $item
                ->setHidePrice('1')
                ->setMessage($data)
                ->save();
        }
        else {
            $item->setHidePrice(0)
                ->save();
        }

        return $this;
    }

    public function catalog_product_is_salable_after($observer) {
        $product = $observer->getEvent()->getProduct();
        $object = $observer->getEvent()->getSalable();

        $callForPrice = Mage::getModel('mfmcallforprice/mfmcallforprice')->load($product->getId(), 'product_id');
        if($callForPrice->getHidePrice())  {
            //$html = '<div class="out-of-stock">' . $callForPrice->getMessage() . '</div>';
            //return $html;
            $object->setIsSalable(false);
        }

    }
}
