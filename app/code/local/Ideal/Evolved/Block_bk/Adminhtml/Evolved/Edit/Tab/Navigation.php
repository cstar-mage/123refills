<?php

class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Tab_Navigation extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('evolved_form_navigation', array('legend'=>Mage::helper('evolved')->__('Navigation')));
     
      $fieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
      
      $fieldset->addField('navigation_top_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Top level Navigation color:'),
      		'name'      => 'navigation_top_color',
      ));
      
      $fieldset->addField('navigation_top_hover_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Top level Navigation hover color:	'),
      		'name'      => 'navigation_top_hover_color',
      ));
      
      $fieldset->addField('navigation_top_background_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Top level Navigation background color:'),
      		'name'      => 'navigation_top_background_color',
      		'note'  => Mage::helper('evolved')->__('Leave empty to use main theme color'),
      ));
      
      $fieldset->addField('navigation_top_font_size', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Top level Navigation font size:'),
      		'name'      => 'navigation_top_font_size',
      		'note'  => Mage::helper('evolved')->__('Top level ONLY Font size in PX'),
      ));
      
      $fieldset->addField('navigation_sub_container_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Sub level Navigation container background color:'),
      		'name'      => 'navigation_sub_container_background',
      ));
      
      $fieldset->addField('navigation_sub_icon_color', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Sub level Icon color:'),
      		'name'      => 'navigation_sub_icon_color',
      		'options'   => array(
      				'black' => Mage::helper('evolved')->__('Black'),
      				'white' => Mage::helper('evolved')->__('White'),
      		),
      ));
      
      $fieldset->addField('navigation_sub_text_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Sub level Navigation text color:'),
      		'name'      => 'navigation_sub_text_color',
      ));
      
      $fieldset->addField('navigation_sub_link_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Sub level Navigation link color:'),
      		'name'      => 'navigation_sub_link_color',
      ));
      
      $fieldset->addField('navigation_sub_link_hover_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Sub level Navigation link hover color:'),
      		'name'      => 'navigation_sub_link_hover_color',
      ));
      
      $fieldset->addField('navigation_sub_link_hover_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Sub level Navigation link hover background color:'),
      		'name'      => 'navigation_sub_link_hover_background',
      ));
      
      $fieldset->addField('navigation_megamenu_border_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Megamenu border color:'),
      		'name'      => 'navigation_megamenu_border_color',
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