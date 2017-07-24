<?php

class Ranvi_Feed_Block_Adminhtml_Items extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_items';
    $this->_blockGroup = 'ranvi_feed';
    $this->_headerText = $this->__('Manage Feeds');
    $this->_addButtonLabel = $this->__('Add Feed');

    parent::__construct();
  }
}