<?php

class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Tab_Trustsymbols extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('evolved_form_trustsymbols', array('legend'=>Mage::helper('evolved')->__('Trust Symbols')));
     
      /* $fieldset->addField('trustsymbols_', 'text', array(
          'label'     => Mage::helper('evolved')->__(':'),
          'name'      => 'trustsymbols_',
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