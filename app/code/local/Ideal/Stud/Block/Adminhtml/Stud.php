<?php
class Ideal_Stud_Block_Adminhtml_Stud extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_stud';
    $this->_blockGroup = 'stud';
    $this->_headerText = Mage::helper('stud')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('stud')->__('Add Item');
    parent::__construct();
  }
}