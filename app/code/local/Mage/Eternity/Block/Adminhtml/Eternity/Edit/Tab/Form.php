<?php
 
class Mage_Eternity_Block_Adminhtml_Eternity_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('eternity_form', array('legend'=>Mage::helper('eternity')->__('Diamond Price Increase')));
     
     $fieldset->addField('multiline', 'gallery55', array(
          'label'     => Mage::helper('eternity')->__('Price Increase in %'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'multiline',
      ));
  
      if ( Mage::getSingleton('adminhtml/session')->getEternityData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getEternityData());
          Mage::getSingleton('adminhtml/session')->setEternityData(null);
      } elseif ( Mage::registry('eternity_data') ) {
          $form->setValues(Mage::registry('eternity_data')->getData());
      }
      return parent::_prepareForm();
  }
}