<?php

class Dolphin_ProductQA_Block_Adminhtml_ProductQA_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('productqa_form', array('legend'=>Mage::helper('productqa')->__('Item information')));
     
      $fieldset->addField('product_sku', 'text', array(
          'label'     => Mage::helper('productqa')->__('Product Sku'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'product_sku',
      ));
      
      $fieldset->addField('name', 'text', array(
      		'label'     => Mage::helper('productqa')->__('Customer Name'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'name',
      ));
      
      $fieldset->addField('email', 'text', array(
      		'label'     => Mage::helper('productqa')->__('Customer Email'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'email',
      ));

      $fieldset->addField('question', 'text', array(
      		'label'     => Mage::helper('productqa')->__('Question'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'question',
      ));
     
      $fieldset->addField('answer', 'editor', array(
          'name'      => 'answer',
          'label'     => Mage::helper('productqa')->__('Answer'),
          'title'     => Mage::helper('productqa')->__('Answer'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getProductQAData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getProductQAData());
          Mage::getSingleton('adminhtml/session')->setProductQAData(null);
      } elseif ( Mage::registry('productqa_data') ) {
          $form->setValues(Mage::registry('productqa_data')->getData());
      }
      return parent::_prepareForm();
  }
}