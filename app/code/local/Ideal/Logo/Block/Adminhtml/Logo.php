<?php
class Ideal_Logo_Block_Adminhtml_Logo extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_logo';
    $this->_blockGroup = 'logo';
    $this->_headerText = Mage::helper('logo')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('logo')->__('Add Item');
    parent::__construct();
  }
}