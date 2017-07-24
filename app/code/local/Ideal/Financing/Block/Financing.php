<?php
class Ideal_Financing_Block_Financing extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getFinancing()     
     { 
        if (!$this->hasData('financing')) {
            $this->setData('financing', Mage::registry('financing'));
        }
        return $this->getData('financing');
        
    }
}