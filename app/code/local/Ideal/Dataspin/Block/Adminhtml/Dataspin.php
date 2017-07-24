<?php
class Ideal_Dataspin_Block_Adminhtml_Dataspin extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_dataspin';
    $this->_blockGroup = 'dataspin';
    $this->_headerText = Mage::helper('dataspin')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('dataspin')->__('Add Item');
    parent::__construct();
  }
}