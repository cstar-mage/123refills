<?php

class Mage_Uploadtool_Block_Adminhtml_Uploadtool_Settings extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'uploadtool';
        $this->_controller = 'adminhtml_uploadtool';
		$this->_removeButton('reset');
		$this->_removeButton('back');
        $this->_updateButton('save', 'label', Mage::helper('uploadtool')->__('Save'));
    }

    protected function _prepareLayout()
    {
		  return parent::_prepareLayout();
	}
	
    public function getHeaderText()
    {
		
		return Mage::helper('uploadtool')->__('Jewelerslink Settings');

        /*if( Mage::registry('uploadtool_data') && Mage::registry('uploadtool_data')->getId() ) {
            return Mage::helper('uploadtool')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('uploadtool_data')->getTitle()));
        } else {
            return Mage::helper('uploadtool')->__('Add Item');
        } */
    }
}