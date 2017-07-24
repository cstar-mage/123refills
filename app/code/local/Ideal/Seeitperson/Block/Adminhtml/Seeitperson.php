<?php
class Ideal_Seeitperson_Block_Adminhtml_Seeitperson extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_seeitperson';
    $this->_blockGroup = 'seeitperson';
    $this->_headerText = Mage::helper('seeitperson')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('seeitperson')->__('Add Item');
    parent::__construct();
  }
}