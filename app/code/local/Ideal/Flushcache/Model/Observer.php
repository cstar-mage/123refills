<?php

class Ideal_Flushcache_Model_Observer
{
    public function cmsPageSaveAfter()
    {
       $this->flushAllCache();
       return $this;
    }
    
    public function cmsBlockSaveAfter()
    {
    	 $this->flushAllCache();
      	 return $this;
    }
    
    public function flushAllCache() {
    	
    	$types = Mage::app()->getCacheInstance()->getTypes();
    	foreach ($types as $type => $data) {
    		Mage::app()->getCacheInstance()->clean($data["tags"]);
    	}
    	Mage::app()->getCacheInstance()->clean();
    	Mage::getModel('core/design_package')->cleanMergedJsCss();
    	Mage::dispatchEvent('clean_media_cache_after');
    	Mage::getModel('catalog/product_image')->clearCache();
    	
    	return;
    }
    
    public function removeBadGallery() {
    	
    	$resource = Mage::getSingleton('core/resource');
    	$readConnection = $resource->getConnection('core_read');
    	$writeConnection = $resource->getConnection('core_write');
    	
    	$resource->getTableName('catalog/product');
    	//DELETE FROM catalog_product_entity_media_gallery where `entity_id` NOT IN (SELECT entity_id FROM (catalog_product_entity))
    	$query = "DELETE FROM " . $resource->getTableName('catalog_product_entity_media_gallery') . "  where `entity_id` NOT IN (SELECT entity_id FROM (".$resource->getTableName('catalog_product_entity')."))";
    	$writeConnection->query($query);
    	return $this;
    }
}