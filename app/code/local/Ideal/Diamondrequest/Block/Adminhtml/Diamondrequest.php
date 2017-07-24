<?php
class Ideal_Diamondrequest_Block_Adminhtml_Diamondrequest extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_diamondrequest';
    $this->_blockGroup = 'diamondrequest';
    $this->_headerText = Mage::helper('diamondrequest')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('diamondrequest')->__('Add Item');
    parent::__construct();
    $this->_removeButton('add');
  }
}