<?php
class Jewelerslink_Watches_Block_Watches extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getWatches()     
     { 
        if (!$this->hasData('watches')) {
            $this->setData('watches', Mage::registry('watches'));
        }
        return $this->getData('watches');
        
    }
}