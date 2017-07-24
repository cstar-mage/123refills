<?php

class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Tab_Pages extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('evolved_form_pages', array('legend'=>Mage::helper('evolved')->__('Pages content area')));
     
      $fieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
      
      $fieldset->addField('content_background_color', 'colorpicker', array(
          'label'     => Mage::helper('evolved')->__('Color, background:'),
          'name'      => 'evolved_form_pages[content_background_color]',
      ));
      
      $fieldset->addField('content_link_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, background, link:'),
      		'name'      => 'evolved_form_pages[content_link_background]',
      ));
      
      $fieldset->addField('content_linkhover_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, background, link, hover:'),
      		'name'      => 'evolved_form_pages[content_linkhover_background]',
      ));

      /*$fieldset->addField('content_border_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Content border color:'),
      		'name'      => 'content_border_color',
      		'note'      => Mage::helper('evolved')->__('Sliders border, border between items etc'),
      ));*/
      
      $fieldset->addField('content_text_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, text:'),
      		'name'      => 'evolved_form_pages[content_text_color]',
      ));
      
      $fieldset->addField('content_title_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, text, title:'),
      		'name'      => 'evolved_form_pages[content_title_color]',
      ));
    
      $fieldset->addField('content_link_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, text, link:'),
      		'name'      => 'evolved_form_pages[content_link_color]',
      ));
      
	  $fieldset->addField('content_linkhover_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, text, link, hover:'),
      		'name'      => 'evolved_form_pages[content_linkhover_color]',
      ));

	  Mage::getSingleton('core/session')->setBlockName('evolved_pages');
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