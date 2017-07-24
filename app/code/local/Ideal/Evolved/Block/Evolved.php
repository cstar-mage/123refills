<?php
class Ideal_Evolved_Block_Evolved extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getEvolved()     
     { 
        if (!$this->hasData('evolved')) {
            $this->setData('evolved', Mage::registry('evolved'));
        }
        return $this->getData('evolved');
        
    }
    
    public function getConfig()
    {
    	return Mage::helper('evolved')->getThemeConfig();
    }
    
    public function getBlockConfig($type)
    {
    	return Mage::helper('evolved')->getThemeBlockConfig($type);
    }
}