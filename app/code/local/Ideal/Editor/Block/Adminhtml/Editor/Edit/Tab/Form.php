<?php

class Ideal_Editor_Block_Adminhtml_Editor_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('editor_form', array('legend'=>Mage::helper('editor')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('editor')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      	  'disable'	  => 'true',
      ));

//       $fieldset->addField('filename', 'file', array(
//           'label'     => Mage::helper('editor')->__('File'),
//           'required'  => false,
//           'name'      => 'filename',
// 	  ));
		
//       $fieldset->addField('status', 'select', array(
//           'label'     => Mage::helper('editor')->__('Status'),
//           'name'      => 'status',
//           'values'    => array(
//               array(
//                   'value'     => 1,
//                   'label'     => Mage::helper('editor')->__('Enabled'),
//               ),

//               array(
//                   'value'     => 2,
//                   'label'     => Mage::helper('editor')->__('Disabled'),
//               ),
//           ),
//       ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('editor')->__('Content'),
          'title'     => Mage::helper('editor')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getEditorData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getEditorData());
          Mage::getSingleton('adminhtml/session')->setEditorData(null);
      } elseif ( Mage::registry('editor_data') ) {
          $form->setValues(Mage::registry('editor_data')->getData());
      }
      return parent::_prepareForm();
  }
}