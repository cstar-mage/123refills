<?php

class Dolphin_ProductQA_Block_Adminhtml_ProductQA_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('productqa_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('productqa')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('productqa')->__('Item Information'),
          'title'     => Mage::helper('productqa')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('productqa/adminhtml_productqa_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}