<?php
class Ideal_Dcevent_Block_Dcevent extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getDcevent()     
     { 
        if (!$this->hasData('dcevent')) {
            $this->setData('dcevent', Mage::registry('dcevent'));
        }
        return $this->getData('dcevent');
        
    }
}