<?php

class Ideal_Editor_Block_Adminhtml_Editor_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('editor_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('editor')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('editor')->__('Item Information'),
          'title'     => Mage::helper('editor')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('editor/adminhtml_editor_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}