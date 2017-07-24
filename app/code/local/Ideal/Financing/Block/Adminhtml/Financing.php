<?php
class Ideal_Financing_Block_Adminhtml_Financing extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_financing';
    $this->_blockGroup = 'financing';
    $this->_headerText = Mage::helper('financing')->__('Financing Information Manager');
    //$this->_addButtonLabel = Mage::helper('financing')->__('Add Item');
    parent::__construct();
  }
}