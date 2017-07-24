<?php
class Ideal_Knowledgebase_Block_Adminhtml_Knowledgebase_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('knowledgebase_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('knowledgebase')->__('Product Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('knowledgebase_gettingstarted', array(
          'label'     => Mage::helper('knowledgebase')->__('Getting Started'),
          'title'     => Mage::helper('knowledgebase')->__('Getting Started'),
          'content'   => $this->getLayout()->createBlock('knowledgebase/adminhtml_knowledgebase_edit_tab_general')->toHtml(),
      ));
      
      $this->addTab('knowledgebase_marketingandpromotions', array(
      		'label'     => Mage::helper('knowledgebase')->__('Marketing and Promotions (4)'),
      		'title'     => Mage::helper('knowledgebase')->__('Marketing and Promotions (4)'),
      		'content'   => $this->getLayout()->createBlock('knowledgebase/adminhtml_knowledgebase_edit_tab_marketingandpromotions')->toHtml(),
      ));
      
      $this->addTab('knowledgebase_customization', array(
      		'label'     => Mage::helper('knowledgebase')->__('Customization (4)'),
      		'title'     => Mage::helper('knowledgebase')->__('Customization (4)'),
      		'content'   => $this->getLayout()->createBlock('knowledgebase/adminhtml_knowledgebase_edit_tab_customization')->toHtml(),
      ));
      
      $this->addTab('knowledgebase_managingproducts', array(
      		'label'     => Mage::helper('knowledgebase')->__('Managing Products (12)'),
      		'title'     => Mage::helper('knowledgebase')->__('Managing Products (12)'),
      		'content'   => $this->getLayout()->createBlock('knowledgebase/adminhtml_knowledgebase_edit_tab_managingproducts')->toHtml(),
      ));
      
      $this->addTab('knowledgebase_managingcategories', array(
      		'label'     => Mage::helper('knowledgebase')->__('Managing Categories (1)'),
      		'title'     => Mage::helper('knowledgebase')->__('Managing Categories (1)'),
      		'content'   => $this->getLayout()->createBlock('knowledgebase/adminhtml_knowledgebase_edit_tab_managingcategories')->toHtml(),
      ));
      
      $this->addTab('knowledgebase_organization', array(
      		'label'     => Mage::helper('knowledgebase')->__('Organization (2)'),
      		'title'     => Mage::helper('knowledgebase')->__('Organization (2)'),
      		'content'   => $this->getLayout()->createBlock('knowledgebase/adminhtml_knowledgebase_edit_tab_organization')->toHtml(),
      ));
      
      $this->addTab('knowledgebase_troubleshooting', array(
      		'label'     => Mage::helper('knowledgebase')->__('Troubleshooting (5)'),
      		'title'     => Mage::helper('knowledgebase')->__('Troubleshooting (5)'),
      		'content'   => $this->getLayout()->createBlock('knowledgebase/adminhtml_knowledgebase_edit_tab_troubleshooting')->toHtml(),
      ));
      
      /*$this->addTab('form_section', array(
      		'label'     => Mage::helper('knowledgebase')->__('Knowledgebase Information'),
      		'title'     => Mage::helper('knowledgebase')->__('Knowledgebase Information'),
      		'content'   => $this->getLayout()->createBlock('knowledgebase/adminhtml_knowledgebase_edit_tab_form')->toHtml(),
      ));*/
     
      return parent::_beforeToHtml();
  }
}