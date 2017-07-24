<?php
/**
 * @copyright   Copyright (c) 2009-2012 Amasty (http://www.amasty.com)
 */  
class Amasty_Finder_Model_Value extends Mage_Core_Model_Abstract
{
    public function _construct()
    {    
        $this->_init('amfinder/value');
    }
    
    public function saveAfterEdit($newId,$id,$sku)
    {
        return $this->getResource()->saveAfterEdit($newId,$id,$sku);      
    }
    
    public function getSkuById($newId ,$id)
    {
        return $this->getResource()->getSkuById($newId, $id);    
    } 
    
    public function saveNewFinder($data)
    {
        return $this->getResource()->saveNewFinder($data);           
    }        
}