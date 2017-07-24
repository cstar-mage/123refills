<?php

class Jewelerslink_Jewelryshare_Block_Adminhtml_Jewelryshare_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('jewelryshare_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('jewelryshare')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('priceincrease', array(
          'label'     => Mage::helper('jewelryshare')->__('Jewelry Price Increase'),
          'title'     => Mage::helper('jewelryshare')->__('Jewelry Price Increase'),
          'content'   => $this->getLayout()->createBlock('jewelryshare/adminhtml_jewelryshare_edit_tab_priceincrease')->toHtml(),
      ));

      $this->addTab('vendor', array(
          'label'     => Mage::helper('jewelryshare')->__('Manage Vendors'),
          'title'     => Mage::helper('jewelryshare')->__('Manage Vendors'),
          'content'   => $this->getLayout()->createBlock('jewelryshare/adminhtml_jewelryshare_edit_tab_vendor')->toHtml(),
      ));
      
      $this->addTab('import', array(
      		'label'     => Mage::helper('jewelryshare')->__('Import Products'),
      		'title'     => Mage::helper('jewelryshare')->__('Import Products'),
      		'content'   => $this->getLayout()->createBlock('jewelryshare/adminhtml_jewelryshare_edit_tab_import')->toHtml(),
      ));
      
      $this->addTab('update', array(
      		'label'     => Mage::helper('jewelryshare')->__('Update Products'),
      		'title'     => Mage::helper('jewelryshare')->__('Update Products'),
      		'content'   => $this->getLayout()->createBlock('jewelryshare/adminhtml_jewelryshare_edit_tab_update')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}