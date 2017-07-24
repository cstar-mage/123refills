<?php

class Ideal_Selldiamond_Block_Adminhtml_Selldiamond_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('selldiamond_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('selldiamond')->__('Sell Diamond Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('selldiamond')->__('Sell Diamond Information'),
          'title'     => Mage::helper('selldiamond')->__('Sell Diamond Information'),
          'content'   => $this->getLayout()->createBlock('selldiamond/adminhtml_selldiamond_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}