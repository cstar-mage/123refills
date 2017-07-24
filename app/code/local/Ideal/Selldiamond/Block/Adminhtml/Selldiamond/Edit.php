<?php

class Ideal_Selldiamond_Block_Adminhtml_Selldiamond_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'selldiamond';
        $this->_controller = 'adminhtml_selldiamond';
        
        /*$this->_updateButton('save', 'label', Mage::helper('selldiamond')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('selldiamond')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);*/

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('selldiamond_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'selldiamond_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'selldiamond_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('selldiamond_data') && Mage::registry('selldiamond_data')->getId() ) {
            //return Mage::helper('selldiamond')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('selldiamond_data')->getTitle()));
        } else {
            //return Mage::helper('selldiamond')->__('Add Item');
        }
    }
}