<?php
class Ideal_Taskproduction_Block_Adminhtml_Taskproduction extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_taskproduction';
    $this->_blockGroup = 'taskproduction';
    $this->_headerText = Mage::helper('taskproduction')->__('Tickets');
    $this->_addButtonLabel = Mage::helper('taskproduction')->__('Tickets');
    parent::__construct();
    $this->_removeButton('add');
  }
}