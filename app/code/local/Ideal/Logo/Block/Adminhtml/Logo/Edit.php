<?php

class Ideal_Logo_Block_Adminhtml_Logo_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'logo';
        $this->_controller = 'adminhtml_logo';
        
        //$this->_updateButton('save', 'label', Mage::helper('logo')->__('Save Logo'));
        //$this->_removeButton('save');
        $this->_removeButton('delete');
        $this->_removeButton('reset');
        $this->_removeButton('back');
        
        $this->_addButton('save', array(
        		'label'     => Mage::helper('adminhtml')->__('Save Logo'),
        		'onclick'   => 'editForm.submit()',
        		'class'     => 'save',
        ),-1,1,'footer');
        
    }

    public function getHeaderText()
    {
		return Mage::helper('logo')->__('Add / Update Logo');
    }
}