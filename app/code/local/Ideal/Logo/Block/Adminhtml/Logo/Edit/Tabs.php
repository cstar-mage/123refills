<?php

class Ideal_Logo_Block_Adminhtml_Logo_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('logo_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('logo')->__('Logo'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('logo')->__('Logo Information'),
          'title'     => Mage::helper('logo')->__('Logo Information'),
          'content'   => $this->getLayout()->createBlock('logo/adminhtml_logo_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}