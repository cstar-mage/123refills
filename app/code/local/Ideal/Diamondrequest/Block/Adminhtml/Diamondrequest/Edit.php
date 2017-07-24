<?php

class Ideal_Diamondrequest_Block_Adminhtml_Diamondrequest_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'diamondrequest';
        $this->_controller = 'adminhtml_diamondrequest';
        
    /*    $this->_updateButton('save', 'label', Mage::helper('diamondrequest')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('diamondrequest')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);*/

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('diamondrequest_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'diamondrequest_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'diamondrequest_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('diamondrequest_data') && Mage::registry('diamondrequest_data')->getId() ) {
            return Mage::helper('diamondrequest')->__("Request Information '%s'", $this->htmlEscape(Mage::registry('diamondrequest_data')->getName()));
        } else {
            return Mage::helper('diamondrequest')->__('Add Item');
        }
    }
}