<?php

class Ranvi_Feed_Helper_Data extends Mage_Core_Helper_Abstract{
	
    public function getConfigData($node){
		return Mage::getStoreConfig('ranvi_feed/'.$node);
	}
	
	public function getAllStoreDomains(){
		
		$domains = array();
    	
    	foreach (Mage::app()->getWebsites() as $website) {
    		
    		$url = $website->getConfig('web/unsecure/base_url');
    		
    		if($domain = trim(preg_replace('/^.*?\\/\\/(.*)?\\//', '$1', $url))){
    		
    		$domains[] = $domain;
    		
    		}
    		
    		$url = $website->getConfig('web/secure/base_url');
    		
    		if($domain = trim(preg_replace('/^.*?\\/\\/(.*)?\\//', '$1', $url))){
    		
    		$domains[] = $domain;
    		
    		}
    		
    	}
    	
    	return array_unique($domains);
		
	}


    public function getAmazonContentJson(){
        
        $data = '[{"order":0,"name":"Id","attribute_value":"sku"},{"order":0,"name":"title","attribute_value":"name"},{"order":0,"name":"description","attribute_value":"description"},{"order":0,"name":"link","attribute_value":"url"},{"order":0,"name":"price","attribute_value":"price"},{"order":0,"name":"brand","attribute_value":"brand"},{"order":0,"name":"image_link","attribute_value":"image_link"},{"order":0,"name":"product_type","attribute_value":"product_type"},{"order":0,"name":"condition","attribute_value":"condition"},{"order":0,"name":"availability","attribute_value":"is_in_stock"},{"order":0,"name":"gtin","attribute_value":"gtin"},{"order":0,"name":"google_product_category","attribute_value":"google_product_category"},{"order":0,"name":"shipping_weight","attribute_value":"weight"},{"order":0,"name":"tax","attribute_value":"tax_class_id"},{"order":0,"name":"mpn","attribute_value":"mpn"},{"order":0,"name":"gender","attribute_value":"gender"},{"order":0,"name":"size","attribute_value":"size"},{"order":0,"name":"dispenser","attribute_value":"dispenser"},{"order":0,"name":"p_type","attribute_value":"p_type"},{"order":0,"name":"stock_qty","attribute_value":"qty"},{"order":0,"name":"amazon_price","attribute_value":"amazon_price"}]';
        
        return $data;
        
    }


    public function getGoogleContentJson(){
        
        $data = '[{"order":0,"name":"Id","attribute_value":"sku"},{"order":0,"name":"title","attribute_value":"name"},{"order":0,"name":"description","attribute_value":"description"},{"order":0,"name":"link","attribute_value":"url"},{"order":0,"name":"price","attribute_value":"price"},{"order":0,"name":"brand","attribute_value":"brand"},{"order":0,"name":"condition","attribute_value":"condition"},{"order":0,"name":"image_link","attribute_value":"image_link"},{"order":0,"name":"gtin","attribute_value":"gtin"},{"order":0,"name":"shipping","attribute_value":"shipment_type"},{"order":0,"name":"product_type","attribute_value":"product_type"},{"order":0,"name":"google_product_category","attribute_value":"google_product_category"},{"order":0,"name":"color","attribute_value":"color"},{"order":0,"name":"size","attribute_value":"size"},{"order":0,"name":"mpn","attribute_value":"mpn"},{"order":0,"name":"age group","attribute_value":"age_group"},{"order":0,"name":"gender","attribute_value":"gender"},{"order":0,"name":"availability","attribute_value":"is_in_stock"},{"order":0,"name":"c:druse:boolean","attribute_value":"c_druse"},{"order":0,"name":"item_group_id","attribute_value":"item_group_id"}]';
        
        return $data;
        
    }

}
