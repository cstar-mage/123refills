<?php
class Jewelerslink_Jewelryshare_Block_Jewelryshare extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getJewelryshare()     
     { 
        if (!$this->hasData('jewelryshare')) {
            $this->setData('jewelryshare', Mage::registry('jewelryshare'));
        }
        return $this->getData('jewelryshare');
        
    }
}