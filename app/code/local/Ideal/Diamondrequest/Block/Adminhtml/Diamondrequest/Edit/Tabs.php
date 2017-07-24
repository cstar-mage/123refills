<?php

class Ideal_Diamondrequest_Block_Adminhtml_Diamondrequest_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('diamondrequest_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('diamondrequest')->__('Request Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('diamondrequest')->__('Request Information'),
          'title'     => Mage::helper('diamondrequest')->__('Request Information'),
          'content'   => $this->getLayout()->createBlock('diamondrequest/adminhtml_diamondrequest_edit_tab_diamondrequest')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}