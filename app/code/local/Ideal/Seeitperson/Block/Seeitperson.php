<?php
class Ideal_Seeitperson_Block_Seeitperson extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getSeeitperson()     
     { 
        if (!$this->hasData('seeitperson')) {
            $this->setData('seeitperson', Mage::registry('seeitperson'));
        }
        return $this->getData('seeitperson');
        
    }
}