<?php
class Ideal_Logo_Block_Logo extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getLogo()     
     { 
        if (!$this->hasData('logo')) {
            $this->setData('logo', Mage::registry('logo'));
        }
        return $this->getData('logo');
        
    }
}