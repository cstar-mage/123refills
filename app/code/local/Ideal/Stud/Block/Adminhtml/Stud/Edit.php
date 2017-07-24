<?php

class Ideal_Stud_Block_Adminhtml_Stud_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'stud';
        $this->_controller = 'adminhtml_stud';
		$this->_removeButton('reset');
		$this->_removeButton('back');
        $this->_updateButton('save', 'label', Mage::helper('stud')->__('Save Rules'));
       
		  }
	  protected function _prepareLayout()
    {
		  return parent::_prepareLayout();
	}
    public function getHeaderText()
    {
		
    }
}