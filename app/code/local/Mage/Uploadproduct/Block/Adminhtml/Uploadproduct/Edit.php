<?php

class Mage_Uploadproduct_Block_Adminhtml_Uploadproduct_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'uploadproduct';
        $this->_controller = 'adminhtml_uploadproduct';
        
        $this->_updateButton('save', 'label', Mage::helper('uploadproduct')->__('Upload CSV'));
		$this->_removeButton('reset');
		
        $this->_addButton('run_in_popup', array(
           'label'     => Mage::helper('adminhtml')->__('Insert Product In PopUp'),
            'onclick'   => 'window.open(\''.$this->getUrl('adminhtml/uploadproduct/insertinpopup', array('_current'=>true)).'\')',
            'class'     => 'save', 
        ), -100);
        $this->_removeButton('back');
        $data = array(
        		'label' =>  'Back',
        		'onclick'   => 'setLocation(\'' . $this->getUrl('adminhtml/uploadproduct/new') . '\')',
        		'class'     =>  'back'
        );
        $this->addButton ('my_back', $data, 0, 100,  'header');
    }

    public function getHeaderText()
    {
        if( Mage::registry('uploadproduct_data') && Mage::registry('uploadproduct_data')->getId() ) {
            return Mage::helper('uploadproduct')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('uploadproduct_data')->getTitle()));
        } else {
            return Mage::helper('uploadproduct')->__('Upload Product');
        }
    }
}