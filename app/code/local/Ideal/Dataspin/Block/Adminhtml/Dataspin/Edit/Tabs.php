<?php

class Ideal_Dataspin_Block_Adminhtml_Dataspin_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('dataspin_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('dataspin')->__('Data Spin'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('dataspin', array(
          'label'     => Mage::helper('dataspin')->__('Data Spin'),
          'title'     => Mage::helper('dataspin')->__('Data Spin'),
          'content'   => $this->getLayout()->createBlock('dataspin/adminhtml_dataspin_edit_tab_dataspin')->toHtml(),
      ));
      
      $this->addTab('dataspin_products', array(
      		'label'     => Mage::helper('dataspin')->__('Select Products'),
      		'title'     => Mage::helper('dataspin')->__('Select Products'),
      		'content'   => $this->getLayout()->createBlock('dataspin/adminhtml_dataspin_edit_tab_products')->toHtml(),
      ));
      
      return parent::_beforeToHtml();
  }

}
