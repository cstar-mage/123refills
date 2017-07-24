<?php 
class Mage_Uploadtool_Block_Adminhtml_Uploadtool_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

	public function __construct() {
	      parent::__construct();
	      $this->setId('uploadtool_tabs');
	      $this->setDestElementId('edit_form');
	      $this->setTitle(Mage::helper('uploadtool')->__('Diamond Price Increase'));
	}

  protected function _beforeToHtml()
  {
      $this->addTab('form_section_priceincrease', array(
          'label'     => Mage::helper('uploadtool')->__('Diamond Price Increase'),
          'title'     => Mage::helper('uploadtool')->__('Diamond Price Increase'),
          'content'   => $this->getLayout()->createBlock('uploadtool/adminhtml_uploadtool_edit_tab_priceincrease')->toHtml(),
      ));

      if(Mage::getStoreConfig('uploadtool/allowtabs/enabled_jewelerslink')) {
	      $this->addTab('form_section_vendor', array(
	          'label'     => Mage::helper('uploadtool')->__('JewelersLink Vendors'),
	          'title'     => Mage::helper('uploadtool')->__('JewelersLink Vendors'),
	          'content'   => $this->getLayout()->createBlock('uploadtool/adminhtml_uploadtool_edit_tab_vendor')->toHtml(),
	      ));
      }
      
      $this->addTab('form_section_diamondsearch', array(
      		'label'     => Mage::helper('uploadtool')->__('Lookup Stock #'),
      		'title'     => Mage::helper('uploadtool')->__('Lookup Stock #'),
      		'content'   => $this->getLayout()->createBlock('uploadtool/adminhtml_uploadtool_edit_tab_diamondsearch')->toHtml(),
      ));
      
      if(Mage::getStoreConfig('uploadtool/allowtabs/enabled_jewelerslink')) {
	      $this->addTab('form_section_jewelerslink', array(
	      		'label'     => Mage::helper('uploadtool')->__('Jewelers Link'),
	      		'title'     => Mage::helper('uploadtool')->__('Jewelers Link'),
	      		'content'   => $this->getLayout()->createBlock('uploadtool/adminhtml_uploadtool_edit_tab_jewelerslink')->toHtml(),
	      ));
      }
      
      if(Mage::getStoreConfig('uploadtool/allowtabs/enabled_rapnet')) {
	      $this->addTab('form_section_rapnet', array(
	      		'label'     => Mage::helper('uploadtool')->__('RapNet'),
	      		'title'     => Mage::helper('uploadtool')->__('RapNet'),
	      		'content'   => $this->getLayout()->createBlock('uploadtool/adminhtml_uploadtool_edit_tab_rapnet')->toHtml(),
	      ));
      }
      
      if(Mage::getStoreConfig('uploadtool/allowtabs/enabled_polygon')) {
	      $this->addTab('form_section_polygon', array(
	      		'label'     => Mage::helper('uploadtool')->__('Polygon'),
	      		'title'     => Mage::helper('uploadtool')->__('Polygon'),
	      		'content'   => $this->getLayout()->createBlock('uploadtool/adminhtml_uploadtool_edit_tab_polygon')->toHtml(),
	      ));
      }
      
      if(Mage::getStoreConfig('uploadtool/allowtabs/enabled_google')) {
	      $this->addTab('form_section_google', array(
	      		'label'     => Mage::helper('uploadtool')->__('Google'),
	      		'title'     => Mage::helper('uploadtool')->__('Google'),
	      		'content'   => $this->getLayout()->createBlock('uploadtool/adminhtml_uploadtool_edit_tab_google')->toHtml(),
	      ));
      }
      
      if(Mage::getStoreConfig('uploadtool/allowtabs/enabled_custom')) {
	      $this->addTab('form_section_custom', array(
	      		'label'     => Mage::helper('uploadtool')->__('Custom Uploads'),
	      		'title'     => Mage::helper('uploadtool')->__('Custom Uploads'),
	      		'content'   => $this->getLayout()->createBlock('uploadtool/adminhtml_uploadtool_edit_tab_custom')->toHtml(),
	      ));
      }
      
      return parent::_beforeToHtml();
  }
}
