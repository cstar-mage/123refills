<?php

class Mage_Image2Product_Model_Product_Attribute_Source_Polish extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    public function getAllOptions()
    {
        if (!$this->_options) {
		    $this->_options = array();
            /*array_unshift($this->_options, array('value'=>'', 'label'=>Mage::helper('catalog')->__('Select')));
			array_unshift($this->_options, array('value'=>'G', 'label'=>Mage::helper('catalog')->__('G')));
			array_unshift($this->_options, array('value'=>'VG', 'label'=>Mage::helper('catalog')->__('VG')));*/

        }
        return $this->_options;
    }
}

?>