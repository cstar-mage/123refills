<?php
class Jewelerslink_Watches_Block_Adminhtml_Watches extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_watches';
    $this->_blockGroup = 'watches';
    $this->_headerText = Mage::helper('watches')->__('Watches Manager');
    $this->_addButtonLabel = Mage::helper('watches')->__('Manage Watches');
    parent::__construct();
  }
}