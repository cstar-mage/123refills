<?php

class Jewelerslink_Watches_Block_Adminhtml_Watches_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('watches_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('watches')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('priceincrease', array(
          'label'     => Mage::helper('watches')->__('Watches Price Increase'),
          'title'     => Mage::helper('watches')->__('Watches Price Increase'),
          'content'   => $this->getLayout()->createBlock('watches/adminhtml_watches_edit_tab_priceincrease')->toHtml(),
      ));

      $this->addTab('vendor', array(
          'label'     => Mage::helper('watches')->__('Manage Vendors'),
          'title'     => Mage::helper('watches')->__('Manage Vendors'),
          'content'   => $this->getLayout()->createBlock('watches/adminhtml_watches_edit_tab_vendor')->toHtml(),
      ));
      
      $this->addTab('import', array(
      		'label'     => Mage::helper('watches')->__('Import Products'),
      		'title'     => Mage::helper('watches')->__('Import Products'),
      		'content'   => $this->getLayout()->createBlock('watches/adminhtml_watches_edit_tab_import')->toHtml(),
      ));
      
      $this->addTab('update', array(
      		'label'     => Mage::helper('watches')->__('Update Products'),
      		'title'     => Mage::helper('watches')->__('Update Products'),
      		'content'   => $this->getLayout()->createBlock('watches/adminhtml_watches_edit_tab_update')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}