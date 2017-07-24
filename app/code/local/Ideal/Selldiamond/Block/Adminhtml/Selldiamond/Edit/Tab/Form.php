<?php

class Ideal_Selldiamond_Block_Adminhtml_Selldiamond_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('selldiamond_form', array('legend'=>Mage::helper('selldiamond')->__('Sell Diamond Information')));
     
      /*$fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('selldiamond')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('selldiamond')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('selldiamond')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('selldiamond')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('selldiamond')->__('Disabled'),
              ),
          ),
      ));*/
      $fieldset->addField('name', 'text', array(
      		'label'     => Mage::helper('selldiamond')->__('Name'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'name',
      ));
      $fieldset->addField('email', 'text', array(
      		'label'     => Mage::helper('selldiamond')->__('Email'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'email',
      ));
      $fieldset->addField('phone1', 'text', array(
      		'label'     => Mage::helper('selldiamond')->__('Primary Phone Number'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'phone1',
      ));
      $fieldset->addField('phone2', 'text', array(
      		'label'     => Mage::helper('selldiamond')->__('Secondary Phone Number'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'phone2',
      ));
      $fieldset->addField('contact_time', 'text', array(
      		'label'     => Mage::helper('selldiamond')->__('Best Time To Contact'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'contact_time',
      ));
      $fieldset->addField('shape', 'text', array(
      		'label'     => Mage::helper('selldiamond')->__('Shape'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'shape',
      ));
      
      $fieldset->addField('weight', 'text', array(
      		'label'     => Mage::helper('selldiamond')->__('Weight'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'weight',
      ));
      $fieldset->addField('price', 'text', array(
      		'label'     => Mage::helper('selldiamond')->__('Price'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'price',
      ));
      $fieldset->addField('certification', 'text', array(
      		'label'     => Mage::helper('selldiamond')->__('Certification'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'certification',
      ));
      $fieldset->addField('certificationtype', 'text', array(
      		'label'     => Mage::helper('selldiamond')->__('Certificationtype'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'certificationtype',
      ));
      $fieldset->addField('content', 'editor', array(
      		'name'      => 'content',
      		'label'     => Mage::helper('selldiamond')->__('Additional Information'),
      		'title'     => Mage::helper('selldiamond')->__('ADDITIONAL Information'),
      		'wysiwyg'   => false,
      		'required'  => true,
      ));
      
      /*$fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('selldiamond')->__('Content'),
          'title'     => Mage::helper('selldiamond')->__('Content'),          
          'wysiwyg'   => false,
          'required'  => true,
      ));*/
     
      if ( Mage::getSingleton('adminhtml/session')->getSelldiamondData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getSelldiamondData());
          Mage::getSingleton('adminhtml/session')->setSelldiamondData(null);
      } elseif ( Mage::registry('selldiamond_data') ) {
          $form->setValues(Mage::registry('selldiamond_data')->getData());
      }
      return parent::_prepareForm();
  }
}