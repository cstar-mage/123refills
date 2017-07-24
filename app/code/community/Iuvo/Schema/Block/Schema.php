<?php
 
class Iuvo_Schema_Block_Schema extends Mage_Core_Block_Template
{
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('iuvo/meta.phtml');
    }
    
    public function getProduct()
    {
    	return Mage::registry('current_product');
    }
    
    public function getNonCachedImage($product) 
    {
		$_image = Mage::getBaseUrl('media') . 'catalog/product' . $product->getImage();;
		return $_image;
    }
    
    public function getProductPrice()
    {
    	$price = $this->getProduct()->getFinalPrice();
    	

/*
    	if($product->getSpecialPrice()) {
    		if(!$product->getSpecialFromDate() && !$product->getSpecialToDate()) {
	    		$price = $product->getSpecialPrice();
    		} else {
	    		$from = strtotime($product->getSpecialFromDate());
	    		$to = strtotime($product->getSpecialToDate());
	    		$curDatetime = strtotime(now());
	    		if($curDatetime > $from && !$product->getSpecialToDate()) {
		    		$price = $product->getSpecialPrice();
	    		} elseif($curDatetime > $from && $curDatetime < $to) {
		    		$price = $product->getSpecialPrice();
	    		} else {
		    		$price = $product->getPrice();
	    		}
    		}
    	} else {
    		$price = $product->getPrice();
    	}
*/
    	//$price = preg_replace("/[^0-9.]/", "", strip_tags(Mage::helper('core')->currency($price)));
    	//$price = number_format($price, 2);
    	return $price;
    }
    
    public function getProductDescription($_product)
    {
    	if(Mage::getStoreConfig('catalog/schema/desc')) {
    		return nl2br($_product->getDescription());
    	} else {
    		return nl2br($_product->getShortDescription());
    	}	
    }
    
    public function getReviewSummary()
    {
    	$storeId = Mage::app()->getStore()->getId();

		$summaryData = Mage::getModel('review/review_summary')
			->setStoreId($storeId)
			->load($this->getProduct()->getId());
		return $summaryData;
    }
    
    public function getBreadcrumbs()
    {
    	return Mage::helper('catalog')->getBreadcrumbPath();
    }
    
    public function getCurrencyCode()
    {
        return Mage::app()->getStore()-> getCurrentCurrencyCode();
    }
}