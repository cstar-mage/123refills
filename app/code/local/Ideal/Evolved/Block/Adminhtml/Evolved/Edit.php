<?php

class Ideal_Evolved_Block_Adminhtml_Evolved_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'evolved';
        $this->_controller = 'adminhtml_evolved';
        
        $this->_updateButton('save', 'label', Mage::helper('evolved')->__('Save Settings'));
        $this->_removeButton('delete');
        $this->_removeButton('back');
        $this->_removeButton('reset');
        $this->_addButton('generatecss', array(
        		'label'     => Mage::helper('adminhtml')->__('Generate CSS'),
        		'onclick'   => 'generatecss()',
        		'class'     => 'generatecss',
        ), -100);
        
        /* $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100); */

        /* $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('evolved_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'evolved_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'evolved_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        "; */
        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('evolved_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'evolved_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'evolved_content');
                }
            }

            function generatecss(){
			   editForm.submit('".Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB)."idealAdmin/evolved/css');
            }
        ";
    }

    public function getHeaderText()
    {
    	return Mage::helper('evolved')->__('Evolved Theme Settings');
    }
}