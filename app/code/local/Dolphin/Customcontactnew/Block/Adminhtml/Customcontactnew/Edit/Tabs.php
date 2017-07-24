<?php

class Dolphin_Customcontactnew_Block_Adminhtml_Customcontactnew_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('customcontactnew_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('customcontactnew')->__('Request Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('customcontactnew')->__('Request Information'),
          'title'     => Mage::helper('customcontactnew')->__('Request Information'),
          'content'   => $this->getLayout()->createBlock('customcontactnew/adminhtml_customcontactnew_edit_tab_customcontactnew')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}