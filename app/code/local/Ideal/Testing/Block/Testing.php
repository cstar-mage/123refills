<?php
class Ideal_Testing_Block_Testing extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getTesting()     
     { 
        if (!$this->hasData('testing')) {
            $this->setData('testing', Mage::registry('testing'));
        }
        return $this->getData('testing');
        
    }
}