<?php

class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Tab_HeaderDropdown extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('evolved_form_header_dropdown', array('legend'=>Mage::helper('evolved')->__('Header Dropdowns (currency, language, cart)')));
     
      $fieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
      
      $fieldset->addField('header_dropdown_background_color', 'colorpicker', array(
          'label'     => Mage::helper('evolved')->__('Dropdown background color:'),
          'name'      => 'header_dropdown_background_color',
      ));

      $fieldset->addField('header_dropdown_item_background_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Dropdown item background color:'),
      		'name'      => 'header_dropdown_item_background_color',
      		'note'  => Mage::helper('evolved')->__('I.e. - products list in cart dropdown'),
      ));
      
      $fieldset->addField('header_dropdown_editremove_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Dropdown edit / remove buttons background color:'),
      		'name'      => 'header_dropdown_editremove_background',
      		'note'  => Mage::helper('evolved')->__('In cart dropdown'),
      ));
      
      $fieldset->addField('header_dropdown_editremove_icon', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Dropdown edit / remove buttons Icon color'),
      		'name'      => 'header_dropdown_editremove_icon',
      		'options'   => array(
      				'black' => Mage::helper('evolved')->__('Black'),
      				'white' => Mage::helper('evolved')->__('White'),
      		),
      ));
      
      $fieldset->addField('header_dropdown_text_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Dropdown text color:'),
      		'name'      => 'header_dropdown_text_color',
      ));
      
      $fieldset->addField('header_dropdown_texthover_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Dropdown text hover color:'),
      		'name'      => 'header_dropdown_texthover_color',
      ));
      
      $fieldset->addField('header_dropdown_background_hover', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Dropdown background hover color:'),
      		'name'      => 'header_dropdown_background_hover',
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