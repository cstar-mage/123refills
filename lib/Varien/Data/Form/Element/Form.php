<?php

class Mage_Uploadtool_Block_Adminhtml_Uploadtool_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('uploadtool_form', array('legend'=>Mage::helper('uploadtool')->__('Insert Diamonds by Vendor Id')));
     
      $fieldset->addField('price_frm', 'text', array(
          'label'     => Mage::helper('uploadtool')->__('Price From'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'price_from',
      ));
	  

      $fieldset->addField('price_to', 'text', array(
          'label'     => Mage::helper('uploadtool')->__('Price To'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'price_to',
      ));
	  
      $fieldset->addField('price_increase', 'text', array(
          'label'     => Mage::helper('uploadtool')->__('Price Increse in %'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'price_increase',
      ));
	  
      $fieldset->addField('multiline', 'gallery', array(
          'label'     => Mage::helper('uploadtool')->__('Price Increse in %'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'multiline',
      ));	  

/*      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('uploadtool')->__('CSV file of Diamonds'),
          'required'  => true,
		  'class'     => 'required-entry',
          'name'      => 'filename',
	  ));
*//*		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('uploadtool')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('uploadtool')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('uploadtool')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('uploadtool')->__('Content'),
          'title'     => Mage::helper('uploadtool')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
   */  
      if ( Mage::getSingleton('adminhtml/session')->getUploadtoolData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getUploadtoolData());
          Mage::getSingleton('adminhtml/session')->setUploadtoolData(null);
      } elseif ( Mage::registry('uploadtool_data') ) {
          $form->setValues(Mage::registry('uploadtool_data')->getData());
      }
      return parent::_prepareForm();
  }
}