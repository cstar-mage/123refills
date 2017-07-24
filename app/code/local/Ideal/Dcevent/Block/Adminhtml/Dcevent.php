<?php
class Ideal_Dcevent_Block_Adminhtml_Dcevent extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_dcevent';
    $this->_blockGroup = 'dcevent';
    $this->_headerText = Mage::helper('dcevent')->__('Event Manager');
    $this->_addButtonLabel = Mage::helper('dcevent')->__('Add Event');
    parent::__construct();
  }
}