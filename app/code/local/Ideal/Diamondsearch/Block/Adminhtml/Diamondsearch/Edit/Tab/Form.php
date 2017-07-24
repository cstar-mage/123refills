<?php

class Ideal_Diamondsearch_Block_Adminhtml_Diamondsearch_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('diamondsearch_form', array('legend'=>Mage::helper('diamondsearch')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('diamondsearch')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('diamondsearch')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('diamondsearch')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('diamondsearch')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('diamondsearch')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('diamondsearch')->__('Content'),
          'title'     => Mage::helper('diamondsearch')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getDiamondsearchData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getDiamondsearchData());
          Mage::getSingleton('adminhtml/session')->setDiamondsearchData(null);
      } elseif ( Mage::registry('diamondsearch_data') ) {
          $form->setValues(Mage::registry('diamondsearch_data')->getData());
      }
      return parent::_prepareForm();
  }
}