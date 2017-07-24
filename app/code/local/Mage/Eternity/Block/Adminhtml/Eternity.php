<?php
class Mage_Eternity_Block_Adminhtml_Eternity extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_eternity';
    $this->_blockGroup = 'eternity';
    $this->_headerText = Mage::helper('eternity')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('eternity')->__('Add Item');
    parent::__construct();
  }
}