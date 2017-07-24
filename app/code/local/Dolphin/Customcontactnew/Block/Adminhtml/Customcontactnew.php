<?php
class Dolphin_Customcontactnew_Block_Adminhtml_Customcontactnew extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_customcontactnew';
    $this->_blockGroup = 'customcontactnew';
    $this->_headerText = Mage::helper('customcontactnew')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('customcontactnew')->__('Add Item');
    parent::__construct();
    $this->_removeButton('add');
  }
}