<?php

class Ideal_Dcevent_Block_Adminhtml_Dcevent_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('dcevent_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('dcevent')->__('Event Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('dcevent')->__('Event Information'),
          'title'     => Mage::helper('dcevent')->__('Event Information'),
          'content'   => $this->getLayout()->createBlock('dcevent/adminhtml_dcevent_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}