<?php

class Mage_Uploadtool_Model_Product_Attribute_Source_Cutlet extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    public function getAllOptions()
    {
        if (!$this->_options) {
		    $this->_options = array();
            /*array_unshift($this->_options, array('value'=>'', 'label'=>Mage::helper('catalog')->__('Select')));
			array_unshift($this->_options, array('value'=>'N', 'label'=>Mage::helper('catalog')->__('N')));
			array_unshift($this->_options, array('value'=>'S', 'label'=>Mage::helper('catalog')->__('S')));
			array_unshift($this->_options, array('value'=>'VS', 'label'=>Mage::helper('catalog')->__('VS')));*/
        }
        return $this->_options;
    }
}

?>