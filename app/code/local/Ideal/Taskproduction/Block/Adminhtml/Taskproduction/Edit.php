<?php

class Ideal_Taskproduction_Block_Adminhtml_Taskproduction_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'taskproduction';
        $this->_controller = 'adminhtml_taskproduction';
        
       /* $this->_updateButton('save', 'label', Mage::helper('taskproduction')->__('Save Taskproduction'));
        $this->_updateButton('delete', 'label', Mage::helper('taskproduction')->__('Delete Taskproduction'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit Taskproduction'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);*/

        $this->_removeButton('save');
        $this->_removeButton('delete');
        $this->_removeButton('reset');
        $this->_removeButton('back');
        
        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('taskproduction_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'taskproduction_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'taskproduction_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('taskproduction_data') && Mage::registry('taskproduction_data')->getId() ) {
            return Mage::helper('taskproduction')->__('Edit Task Production');
        } else {
            return Mage::helper('taskproduction')->__('Add Task Production');
        }
    }
}