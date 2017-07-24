<?php

class Ideal_Seeitperson_Block_Adminhtml_Seeitperson_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('seeitperson_form', array('legend'=>Mage::helper('seeitperson')->__('Item information')));
     
      $fieldset->addField('psku', 'text', array(
          'label'     => Mage::helper('seeitperson')->__('Product Sku'),         
          'required'  => false,
          'name'      => 'psku',
      ));

      $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('seeitperson')->__('Name'),
          'required'  => false,
          'name'      => 'name',
	  ));
      
      $fieldset->addField('email', 'text', array(
      		'label'     => Mage::helper('seeitperson')->__('Email'),
      		'required'  => false,
      		'name'      => 'email',
      ));
      
      $fieldset->addField('zip_code', 'text', array(
      		'label'     => Mage::helper('seeitperson')->__('Zip Code'),
      		'required'  => false,
      		'name'      => 'zip_code',
      ));
      
      $fieldset->addField('phone', 'text', array(
      		'label'     => Mage::helper('seeitperson')->__('Phone'),
      		'required'  => false,
      		'name'      => 'phone',
      ));  
	  $fieldset->addField('comments', 'editor', array(
          'name'      => 'comments',
          'label'     => Mage::helper('seeitperson')->__('Comments'),
          'title'     => Mage::helper('seeitperson')->__('Comments'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => false,
      ));     
     
      /*$fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('seeitperson')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('seeitperson')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('seeitperson')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('seeitperson')->__('Content'),
          'title'     => Mage::helper('seeitperson')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      )); */
     
      if ( Mage::getSingleton('adminhtml/session')->getSeeitpersonData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getSeeitpersonData());
          Mage::getSingleton('adminhtml/session')->setSeeitpersonData(null);
      } elseif ( Mage::registry('seeitperson_data') ) {
          $form->setValues(Mage::registry('seeitperson_data')->getData());
      }
      return parent::_prepareForm();
  }
}