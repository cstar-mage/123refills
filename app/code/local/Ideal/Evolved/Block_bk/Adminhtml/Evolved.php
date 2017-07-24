<?php
class Ideal_Evolved_Block_Adminhtml_Evolved extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_evolved';
    $this->_blockGroup = 'evolved';
    $this->_headerText = Mage::helper('evolved')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('evolved')->__('Add Item');
    parent::__construct();
  }
}