<?php



class Mage_Eternity_Block_Adminhtml_Eternity_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs

{



  public function __construct()

  {

      parent::__construct();

      $this->setId('eternity_tabs');

      $this->setDestElementId('edit_form');

      $this->setTitle(Mage::helper('eternity')->__('Eternity Price Increase'));

  }



  protected function _beforeToHtml()

  {

      $this->addTab('form_section', array(

          'label'     => Mage::helper('eternity')->__('Eternity Price Increase'),

          'title'     => Mage::helper('eternity')->__('Eternity Price Increase'),

          'content'   => $this->getLayout()->createBlock('eternity/adminhtml_eternity_edit_tab_form')->toHtml(),

      ));
	  
	  $this->addTab('form_section_3', array(

          'label'     => Mage::helper('eternity')->__('Manage Dia Price'),

          'title'     => Mage::helper('eternity')->__('Manage Dia Price'),

          'content'   => $this->getLayout()->createBlock('eternity/adminhtml_eternity_edit_tab_form3')->toHtml(),

      ));
	  
	  $this->addTab('form_section_4', array(

          'label'     => Mage::helper('eternity')->__('Manage Ring Cost'),

          'title'     => Mage::helper('eternity')->__('Manage Ring Cost'),

          'content'   => $this->getLayout()->createBlock('eternity/adminhtml_eternity_edit_tab_form4')->toHtml(),

      ));

      $this->addTab('form_section_5', array(

          'label'     => Mage::helper('eternity')->__('Manage Stone Quantity'),

          'title'     => Mage::helper('eternity')->__('Manage Stone Quantity'),

          'content'   => $this->getLayout()->createBlock('eternity/adminhtml_eternity_edit_tab_form5')->toHtml(),

      ));
	  
	  $this->addTab('design_settings', array(
	   		'label'     => Mage::helper('eternity')->__('Design Settings'),
	   		'title'     => Mage::helper('eternity')->__('Design Settings'), 
	   		'content'   => $this->getLayout()->createBlock('eternity/adminhtml_eternity_edit_tab_design')->toHtml(),
	   ));

      return parent::_beforeToHtml();

  }

}