<?php

class Ideal_Financing_Block_Adminhtml_Financing_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('financing_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('financing')->__('Financing Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('financing')->__('Financing Information'),
          'title'     => Mage::helper('financing')->__('Financing Information'),
          'content'   => $this->getLayout()->createBlock('financing/adminhtml_financing_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}