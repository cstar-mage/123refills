<?php

class Mage_Uploadproduct_Block_Adminhtml_Uploadproduct_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('uploadproduct_form', array('legend'=>Mage::helper('uploadproduct')->__('Upload Product')));
     
     /* $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('uploadproduct')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));*/

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('uploadproduct')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
     /* $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('uploadproduct')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('uploadproduct')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('uploadproduct')->__('Disabled'),
              ),
          ),
      ));*/
     
     /* $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('uploadproduct')->__('Content'),
          'title'     => Mage::helper('uploadproduct')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));*/
     
      if ( Mage::getSingleton('adminhtml/session')->getUploadproductData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getUploadproductData());
          Mage::getSingleton('adminhtml/session')->setUploadproductData(null);
      } elseif ( Mage::registry('uploadproduct_data') ) {
          $form->setValues(Mage::registry('uploadproduct_data')->getData());
      }
      return parent::_prepareForm();
  }
}