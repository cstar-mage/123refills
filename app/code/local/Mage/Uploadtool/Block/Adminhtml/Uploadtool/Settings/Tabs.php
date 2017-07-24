<?php 
class Mage_Uploadtool_Block_Adminhtml_Uploadtool_Settings_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

	public function __construct() {
	      parent::__construct();
	      $this->setId('uploadtool_tabs');
	      $this->setDestElementId('edit_form');
	      $this->setTitle(Mage::helper('uploadtool')->__('Jewelerslink Settings'));
	}

  protected function _beforeToHtml()
  {

      $this->addTab('form_section_3', array(
      		'label'     => Mage::helper('uploadtool')->__('Settings'),
      		'title'     => Mage::helper('uploadtool')->__('Settings'),
      		'content'   => $this->getLayout()->createBlock('uploadtool/adminhtml_uploadtool_settings_tab_settings')->toHtml(),
      ));
      $this->addTab('form_section_4', array(
      		'label'     => Mage::helper('uploadtool')->__('RapNet Settings'),
      		'title'     => Mage::helper('uploadtool')->__('RapNet Settings'),
      		'content'   => $this->getLayout()->createBlock('uploadtool/adminhtml_uploadtool_settings_tab_rapnetsettings')->toHtml(),
      ));
      return parent::_beforeToHtml();
  }
}