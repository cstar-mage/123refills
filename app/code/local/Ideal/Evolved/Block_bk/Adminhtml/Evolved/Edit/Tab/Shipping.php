<?php

class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Tab_Shipping extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('evolved_form_shipping', array('legend'=>Mage::helper('evolved')->__('Shopping')));
      $fieldset->addType('select_fonts', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Font'));
      $fieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
      
      /* $fieldset->addField('shipping_', 'text', array(
          'label'     => Mage::helper('evolved')->__(':'),
          'name'      => 'shipping_',
      )); */
      
      $fieldset->addField('shopping_checkout_multiple_address_enable', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Checkout Multiple Addresses:'),
      		'name'      => 'shopping_checkout_multiple_address_enable',
      		'options'   => array(
      				'1' => Mage::helper('evolved')->__('Yes'),
      				'0' => Mage::helper('evolved')->__('No'),
      		),
      ));
      
      $fieldset->addField('shopping_cart_page_title_size', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Page Title size:'),
      		'name'      => 'shopping_cart_page_title_size',
      ));
      
      $fieldset->addField('shopping_cart_page_title_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Page Title Color:'),
      		'name'      => 'shopping_cart_page_title_color',
      ));
      
      $fieldset->addField('shopping_cart_page_title_font', 'select_fonts', array(
      		'label'     => Mage::helper('evolved')->__('Page Title font:'),
      		'values' => Mage::getModel('evolved/Font')->toOptionArray(),
      		'name'      => 'shopping_cart_page_title_font',
      ));
      
      $fieldset->addField('shopping_right_background_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Shopping Right Side background:'),
      		'name'      => 'shopping_right_background_color',
      ));
       
      /* $fieldset->addField('buttons_shopping_background_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Shopping buttons background:'),
      		'name'      => 'buttons_shopping_background_color',
      ));
      
      $fieldset->addField('buttons_shopping_bghover_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Shopping buttons hover background:'),
      		'name'      => 'buttons_shopping_bghover_color',
      ));
      
      $fieldset->addField('buttons_shopping_text_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Shopping buttons text color:'),
      		'name'      => 'buttons_shopping_text_color',
      ));

      $fieldset->addField('buttons_shopping_text_hover_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Shopping buttons hover text color:'),
      		'name'      => 'buttons_shopping_text_hover_color',
      ));*/
      
      $fieldset->addField('shopping_product_name_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Shopping Product name color:'),
      		'name'      => 'shopping_product_name_color',
      ));
      
      $fieldset->addField('shopping_product_name_size', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Shopping Product name size:'),
      		'name'      => 'shopping_product_name_size',
      ));
      
      $fieldset->addField('shopping_subtotal_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Shopping Sub total color:'),
      		'name'      => 'shopping_subtotal_color',
      ));
      
      $fieldset->addField('shopping_subtotal_size', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Shopping Sub total size:'),
      		'name'      => 'shopping_subtotal_size',
      ));
      
      $fieldset->addField('shopping_grandtotal_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Shopping Grand total color:'),
      		'name'      => 'shopping_grandtotal_color',
      ));
      
      $fieldset->addField('shopping_grandtotal_size', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Shopping Grand total size:'),
      		'name'      => 'shopping_grandtotal_size',
      ));

      $fieldset->addField('shopping_discount_label_size', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Discount label size:'),
      		'name'      => 'shopping_discount_label_size',
      ));
      
      $fieldset->addField('shopping_discount_label_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Discount label color:'),
      		'name'      => 'shopping_discount_label_color',
      ));
      
      $fieldset->addField('shopping_discount_label_font', 'select_fonts', array(
      		'label'     => Mage::helper('evolved')->__('Discount label font:'),
      		'values' => Mage::getModel('evolved/Font')->toOptionArray(),
      		'name'      => 'shopping_discount_label_font',
      ));
      
      $fieldset->addField('shopping_cart_table_title_size', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Cart Table Title size:'),
      		'name'      => 'shopping_cart_table_title_size',
      ));
      
      $fieldset->addField('shopping_cart_table_title_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Cart Table Title color:'),
      		'name'      => 'shopping_cart_table_title_color',
      ));
      
      $fieldset->addField('shopping_cart_table_title_font', 'select_fonts', array(
      		'label'     => Mage::helper('evolved')->__('Cart Table Title font:'),
      		'values' => Mage::getModel('evolved/Font')->toOptionArray(),
      		'name'      => 'shopping_cart_table_title_font',
      ));
      

      Mage::getSingleton('core/session')->setBlockName('evolved_shipping');
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