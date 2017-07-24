<?php
class Dolphin_ProductQA_Block_ProductQA extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getProductQA()     
     { 
        if (!$this->hasData('productqa')) {
            $this->setData('productqa', Mage::registry('productqa'));
        }
        return $this->getData('productqa');
        
    }
}