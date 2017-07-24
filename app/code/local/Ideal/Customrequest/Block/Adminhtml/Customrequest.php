<?php
class Ideal_Customrequest_Block_Adminhtml_Customrequest extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_customrequest';
    $this->_blockGroup = 'customrequest';
    $this->_headerText = Mage::helper('customrequest')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('customrequest')->__('Add Item');
    parent::__construct();
    $this->_removeButton('add');
  }
}