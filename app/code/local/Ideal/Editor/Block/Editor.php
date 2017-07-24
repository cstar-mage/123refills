<?php
class Ideal_Editor_Block_Editor extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getEditor()     
     { 
        if (!$this->hasData('editor')) {
            $this->setData('editor', Mage::registry('editor'));
        }
        return $this->getData('editor');
        
    }
}