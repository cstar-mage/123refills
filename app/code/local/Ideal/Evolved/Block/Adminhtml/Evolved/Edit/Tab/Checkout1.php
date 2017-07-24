<?php

class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Tab_Checkout extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset_checkout = $form->addFieldset('evolved_form_checkout', array('legend'=>Mage::helper('evolved')->__('Checkout')));
      $fieldset_checkout->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
      
      $fieldset_checkout->addField('checkout_title_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Title Color:'),
      		'name'      => 'checkout_title_color',
      ));
      
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