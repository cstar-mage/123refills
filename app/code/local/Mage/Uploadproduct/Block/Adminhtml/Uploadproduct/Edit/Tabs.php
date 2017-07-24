<?php

class Mage_Uploadproduct_Block_Adminhtml_Uploadproduct_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('uploadproduct_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('uploadproduct')->__('Upload Product Manager'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('uploadproduct')->__('Product'),
          'title'     => Mage::helper('uploadproduct')->__('Product'),
          'content'   => $this->getLayout()->createBlock('uploadproduct/adminhtml_uploadproduct_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}