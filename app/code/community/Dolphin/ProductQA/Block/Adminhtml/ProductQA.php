<?php
class Dolphin_ProductQA_Block_Adminhtml_ProductQA extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_productqa';
    $this->_blockGroup = 'productqa';
    $this->_headerText = Mage::helper('productqa')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('productqa')->__('Add Item');
    parent::__construct();
  }
}