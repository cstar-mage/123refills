<?php

class Ideal_Seeitperson_Block_Adminhtml_Seeitperson_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'seeitperson';
        $this->_controller = 'adminhtml_seeitperson';
        
        $this->_updateButton('save', 'label', Mage::helper('seeitperson')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('seeitperson')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('seeitperson_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'seeitperson_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'seeitperson_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('seeitperson_data') && Mage::registry('seeitperson_data')->getId() ) {
            return Mage::helper('seeitperson')->__("Edit Data '%s'", $this->htmlEscape(Mage::registry('seeitperson_data')->getName()));
        } else {
            return Mage::helper('seeitperson')->__('Add Data');
        }
    }
}