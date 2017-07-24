<?php

class Ideal_Knowledgebase_Block_Adminhtml_Knowledgebase_Edit_Tab_Marketingandpromotions extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('knowledgebase_form_marketingandpromotions', array('legend'=>Mage::helper('knowledgebase')->__('Marketing and Promotions')));
     
	  $fieldset->addType('marketingandpromotions', Mage::getConfig()->getBlockClassName('Ideal_Knowledgebase_Block_Adminhtml_Knowledgebase_Edit_Tab_Renderer_Marketingandpromotions'));
      $fieldset->addField('marketingandpromotions', 'marketingandpromotions', array(
      		'name'      => 'marketingandpromotions',
      ));

     
      if ( Mage::getSingleton('adminhtml/session')->getKnowledgebaseData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getKnowledgebaseData());
          Mage::getSingleton('adminhtml/session')->setKnowledgebaseData(null);
      } elseif ( Mage::registry('knowledgebase_data') ) {
          $form->setValues(Mage::registry('knowledgebase_data')->getData());
      }
      return parent::_prepareForm();
  }
}