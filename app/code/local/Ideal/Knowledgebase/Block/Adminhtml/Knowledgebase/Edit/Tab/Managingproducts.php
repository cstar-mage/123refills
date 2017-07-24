<?php

class Ideal_Knowledgebase_Block_Adminhtml_Knowledgebase_Edit_Tab_Managingproducts extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('knowledgebase_form_managingproducts', array('legend'=>Mage::helper('knowledgebase')->__('Managing Products')));
     
	  $fieldset->addType('managingproducts', Mage::getConfig()->getBlockClassName('Ideal_Knowledgebase_Block_Adminhtml_Knowledgebase_Edit_Tab_Renderer_Managingproducts'));
      $fieldset->addField('managingproducts', 'managingproducts', array(
      		'name'      => 'managingproducts',
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