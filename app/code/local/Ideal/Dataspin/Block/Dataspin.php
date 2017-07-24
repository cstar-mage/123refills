<?php
class Ideal_Dataspin_Block_Dataspin extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getDataspin()     
     { 
        if (!$this->hasData('dataspin')) {
            $this->setData('dataspin', Mage::registry('dataspin'));
        }
        return $this->getData('dataspin');
        
    }
}