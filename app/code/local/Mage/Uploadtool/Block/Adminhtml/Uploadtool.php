<?php
class Mage_Uploadtool_Block_Adminhtml_Uploadtool extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_uploadtool';
    $this->_blockGroup = 'uploadtool';
    $this->_headerText = Mage::helper('uploadtool')->__('Diamond Manager');
    $this->_addButtonLabel = Mage::helper('uploadtool')->__('Add Diamond');
    parent::__construct();
  }
}