<?php

class Ideal_Customrequest_Block_Adminhtml_Customrequest_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('customrequest_form', array('legend'=>Mage::helper('customrequest')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('customrequest')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('customrequest')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('customrequest')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('customrequest')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('customrequest')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('customrequest')->__('Content'),
          'title'     => Mage::helper('customrequest')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getCustomrequestData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getCustomrequestData());
          Mage::getSingleton('adminhtml/session')->setCustomrequestData(null);
      } elseif ( Mage::registry('customrequest_data') ) {
          $form->setValues(Mage::registry('customrequest_data')->getData());
      }
      return parent::_prepareForm();
  }
}