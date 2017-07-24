<?php

class Ideal_Financing_Block_Adminhtml_Financing_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('financing_form', array('legend'=>Mage::helper('financing')->__('Item information')));
     
      $fieldset->addField('comment', 'label', array(
      		'label'     => Mage::helper('financing')->__('Curious About'),
      		'class'     => '',
      		'required'  => true,
      		'name'      => 'comment',
      ));
      
      $fieldset->addField('firstname', 'label', array(
          'label'     => Mage::helper('financing')->__('First Name'),
          'class'     => '',
          'required'  => true,
          'name'      => 'firstname',
      ));
      
      $fieldset->addField('lastname', 'label', array(
      		'label'     => Mage::helper('financing')->__('Last Name'),
      		'class'     => '',
      		'required'  => true,
      		'name'      => 'lastname',
      ));
      
      $fieldset->addField('email', 'label', array(
      		'label'     => Mage::helper('financing')->__('Email'),
      		'class'     => '',
      		'required'  => true,
      		'name'      => 'email',
      ));
      
      $fieldset->addField('phone_no', 'label', array(
      		'label'     => Mage::helper('financing')->__('Phone Number'),
      		'class'     => '',
      		'required'  => true,
      		'name'      => 'phone_no',
      ));
      
      $fieldset->addField('near_location', 'label', array(
      		'label'     => Mage::helper('financing')->__('Near Location'),
      		'class'     => '',
      		'required'  => true,
      		'name'      => 'near_location',
      ));
      
     
      

     /* $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('financing')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('financing')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('financing')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('financing')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('financing')->__('Content'),
          'title'     => Mage::helper('financing')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));*/
     
      if ( Mage::getSingleton('adminhtml/session')->getFinancingData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getFinancingData());
          Mage::getSingleton('adminhtml/session')->setFinancingData(null);
      } elseif ( Mage::registry('financing_data') ) {
          $form->setValues(Mage::registry('financing_data')->getData());
      }
      return parent::_prepareForm();
  }
}