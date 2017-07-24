<?php
class Ideal_Selldiamond_Block_Adminhtml_Selldiamond extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_selldiamond';
    $this->_blockGroup = 'selldiamond';
    $this->_headerText = Mage::helper('selldiamond')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('selldiamond')->__('Add Item');
    parent::__construct();
  }
}