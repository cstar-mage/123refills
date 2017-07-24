<?php
class Ideal_Selldiamond_Block_Selldiamond extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getSelldiamond()     
     { 
        if (!$this->hasData('selldiamond')) {
            $this->setData('selldiamond', Mage::registry('selldiamond'));
        }
        return $this->getData('selldiamond');
        
    }
}