<?php

class Ideal_Diamondsearch_Block_Adminhtml_Diamondsearch_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('diamondsearch_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('diamondsearch')->__('Diamond Search Settings'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('design_settings', array(
          'label'     => Mage::helper('diamondsearch')->__('Design Settings'),
          'title'     => Mage::helper('diamondsearch')->__('Design Settings'),
          'content'   => $this->getLayout()->createBlock('diamondsearch/adminhtml_diamondsearch_edit_tab_design')->toHtml(),
      ));
      $this->addTab('shape_settings', array(
          'label'     => Mage::helper('diamondsearch')->__('Shape Settings'),
          'title'     => Mage::helper('diamondsearch')->__('Shape Settings'),
          'content'   => $this->getLayout()->createBlock('diamondsearch/adminhtml_diamondsearch_edit_tab_shape')->toHtml(),
      ));
      $this->addTab('slider_settings', array(
          'label'     => Mage::helper('diamondsearch')->__('Slider Settings'),
          'title'     => Mage::helper('diamondsearch')->__('Slider Settings'),
          'content'   => $this->getLayout()->createBlock('diamondsearch/adminhtml_diamondsearch_edit_tab_slider')->toHtml(),
      ));
	  $this->addTab('attribute_position', array(
          'label'     => Mage::helper('diamondsearch')->__('Attribute Position'),
          'title'     => Mage::helper('diamondsearch')->__('Attribute Position'),
          'content'   => $this->getLayout()->createBlock('diamondsearch/adminhtml_diamondsearch_edit_tab_attribute')->toHtml(),
      ));
		return parent::_beforeToHtml();
  }
}