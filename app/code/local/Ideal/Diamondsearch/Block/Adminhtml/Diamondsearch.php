<?php
class Ideal_Diamondsearch_Block_Adminhtml_Diamondsearch extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_diamondsearch';
    $this->_blockGroup = 'diamondsearch';
    $this->_headerText = Mage::helper('diamondsearch')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('diamondsearch')->__('Add Item');
    parent::__construct();
  }
}