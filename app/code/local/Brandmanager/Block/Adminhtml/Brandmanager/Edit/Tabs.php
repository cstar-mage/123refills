<?php

class Ideal_Brandmanager_Block_Adminhtml_Brandmanager_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('brandmanager_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('brandmanager')->__('Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('brandmanager')->__('General Information'),
          'title'     => Mage::helper('brandmanager')->__('General Information'),
          'content'   => $this->getLayout()->createBlock('brandmanager/adminhtml_brandmanager_edit_tab_form')->toHtml(),
      ));
	  
	  /*$this->addTab('display_section',array(
			'label'		=> Mage::helper('brandmanager')->__('Categories'),
			'url'       => $this->getUrl('categories', array('_current' => true)),
            'class'     => 'ajax',
	  ));*/
     
      return parent::_beforeToHtml();
  }
}