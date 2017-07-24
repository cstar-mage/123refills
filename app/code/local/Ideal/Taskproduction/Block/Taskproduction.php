<?php
class Ideal_Taskproduction_Block_Taskproduction extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getTaskproduction()     
     { 
        if (!$this->hasData('Taskproduction')) {
            $this->setData('Taskproduction', Mage::registry('Taskproduction'));
        }
        return $this->getData('Taskproduction');
        
    }
}