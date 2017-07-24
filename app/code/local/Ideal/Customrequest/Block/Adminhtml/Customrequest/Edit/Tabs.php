<?php

class Ideal_Customrequest_Block_Adminhtml_Customrequest_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('customrequest_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('customrequest')->__('Custom Request Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('customrequest')->__('Custom Request Information'),
          'title'     => Mage::helper('customrequest')->__('Custom Request Information'),
          'content'   => $this->getLayout()->createBlock('customrequest/adminhtml_customrequest_edit_tab_customrequestdata')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}