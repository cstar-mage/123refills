<?php

class Mage_Image2Product_Model_Product_Attribute_Source_Shape extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    public function getAllOptions()
    {
        if (!$this->_options) {
		    $this->_options = array();
            /*array_unshift($this->_options, array('value'=>'', 'label'=>Mage::helper('catalog')->__('Select')));
			array_unshift($this->_options, array('value'=>'ASSCHER', 'label'=>Mage::helper('catalog')->__('ASSCHER')));
			array_unshift($this->_options, array('value'=>'OVAL', 'label'=>Mage::helper('catalog')->__('OVAL')));
			array_unshift($this->_options, array('value'=>'RADIANT', 'label'=>Mage::helper('catalog')->__('RADIANT')));
			array_unshift($this->_options, array('value'=>'ROUND', 'label'=>Mage::helper('catalog')->__('ROUND')));*/
        }
        return $this->_options;
    }
}

?>