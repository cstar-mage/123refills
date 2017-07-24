<?php

class Ideal_Taskproduction_Block_Adminhtml_Taskproduction_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('taskproduction_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('taskproduction')->__('Tickets'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('tickets', array(
          'label'     => Mage::helper('taskproduction')->__('Tickets'),
          'title'     => Mage::helper('taskproduction')->__('Tickets'),
          'content'   => $this->getLayout()->createBlock('taskproduction/adminhtml_taskproduction_edit_tab_tickets')->toHtml(),
      ));
      
/*       $this->addTab('form_section_add_reply', array(
      		'label'     => Mage::helper('taskproduction')->__('Add Reply'),
      		'title'     => Mage::helper('taskproduction')->__('Add Reply'),
      		'content'   => $this->getLayout()->createBlock('taskproduction/adminhtml_taskproduction_edit_tab_addreply')->toHtml(),
      ));

      $this->addTab('form_section_add_note', array(
      		'label'     => Mage::helper('taskproduction')->__('Add Note'),
      		'title'     => Mage::helper('taskproduction')->__('Add Note'),
      		'content'   => $this->getLayout()->createBlock('taskproduction/adminhtml_taskproduction_edit_tab_addnote')->toHtml(),
      ));
      
      $this->addTab('form_section_other_tickets', array(
      		'label'     => Mage::helper('taskproduction')->__('Other Tickets'),
      		'title'     => Mage::helper('taskproduction')->__('Other Tickets'),
      		'content'   => $this->getLayout()->createBlock('taskproduction/adminhtml_taskproduction_edit_tab_othertickets')->toHtml(),
      ));
      
      $this->addTab('form_section_options', array(
      		'label'     => Mage::helper('taskproduction')->__('Options'),
      		'title'     => Mage::helper('taskproduction')->__('Options'),
      		'content'   => $this->getLayout()->createBlock('taskproduction/adminhtml_taskproduction_edit_tab_options')->toHtml(),
      ));
      
      $this->addTab('form_section_log', array(
      		'label'     => Mage::helper('taskproduction')->__('Log'),
      		'title'     => Mage::helper('taskproduction')->__('Log'),
      		'content'   => $this->getLayout()->createBlock('taskproduction/adminhtml_taskproduction_edit_tab_log')->toHtml(),
      ));
      
      $this->addTab('form_section_back_to_tickets', array(
      		'label'     => Mage::helper('taskproduction')->__('Back To Tickets'),
      		'title'     => Mage::helper('taskproduction')->__('Back To Tickets'),
      		'content'   => $this->getLayout()->createBlock('taskproduction/adminhtml_taskproduction_edit_tab_backtotickets')->toHtml(),
      )); */
      return parent::_beforeToHtml();
  }
}