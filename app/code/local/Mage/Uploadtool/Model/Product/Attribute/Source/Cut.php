<?php

class Mage_Uploadtool_Model_Product_Attribute_Source_Cut extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    public function getAllOptions()
    {
        if (!$this->_options) {
		    $this->_options = array();
           /* array_unshift($this->_options, array('value'=>'', 'label'=>Mage::helper('catalog')->__('Select')));
			array_unshift($this->_options, array('value'=>'EX', 'label'=>Mage::helper('catalog')->__('EX')));
			array_unshift($this->_options, array('value'=>'G', 'label'=>Mage::helper('catalog')->__('G')));
			array_unshift($this->_options, array('value'=>'ID', 'label'=>Mage::helper('catalog')->__('ID')));
			array_unshift($this->_options, array('value'=>'4', 'label'=>Mage::helper('catalog')->__('option4')));
			array_unshift($this->_options, array('value'=>'VG', 'label'=>Mage::helper('catalog')->__('VG')));*/
        }
        return $this->_options;
    }
}

?>