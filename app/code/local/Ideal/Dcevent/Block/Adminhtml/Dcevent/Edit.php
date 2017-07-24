<?php

class Ideal_Dcevent_Block_Adminhtml_Dcevent_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'dcevent';
        $this->_controller = 'adminhtml_dcevent';
        
        $this->_updateButton('save', 'label', Mage::helper('dcevent')->__('Save Event'));
        $this->_updateButton('delete', 'label', Mage::helper('dcevent')->__('Delete Event'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit Event'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('dcevent_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'dcevent_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'dcevent_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('dcevent_data') && Mage::registry('dcevent_data')->getId() ) {
            return Mage::helper('dcevent')->__("Edit Event '%s'", $this->htmlEscape(Mage::registry('dcevent_data')->getTitle()));
        } else {
            return Mage::helper('dcevent')->__('Add Event');
        }
    }
}