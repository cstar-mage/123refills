<?php
class Mage_Image2Product_Block_Image2Product extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    } 
    
     public function getImage2Product()     
     { 
        if (!$this->hasData('Image2Product')) {
            $this->setData('Image2Product', Mage::registry('Image2Product'));
        }
        return $this->getData('Image2Product');
        
    }
}
?>