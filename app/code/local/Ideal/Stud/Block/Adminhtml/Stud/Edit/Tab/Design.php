<?php

class Ideal_Stud_Block_Adminhtml_Stud_Edit_Tab_Design extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
	  
      $fieldset = $form->addFieldset('stud_form_design', array('legend'=>Mage::helper('stud')->__('Design Setting')));
     
	  $fieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Stud_Block_Adminhtml_Stud_Edit_Renderer_Color'));
      
	  $fieldset->addField('studcolor', 'colorpicker', array(
	  		'label'     => Mage::helper('stud')->__('Use Color For Frontend'),
	  		'name'      => 'studcolor',
	  		'value'	  => Mage::getStoreConfig("stud/general_settings/studcolor")
	  ));
	  
	  $fieldset->addField('studfontcolor', 'colorpicker', array(
	  		'label'     => Mage::helper('stud')->__('Use For Text'),
	  		'name'      => 'studfontcolor',
	  		'value'	  => Mage::getStoreConfig("stud/general_settings/studfontcolor")
	  ));
	  
	  $fieldset->addField('studactivefontcolor', 'colorpicker', array(
	  		'label'     => Mage::helper('stud')->__('Use For Active Text'),
	  		'name'      => 'studactivefontcolor',
	  		'value'	  => Mage::getStoreConfig("stud/general_settings/studactivefontcolor")
	  ));
      
      /*if ( Mage::getSingleton('adminhtml/session')->getDiamondsearchData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getDiamondsearchData());
          Mage::getSingleton('adminhtml/session')->setDiamondsearchData(null);
      } elseif ( Mage::registry('diamondsearch_data') ) {
          $form->setValues(Mage::registry('diamondsearch_data')->getData());
      }*/
      return parent::_prepareForm();
  }
}
