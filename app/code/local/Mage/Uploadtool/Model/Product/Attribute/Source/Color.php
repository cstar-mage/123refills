<?php

class Mage_Uploadtool_Model_Product_Attribute_Source_Color extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    public function getAllOptions()
    {
        if (!$this->_options) {
		    $this->_options = array();
            /*array_unshift($this->_options, array('value'=>'', 'label'=>Mage::helper('catalog')->__('Select')));
			array_unshift($this->_options, array('value'=>'D', 'label'=>Mage::helper('catalog')->__('D')));
			array_unshift($this->_options, array('value'=>'E', 'label'=>Mage::helper('catalog')->__('E')));
			array_unshift($this->_options, array('value'=>'F', 'label'=>Mage::helper('catalog')->__('F')));
			array_unshift($this->_options, array('value'=>'G', 'label'=>Mage::helper('catalog')->__('G')));
			array_unshift($this->_options, array('value'=>'H', 'label'=>Mage::helper('catalog')->__('H')));
			array_unshift($this->_options, array('value'=>'I', 'label'=>Mage::helper('catalog')->__('I')));
			array_unshift($this->_options, array('value'=>'J', 'label'=>Mage::helper('catalog')->__('J')));*/
        }
        return $this->_options;
    }
}

?>