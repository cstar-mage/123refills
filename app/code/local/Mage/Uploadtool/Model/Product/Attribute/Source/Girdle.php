<?php

class Mage_Attributecreator_Model_Product_Attribute_Source_Girdle extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    public function getAllOptions()
    {
        if (!$this->_options) {
		    $this->_options = array();
           /* array_unshift($this->_options, array('value'=>'', 'label'=>Mage::helper('catalog')->__('Select')));
			array_unshift($this->_options, array('value'=>'M-STK-FAC', 'label'=>Mage::helper('catalog')->__('M-STK  FAC')));
			array_unshift($this->_options, array('value'=>'M-TK-FAC', 'label'=>Mage::helper('catalog')->__('M-TK  FAC')));
			array_unshift($this->_options, array('value'=>'TN-TK-FAC', 'label'=>Mage::helper('catalog')->__('TN-TK  FAC')));
			array_unshift($this->_options, array('value'=>'VTN-STK-POL', 'label'=>Mage::helper('catalog')->__('VTN-STK  POL')));*/
	}
        return $this->_options;
    }
}

?>