<?php
class Mage_Uploadtool_Block_Uploadtool extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getUploadtool()     
     { 
        if (!$this->hasData('uploadtool')) {
            $this->setData('uploadtool', Mage::registry('uploadtool'));
        }
        return $this->getData('uploadtool');
        
    }
}