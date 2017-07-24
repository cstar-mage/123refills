<?php

class Ideal_Financing_Block_Adminhtml_Financing_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'financing';
        $this->_controller = 'adminhtml_financing';
        
       /* $this->_updateButton('save', 'label', Mage::helper('financing')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('financing')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);*/

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('financing_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'financing_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'financing_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('financing_data') && Mage::registry('financing_data')->getId() ) {
            return Mage::helper('financing')->__("Financing Information '%s'", $this->htmlEscape(Mage::registry('financing_data')->getFirstname()));
        } else {
            return Mage::helper('financing')->__('Financing Information');
        }
    }
}