<?php

class Mage_Eternity_Block_Adminhtml_Eternity_Edit_Tab_Design extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
	  
      $fieldset = $form->addFieldset('eternity_form_design', array('legend'=>Mage::helper('eternity')->__('Design Setting')));
     
	  $fieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Mage_Eternity_Block_Adminhtml_Eternity_Edit_Renderer_Color'));
      
	  $fieldset->addField('eternitycolor', 'colorpicker', array(
	  		'label'     => Mage::helper('stud')->__('Use Color For Frontend'),
	  		'name'      => 'eternitycolor',
	  		'value'	  => Mage::getStoreConfig("eternity/general_settings/eternitycolor")
	  ));
	   
	  $fieldset->addField('eternityfontcolor', 'colorpicker', array(
	  		'label'     => Mage::helper('eternity')->__('Use For Text'),
	  		'name'      => 'eternityfontcolor',
	  		'value'	  => Mage::getStoreConfig("eternity/general_settings/eternityfontcolor")
	  ));
	  
	  $fieldset->addField('eternityactivefontcolor', 'colorpicker', array(
	  		'label'     => Mage::helper('eternity')->__('Use For Active Text'),
	  		'name'      => 'eternityactivefontcolor',
	  		'value'	  => Mage::getStoreConfig("eternity/general_settings/eternityactivefontcolor")
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
