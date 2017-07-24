<?php
class Jewelerslink_Jewelryshare_Block_Adminhtml_Jewelryshare extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_jewelryshare';
    $this->_blockGroup = 'jewelryshare';
    $this->_headerText = Mage::helper('jewelryshare')->__('Jewelry Manager');
    $this->_addButtonLabel = Mage::helper('jewelryshare')->__('Manage Jewelry');
    parent::__construct();
  }
}