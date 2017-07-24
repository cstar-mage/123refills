<?php

class Dolphin_Customcontactnew_Block_Adminhtml_Customcontactnew_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'customcontactnew';
        $this->_controller = 'adminhtml_customcontactnew';
        
    /*    $this->_updateButton('save', 'label', Mage::helper('customcontact')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('customcontact')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);*/

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('customcontactnew_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'customcontactnew_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'customcontactnew_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('customcontactnew_data') && Mage::registry('customcontactnew_data')->getId() ) {
            return Mage::helper('customcontactnew')->__("Request Information '%s'", $this->htmlEscape(Mage::registry('customcontactnew_data')->getTitle()));
        } else {
            return Mage::helper('customcontactnew')->__('Add Item');
        }
    }
}