<?php

class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Tab_Fonts extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('evolved_form_fonts', array('legend'=>Mage::helper('evolved')->__('Fonts')));
      
      $fieldset->addType('select_fonts', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Font'));
      $fieldset->addType('heading', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Heading'));
      
      $fieldset->addField('fonts_enable_googlefont', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Enable Google Font:'),
      		'name'      => 'evolved_form_fonts[fonts_enable_googlefont]',
      		'options'   => array(
      				0 => Mage::helper('evolved')->__('No'),
      				1 => Mage::helper('evolved')->__('Yes'),
      		),
      ));
      
      $fieldset->addField('fonts_all', 'select_fonts', array(
      		'name' => 'evolved_form_fonts[fonts_all]',
      		'label' => Mage::helper('evolved')->__('Set All Font:'),
      		'values' => Mage::getModel('evolved/Font')->toOptionArray(),
      		'note'  => Mage::helper('evolved')->__('Enable google font to use this option'),
      ));
      
      $fieldset->addField('fonts_main', 'select_fonts', array(
      		'name' => 'evolved_form_fonts[fonts_main]',
      		'label' => Mage::helper('evolved')->__('Main Font:'),
      		'values' => Mage::getModel('evolved/Font')->toOptionArray(),
      		'note'  => Mage::helper('evolved')->__('Enable google font to use this option'),
      ));
      
      /* $fieldset->addField('heading_titles', 'heading', array(
      		'label' => Mage::helper('evolved')->__('Titles'),
      		'class' => 'system-fieldset-sub-head',
      )); */
      
      $fieldset->addField('fonts_title', 'select_fonts', array(
      		'name' => 'evolved_form_fonts[fonts_title]',
      		'label' => Mage::helper('evolved')->__('Title Font:'),
      		'values' => Mage::getModel('evolved/Font')->toOptionArray(),
      		'note'  => Mage::helper('evolved')->__('Enable google font to use this option. Leave empty to use main font'),
      ));
      
      $fieldset->addField('fonts_price', 'select_fonts', array(
      		'name' => 'evolved_form_fonts[fonts_price]',
      		'label' => Mage::helper('evolved')->__('Price Font:'),
      		'values' => Mage::getModel('evolved/Font')->toOptionArray(),
      		'note'  => Mage::helper('evolved')->__('Enable google font to use this option. Leave empty to use main font'),
      ));

      $fieldset->addField('fonts_footer_title', 'select_fonts', array(
      		'name' => 'evolved_form_fonts[fonts_footer_title]',
      		'label' => Mage::helper('evolved')->__('Footer Title Font:'),
      		'values' => Mage::getModel('evolved/Font')->toOptionArray(),
      		'note'  => Mage::helper('evolved')->__('Enable google font to use this option. Leave empty to use main font'),
      ));
	  
	  $fieldset->addField('fonts_footer_link', 'select_fonts', array(
      		'name' => 'evolved_form_fonts[fonts_footer_link]',
      		'label' => Mage::helper('evolved')->__('Footer Link Font:'),
      		'values' => Mage::getModel('evolved/Font')->toOptionArray(),
      		'note'  => Mage::helper('evolved')->__('Enable google font to use this option. Leave empty to use main font'),
      ));
      
      $fieldset->addField('fonts_navigation', 'select_fonts', array(
      		'name' => 'evolved_form_fonts[fonts_navigation]',
      		'label' => Mage::helper('evolved')->__('Navigation Font:'),
      		'values' => Mage::getModel('evolved/Font')->toOptionArray(),
      		'note'  => Mage::helper('evolved')->__('Enable google font to use this option. Leave empty to use main font'),
      ));
      
      $fieldset->addField('fonts_block_title', 'select_fonts', array(
      		'name' => 'evolved_form_fonts[fonts_block_title]',
      		'label' => Mage::helper('evolved')->__('Block Title Font:'),
      		'values' => Mage::getModel('evolved/Font')->toOptionArray(),
      		'note'  => Mage::helper('evolved')->__('Enable google font to use this option. Leave empty to use main font'),
      ));
      
      $fieldset->addField('fonts_product_title', 'select_fonts', array(
      		'name' => 'evolved_form_fonts[fonts_product_title]',
      		'label' => Mage::helper('evolved')->__('Product Title Font:'),
      		'values' => Mage::getModel('evolved/Font')->toOptionArray(),
      		'note'  => Mage::helper('evolved')->__('Enable google font to use this option. Leave empty to use main font'),
      ));
      
      $fieldset->addField('fonts_productdetails_price', 'select_fonts', array(
      		'name' => 'evolved_form_fonts[fonts_productdetails_price]',
      		'label' => Mage::helper('evolved')->__('Product Details Price Font:'),
      		'values' => Mage::getModel('evolved/Font')->toOptionArray(),
      		'note'  => Mage::helper('evolved')->__('Enable google font to use this option. Leave empty to use main font'),
      ));
      
      /*$fieldset->addField('fonts_product_name', 'select_fonts', array(
      		'name' => 'fonts_product_name',
      		'label' => Mage::helper('evolved')->__('Product Name Font:'),
      		'values' => Mage::getModel('evolved/Font')->toOptionArray(),
      		'note'  => Mage::helper('evolved')->__('Enable google font to use this option. Leave empty to use main font'),
      ));*/
      Mage::getSingleton('core/session')->setBlockName('evolved_fonts');
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