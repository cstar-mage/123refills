<?php
class Mage_Eternity_Block_Eternity extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getEternity()     
     { 
        if (!$this->hasData('eternity')) {
            $this->setData('eternity', Mage::registry('eternity'));
        }
        return $this->getData('eternity');
        
    }
}