<?php

class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Tab_Myaccountlogin extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('evolved_form_login', array('legend'=>Mage::helper('evolved')->__('Login Page')));
      
      $fieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
     
      $fieldset->addField('login_background_color', 'colorpicker', array(
          'label'     => Mage::helper('evolved')->__('Background color:'),
          'name'      => 'login_background_color',
      ));
      
      $fieldset->addField('login_background_image', 'image', array(
      		'label'     => Mage::helper('logo')->__('Background image'),
      		'name'      => 'login_background_image',
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