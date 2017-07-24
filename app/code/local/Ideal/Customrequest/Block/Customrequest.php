<?php
class Ideal_Customrequest_Block_Customrequest extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getCustomrequest()     
     { 
        if (!$this->hasData('customrequest')) {
            $this->setData('customrequest', Mage::registry('customrequest'));
        }
        return $this->getData('customrequest');
        
    }
}