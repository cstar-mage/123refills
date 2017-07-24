<?php
class Mage_Uploadproduct_Block_Uploadproduct extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getUploadproduct()     
     { 
        if (!$this->hasData('uploadproduct')) {
            $this->setData('uploadproduct', Mage::registry('uploadproduct'));
        }
        return $this->getData('uploadproduct');
        
    }
}