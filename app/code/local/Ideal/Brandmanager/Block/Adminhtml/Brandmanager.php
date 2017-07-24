<?php
class Ideal_Brandmanager_Block_Adminhtml_Brandmanager extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_brandmanager';
    $this->_blockGroup = 'brandmanager';
    $this->_headerText = Mage::helper('brandmanager')->__('Brand Manager');
    $this->_addButtonLabel = Mage::helper('brandmanager')->__('Add Brand');
    parent::__construct();
  }
}