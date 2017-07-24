<?php

class Ideal_Categoryassign_Block_Adminhtml_Categoryassign extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_categoryassign';
    $this->_blockGroup = 'categoryassign';
    $this->_headerText = Mage::helper('categoryassign')->__('Category Assignment');
    $this->_addButtonLabel = Mage::helper('categoryassign')->__('Category Assignment');
    parent::__construct();
  }
}
?>