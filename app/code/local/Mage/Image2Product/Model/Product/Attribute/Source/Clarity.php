<?php

class Mage_Image2Product_Model_Product_Attribute_Source_Clarity extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    public function getAllOptions()
    {
        if (!$this->_options) {
		    $this->_options = array();
           /* array_unshift($this->_options, array('value'=>'', 'label'=>Mage::helper('catalog')->__('Select')));
			array_unshift($this->_options, array('value'=>'SI1', 'label'=>Mage::helper('catalog')->__('SI1')));
			array_unshift($this->_options, array('value'=>'SI2', 'label'=>Mage::helper('catalog')->__('SI2')));
			array_unshift($this->_options, array('value'=>'VS2', 'label'=>Mage::helper('catalog')->__('VS2')));
			array_unshift($this->_options, array('value'=>'VS2', 'label'=>Mage::helper('catalog')->__('VS2')));*/
        }
        return $this->_options;
    }
}

?>

