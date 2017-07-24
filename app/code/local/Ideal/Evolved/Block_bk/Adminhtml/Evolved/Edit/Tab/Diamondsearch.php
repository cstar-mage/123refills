<?php

class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Tab_Diamondsearch extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('evolved_form_diamondsearch', array('legend'=>Mage::helper('evolved')->__('Diamond Search')));
     
      /* $fieldset->addField('diamondsearch_', 'text', array(
          'label'     => Mage::helper('evolved')->__(''),
          'name'      => 'diamondsearch_',
      )); */

      
      if ( Mage::getSingleton('adminhtml/session')->getEvolvedData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getEvolvedData());
          Mage::getSingleton('adminhtml/session')->setEvolvedData(null);
      } elseif ( Mage::registry('evolved_data') ) {
          $form->setValues(Mage::registry('evolved_data'));
      }
      return parent::_prepareForm();
  }
}