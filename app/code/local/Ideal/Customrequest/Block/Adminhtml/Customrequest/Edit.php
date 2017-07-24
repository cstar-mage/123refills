<?php

class Ideal_Customrequest_Block_Adminhtml_Customrequest_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'customrequest';
        $this->_controller = 'adminhtml_customrequest';
        
        $this->_updateButton('save', 'label', Mage::helper('customrequest')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('customrequest')->__('Delete Item'));
		
//         $this->_addButton('saveandcontinue', array(
//             'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
//             'onclick'   => 'saveAndContinueEdit()',
//             'class'     => 'save',
//         ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('customrequest_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'customrequest_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'customrequest_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('customrequest_data') && Mage::registry('customrequest_data')->getId() ) {
            return Mage::helper('customrequest')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('customrequest_data')->getName()));
        } else {
            return Mage::helper('customrequest')->__('Add Item');
        }
    }
}