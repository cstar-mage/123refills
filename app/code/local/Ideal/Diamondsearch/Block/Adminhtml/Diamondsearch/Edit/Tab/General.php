<?php

class Ideal_Diamondsearch_Block_Adminhtml_Diamondsearch_Edit_Tab_General extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('diamondsearch_form', array('legend'=>Mage::helper('diamondsearch')->__('Item information')));
     
	  $fieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Diamondsearch_Block_Adminhtml_Diamondsearch_Edit_Renderer_Color'));
      
      $fieldset->addField('slider_bgcolor', 'colorpicker', array(
          'label'     => Mage::helper('diamondsearch')->__('Slider Bg. Color'),
          'name'      => 'slider_bgcolor',
		  'value'	  => Mage::getStoreConfig("diamondsearch/design_settings/slider_bgcolor")
      ));
	  
      $fieldset->addField('slider_shadow_color', 'colorpicker', array(
          'label'     => Mage::helper('diamondsearch')->__('Slider Shadow Color'),
          'name'      => 'slider_shadow_color',
		  'value'	  => Mage::getStoreConfig("diamondsearch/design_settings/slider_shadow_color")
      ));
	  
      $fieldset->addField('slider_disabled_bgcolor', 'colorpicker', array(
          'label'     => Mage::helper('diamondsearch')->__('Slider Disabled Bg. Color'),
          'name'      => 'slider_disabled_bgcolor',
		  'value'	  => Mage::getStoreConfig("diamondsearch/design_settings/slider_disabled_bgcolor")
      ));
	  
      $fieldset->addField('slider_disabled_shadow_color', 'colorpicker', array(
          'label'     => Mage::helper('diamondsearch')->__('Slider Disabled Shadow Color'),
          'name'      => 'slider_disabled_shadow_color',
		  'value'	  => Mage::getStoreConfig("diamondsearch/design_settings/slider_disabled_shadow_color")
      ));
	  
      $fieldset->addField('advanced_search_bgcolor', 'colorpicker', array(
          'label'     => Mage::helper('diamondsearch')->__('Advanced Search Bg. Color'),
          'name'      => 'advanced_search_bgcolor',
		  'value'	  => Mage::getStoreConfig("diamondsearch/design_settings/advanced_search_bgcolor")
      ));

      $fieldset->addField('tabs_bgcolor', 'colorpicker', array(
          'label'     => Mage::helper('diamondsearch')->__('Tabs Bg. Color'),
          'name'      => 'tabs_bgcolor',
		  'value'	  => Mage::getStoreConfig("diamondsearch/design_settings/tabs_bgcolor")
      ));

      $fieldset->addField('table_header_bgcolor', 'colorpicker', array(
          'label'     => Mage::helper('diamondsearch')->__('Table Header Bg. Color'),
          'name'      => 'table_header_bgcolor',
		  'value'	  => Mage::getStoreConfig("diamondsearch/design_settings/table_header_bgcolor")
      ));

      $fieldset->addField('table_row_odd_bgcolor', 'colorpicker', array(
          'label'     => Mage::helper('diamondsearch')->__('Table Row Bg. Color(odd)'),
          'name'      => 'table_row_odd_bgcolor',
		  'value'	  => Mage::getStoreConfig("diamondsearch/design_settings/table_row_odd_bgcolor")
      ));

      $fieldset->addField('table_row_even_bgcolor', 'colorpicker', array(
          'label'     => Mage::helper('diamondsearch')->__('Table Row Bg. Color(even)'),
          'name'      => 'table_row_even_bgcolor',
		  'value'	  => Mage::getStoreConfig("diamondsearch/design_settings/table_row_even_bgcolor")
      ));

      $fieldset->addField('table_row_hover_bgcolor', 'colorpicker', array(
          'label'     => Mage::helper('diamondsearch')->__('Table Row Hover Bg. Color'),
          'name'      => 'table_row_hover_bgcolor',
		  'value'	  => Mage::getStoreConfig("diamondsearch/design_settings/table_row_hover_bgcolor")
      ));

      $fieldset->addField('view_button_color', 'colorpicker', array(
          'label'     => Mage::helper('diamondsearch')->__('View Button Color'),
          'name'      => 'view_button_color',
		  'value'	  => Mage::getStoreConfig("diamondsearch/design_settings/view_button_color")
      ));

      $fieldset->addField('view_button_hover_color', 'colorpicker', array(
          'label'     => Mage::helper('diamondsearch')->__('View Button Hover Color'),
          'name'      => 'view_button_hover_color',
		  'value'	  => Mage::getStoreConfig("diamondsearch/design_settings/view_button_hover_color")
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