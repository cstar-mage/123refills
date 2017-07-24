<?php
class Ideal_Categoryassign_Block_Categoryassign extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    } 
    
     public function getCategoryassign()     
     { 
        if (!$this->hasData('categoryassign')) {
            $this->setData('categoryassign', Mage::registry('categoryassign'));
        }
        return $this->getData('categoryassign');
        
    }
}
?>