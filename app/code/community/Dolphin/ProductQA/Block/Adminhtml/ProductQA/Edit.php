<?php

class Dolphin_ProductQA_Block_Adminhtml_ProductQA_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'productqa';
        $this->_controller = 'adminhtml_productqa';
        
        $this->_updateButton('save', 'label', Mage::helper('productqa')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('productqa')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('productqa_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'productqa_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'productqa_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('productqa_data') && Mage::registry('productqa_data')->getId() ) {
            return Mage::helper('productqa')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('productqa_data')->getTitle()));
        } else {
            return Mage::helper('productqa')->__('Add Item');
        }
    }
}