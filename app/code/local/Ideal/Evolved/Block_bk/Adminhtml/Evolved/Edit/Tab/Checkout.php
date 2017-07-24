<?php
class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Tab_Checkout extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('evolved_form_checkout', array('legend'=>Mage::helper('evolved')->__('Checkout')));
     
      $fieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
      $fieldset->addType('select_fonts', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Font'));
      /* $fieldset->addField('payment_', 'text', array(
          'label'     => Mage::helper('evolved')->__(''),
          'name'      => 'payment_',
      )); */
      $fieldset->addField('checkout_page_title_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Checkout - Color, text, title:'),
      		'name'      => 'checkout_page_title_color',
      ));
      
      $fieldset->addField('checkout_edit_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Checkout - Color, text, “Edit”:'),
      		'name'      => 'checkout_edit_color',
      ));
      
      $fieldset->addField('checkout_step_title_background_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Steps - Color, background, title:'),
      		'name'      => 'checkout_step_title_background_color',
      ));
      
      $fieldset->addField('checkout_step_title_active_background_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Steps - Color, background, title, active:'),
      		'name'      => 'checkout_step_title_active_background_color',
      ));
      
      $fieldset->addField('checkout_step_number_background_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Steps - Color, background, numbers:'),
      		'name'      => 'checkout_step_number_background_color',
      ));
      
      $fieldset->addField('checkout_step_number_active_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Steps - Color, background, numbers, active:'),
      		'name'      => 'checkout_step_number_active_background',
      ));
      

      
      
      $fieldset->addField('checkout_step_title_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Steps - Color, text, title:'),
      		'name'      => 'checkout_step_title_color',
      ));
      
      $fieldset->addField('checkout_step_title_active_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Steps - Color, text, title, active:'),
      		'name'      => 'checkout_step_title_active_color',
      ));
      
      $fieldset->addField('checkout_step_number_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Steps - Color, text, numbers:'),
      		'name'      => 'checkout_step_number_color',
      ));
      
      $fieldset->addField('checkout_step_number_active_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Steps - Color, text, numbers, active:'),
      		'name'      => 'checkout_step_number_active_color',
      ));
      
      $fieldset->addField('checkout_step_title_texttransform', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Steps ‐ Transform, text, title'),
      		'name'      => 'checkout_step_title_texttransform',
      		'values'    => array(
      				array('value'=>'','label'=>'Please Select'),
      				array('value'=>'none','label'=>'none'),
      				array('value'=>'capitalize','label'=>'capitalize'),
      				array('value'=>'uppercase','label'=>'uppercase'),
      				array('value'=>'lowercase','label'=>'lowercase'),
      				array('value'=>'initial','label'=>'initial'),
      				array('value'=>'inherit','label'=>'inherit'),
      		),
      ));
      
      $fieldset->addField('checkout_step_title_style', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Steps ‐ Style, text, title'),
      		'name'      => 'checkout_step_title_style',
      		'values'    => array(
      				array('value'=>'','label'=>'Please Select'),
      				array('value'=>'normal','label'=>'normal'),
      				array('value'=>'italic','label'=>'italic'),
      				array('value'=>'oblique','label'=>'oblique'),
      				array('value'=>'initial','label'=>'initial'),
      				array('value'=>'inherit','label'=>'inherit'),
      		),
      ));
      
      $fieldset->addField('checkout_step_title_weight', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Steps ‐ Weight, text, title'),
      		'name'      => 'checkout_step_title_weight',
      		'values'    => array(
      				array('value'=>'','label'=>'Please Select'),
      				array('value'=>'normal','label'=>'normal'),
      				array('value'=>'bold','label'=>'bold'),
      				array('value'=>'bolder','label'=>'bolder'),
      				array('value'=>'lighter','label'=>'lighter'),
      				array('value'=>'100','label'=>'100'),
      				array('value'=>'200','label'=>'200'),
      				array('value'=>'300','label'=>'300'),
      				array('value'=>'400','label'=>'400'),
      				array('value'=>'500','label'=>'500'),
      				array('value'=>'600','label'=>'600'),
      				array('value'=>'700','label'=>'700'),
      				array('value'=>'800','label'=>'800'),
      				array('value'=>'900','label'=>'900'),
      				array('value'=>'initial','label'=>'initial'),
      				array('value'=>'inherit','label'=>'inherit'),
      		),
      ));
      
      $fieldset->addField('checkout_step_title_size', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Steps - Size, text, title:'),
      		'name'      => 'checkout_step_title_size',
      ));
      
      $fieldset->addField('checkout_step_number_size', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Steps - Size, text, number:'),
      		'name'      => 'checkout_step_number_size',
      ));
      
      $fieldset->addField('checkout_step_title_font', 'select_fonts', array(
      		'label'     => Mage::helper('evolved')->__('Steps - Font, text, title:'),
      		'values' => Mage::getModel('evolved/Font')->toOptionArray(),
      		'name'      => 'checkout_step_title_font',
      ));
     
      $fieldset->addField('checkout_step_number_font', 'select_fonts', array(
      		'label'     => Mage::helper('evolved')->__('Steps - Font, text, numbers:'),
      		'values' => Mage::getModel('evolved/Font')->toOptionArray(),
      		'name'      => 'checkout_step_number_font',
      ));
      

            
     /* $fieldset->addField('checkout_button_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Checkout Button Background Color:'),
      		'name'      => 'checkout_button_background',
      ));
      
      $fieldset->addField('checkout_button_hover_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Checkout Button hover Background Color:'),
      		'name'      => 'checkout_button_hover_background',
      ));
      
      $fieldset->addField('checkout_button_text_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Checkout Button Text Color:'),
      		'name'      => 'checkout_button_text_color',
      ));
      
      $fieldset->addField('checkout_button_hover_text_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Checkout Button hover text Color:'),
      		'name'      => 'checkout_button_hover_text_color',
      ));
   */   
      Mage::getSingleton('core/session')->setBlockName('evolved_checkout');
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