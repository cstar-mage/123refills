<?php

class Mage_Image2Product_Block_Adminhtml_Image2Product extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_Image2Product';
    $this->_blockGroup = 'Image2Product';
    $this->_headerText = Mage::helper('Image2Product')->__('Image to Product Manager');
    $this->_addButtonLabel = Mage::helper('Image2Product')->__('Image to Product');
    parent::__construct();
  }
}
?>