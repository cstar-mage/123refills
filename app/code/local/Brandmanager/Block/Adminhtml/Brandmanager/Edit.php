<?php

class Ideal_Brandmanager_Block_Adminhtml_Brandmanager_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'brandmanager';
        $this->_controller = 'adminhtml_brandmanager';
        
        $this->_updateButton('save', 'label', Mage::helper('brandmanager')->__('Save Brand'));
        $this->_updateButton('delete', 'label', Mage::helper('brandmanager')->__('Delete Brand'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('brandmanager_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'brandmanager_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'brandmanager_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('brandmanager_data') && Mage::registry('brandmanager_data')->getId() ) {
            return Mage::helper('brandmanager')->__("Edit Brand '%s'", $this->htmlEscape(Mage::registry('brandmanager_data')->getTitle()));
        } else {
            return Mage::helper('brandmanager')->__('Add Brand');
        }
    }
}