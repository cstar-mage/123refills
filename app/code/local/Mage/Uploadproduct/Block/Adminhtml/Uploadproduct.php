<?php
class Mage_Uploadproduct_Block_Adminhtml_Uploadproduct extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_uploadproduct';
    $this->_blockGroup = 'uploadproduct';
    $this->_headerText = Mage::helper('uploadproduct')->__('Upload Product Manager');
    $this->_addButtonLabel = Mage::helper('uploadproduct')->__('Upload Product');
    parent::__construct();
  }
}