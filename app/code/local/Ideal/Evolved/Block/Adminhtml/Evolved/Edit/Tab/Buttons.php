<?php

class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Tab_Buttons extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('evolved_form_general_buttons', array('legend'=>Mage::helper('evolved')->__('General Settings')));   
      $fieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
      
      $fieldset->addField('buttons_background_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Color, background:'),
      		'name'      => 'evolved_form_general_buttons[buttons_background_color]',
      		'note'  => Mage::helper('evolved')->__('Leave empty to use main color'),
      ));
      
      $fieldset->addField('buttons_bghover_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Color, background, hover:'),
      		'name'      => 'evolved_form_general_buttons[buttons_bghover_color]',
      ));
      
      
      $fieldset->addField('buttons_text_color', 'colorpicker', array(
          'label'     => Mage::helper('evolved')->__('Button ‐ Color, text:'),
          'name'      => 'evolved_form_general_buttons[buttons_text_color]',
      ));
      
      $fieldset->addField('buttons_texthover_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Color, text, hover:'),
      		'name'      => 'evolved_form_general_buttons[buttons_texthover_color]',
      ));
      
      $fieldset->addField('buttons_text_size', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Size, text:'),
      		'name'      => 'evolved_form_general_buttons[buttons_text_size]',
      ));
      
      $fieldset->addField('buttons_text_texttransform', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Transform, text'),
      		'name'      => 'evolved_form_general_buttons[buttons_text_texttransform]',
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
      
      $fieldset->addField('buttons_text_style', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Style, text'),
      		'name'      => 'evolved_form_general_buttons[buttons_text_style]',
      		'values'    => array(
      				array('value'=>'','label'=>'Please Select'),
      				array('value'=>'normal','label'=>'normal'),
      				array('value'=>'italic','label'=>'italic'),
      				array('value'=>'oblique','label'=>'oblique'),
      				array('value'=>'initial','label'=>'initial'),
      				array('value'=>'inherit','label'=>'inherit'),
      		),
      ));
      
      $fieldset->addField('buttons_text_weight', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Weight, text'),
      		'name'      => 'evolved_form_general_buttons[buttons_text_weight]',
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
      
     /* $fieldset->addField('buttons_icon_color', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Button Icon color:'),
      		'name'      => 'buttons_icon_color',
      		'options'   => array(
      				'black' => Mage::helper('evolved')->__('Black'),
      				'white' => Mage::helper('evolved')->__('White'),
      		),
      ));
      
      $fieldset->addField('buttons_inverted_icon_color', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Inverted Button Icon color:'),
      		'name'      => 'buttons_inverted_icon_color',
      		'options'   => array(
      				'black' => Mage::helper('evolved')->__('Black'),
      				'white' => Mage::helper('evolved')->__('White'),
      		),
      		'note'  => Mage::helper('evolved')->__('Inverted button use hover colors as regular and vice versa'),
      ));
      */
      $fieldset->addField('buttons_addto_background_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Add‐to Buttons ‐ Color, background:'),
      		'name'      => 'evolved_form_general_buttons[buttons_addto_background_color]',
      ));
      
      $fieldset->addField('buttons_addto_bghover_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Add‐to Buttons ‐ Color, background, hover:'),
      		'name'      => 'evolved_form_general_buttons[buttons_addto_bghover_color]',
      ));
      
      $fieldset->addField('buttons_addto_text_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Add‐to Buttons ‐ Color, text:'),
      		'name'      => 'evolved_form_general_buttons[buttons_addto_text_color]',
      ));
      
      $fieldset->addField('buttons_addto_texthover_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Add‐to Buttons ‐ Color, text, hover:'),
      		'name'      => 'evolved_form_general_buttons[buttons_addto_texthover_color]',
      ));
      
      $fieldset->addField('buttons_addto_text_size', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Add‐to Buttons ‐ Size, text:'),
      		'name'      => 'evolved_form_general_buttons[buttons_addto_text_size]',
      ));
      
      $fieldset->addField('buttons_addto_text_texttransform', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Add‐to Button ‐ Transform, text'),
      		'name'      => 'evolved_form_general_buttons[buttons_addto_text_texttransform]',
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
      
      $fieldset->addField('buttons_addto_text_style', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Add‐to Button ‐ Style, text'),
      		'name'      => 'evolved_form_general_buttons[buttons_addto_text_style]',
      		'values'    => array(
      				array('value'=>'','label'=>'Please Select'),
      				array('value'=>'normal','label'=>'normal'),
      				array('value'=>'italic','label'=>'italic'),
      				array('value'=>'oblique','label'=>'oblique'),
      				array('value'=>'initial','label'=>'initial'),
      				array('value'=>'inherit','label'=>'inherit'),
      		),
      ));
      
      $fieldset->addField('buttons_addto_text_weight', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Add‐to Button ‐ Weight, text'),
      		'name'      => 'evolved_form_general_buttons[buttons_addto_text_weight]',
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
      
      /*$fieldset->addField('buttons_addto_icon_color', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Add-to buttons Icon color:'),
      		'name'      => 'buttons_addto_icon_color',
      		'options'   => array(
      				'black' => Mage::helper('evolved')->__('Black'),
      				'white' => Mage::helper('evolved')->__('White'),
      		),
      ));
      
      $fieldset->addField('buttons_addto_inverted_icon_color', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Add-to Inverted buttons Icon color:'),
      		'name'      => 'buttons_addto_inverted_icon_color',
      		'options'   => array(
      				'black' => Mage::helper('evolved')->__('Black'),
      				'white' => Mage::helper('evolved')->__('White'),
      		),
      ));*/
      
      $fieldset1 = $form->addFieldset('evolved_form_buttons_img', array('legend'=>Mage::helper('evolved')->__('Custom Button Images')));
      $fieldset1->addField('button_background_image', 'image', array(
      		'label'     => Mage::helper('logo')->__('General buttons'),
      		'name'      => 'evolved_form_buttons_img[button_background_image]',
      ));
      
      $fieldset1->addField('button_addto_background_image', 'image', array(
      		'label'     => Mage::helper('logo')->__('Button - Product Detail, “Add to Cart”'),
      		'name'      => 'evolved_form_buttons_img[button_addto_background_image]',
      ));
      
      $fieldset1->addField('shoppingcart_update_cart_button_background_image', 'image', array(
      		'label'     => Mage::helper('logo')->__('Button - Shopping, “Update Cart”'),
      		'name'      => 'evolved_form_buttons_img[shoppingcart_update_cart_button_background_image]',
      ));
      
      $fieldset1->addField('shoppingcart_continue_shopping_cart_button_background_image', 'image', array(
      		'label'     => Mage::helper('logo')->__('Button - Shopping, “Continue Cart”'),
      		'name'      => 'evolved_form_buttons_img[shoppingcart_continue_shopping_cart_button_background_image]',
      ));
      
      $fieldset1->addField('shoppingcart_empty_cart_button_background_image', 'image', array(
      		'label'     => Mage::helper('logo')->__('Button - Shopping, “Empty Cart”'),
      		'name'      => 'evolved_form_buttons_img[shoppingcart_empty_cart_button_background_image]',
      ));
      
      $fieldset1->addField('shoppingcart_processed_to_checkout_cart_button_background_image', 'image', array(
      		'label'     => Mage::helper('logo')->__('Button - Shopping, “Proceed to Checkout”'),
      		'name'      => 'evolved_form_buttons_img[shoppingcart_processed_to_checkout_cart_button_background_image]',
      ));
      
      
      $fieldset1->addField('shoppingcart_discount_cart_button_background_image', 'image', array(
      		'label'     => Mage::helper('logo')->__('Button - Shopping, “Apply Discount”'),
      		'name'      => 'evolved_form_buttons_img[shoppingcart_discount_cart_button_background_image]',
      ));
      
      $fieldset1->addField('shoppingcart_estimate_tax_button_background_image', 'image', array(
      		'label'     => Mage::helper('logo')->__('Button - Shopping, “Estimate”'),
      		'name'      => 'evolved_form_buttons_img[shoppingcart_estimate_tax_button_background_image]',
      ));
      
      $fieldset1->addField('shoppingcart_estimate_tax_Update_total_button_background_image', 'image', array(
      		'label'     => Mage::helper('logo')->__('Button - Shopping, “Estimate Update Total”'),
      		'name'      => 'evolved_form_buttons_img[shoppingcart_estimate_tax_Update_total_button_background_image]',
      ));
      
      $buttonfooterfieldset = $form->addFieldset('evolved_form_footer_button', array('legend'=>Mage::helper('evolved')->__('Footer')));
      $buttonfooterfieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));

      $buttonfooterfieldset->addField('footer_button_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Color, background:'),
      		'name'      => 'evolved_form_footer_button[footer_button_background]',
      ));
      
      $buttonfooterfieldset->addField('footer_button_hover_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Color, background, hover:'),
      		'name'      => 'evolved_form_footer_button[footer_button_hover_background]',
      ));
      
      $buttonfooterfieldset->addField('footer_button_text_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Color, text:'),
      		'name'      => 'evolved_form_footer_button[footer_button_text_color]',
      ));
      
      $buttonfooterfieldset->addField('footer_button_text_hover', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Color, text, hover:'),
      		'name'      => 'evolved_form_footer_button[footer_button_text_hover]',
      ));
      
      $buttonfooterfieldset->addField('footer_button_text_size', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Size, text:'),
      		'name'      => 'evolved_form_footer_button[footer_button_text_size]',
      ));
      
      $buttonfooterfieldset->addField('footer_button_text_texttransform', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Transform, text'),
      		'name'      => 'evolved_form_footer_button[footer_button_text_texttransform]',
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
      
      $buttonfooterfieldset->addField('footer_button_text_style', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Style, text'),
      		'name'      => 'evolved_form_footer_button[footer_button_text_style]',
      		'values'    => array(
      				array('value'=>'','label'=>'Please Select'),
      				array('value'=>'normal','label'=>'normal'),
      				array('value'=>'italic','label'=>'italic'),
      				array('value'=>'oblique','label'=>'oblique'),
      				array('value'=>'initial','label'=>'initial'),
      				array('value'=>'inherit','label'=>'inherit'),
      		),
      ));
      
      $buttonfooterfieldset->addField('footer_button_text_weight', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Weight, text'),
      		'name'      => 'evolved_form_footer_button[footer_button_text_weight]',
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
      
      $buttonappointmentfieldset = $form->addFieldset('evolved_form_appointment_button', array('legend'=>Mage::helper('evolved')->__('Contact Us (Appointment Button)')));
      $buttonappointmentfieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
      $buttonappointmentfieldset->addType('select_fonts', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Font'));
      
      $buttonappointmentfieldset->addField('contacts_appointment_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Color, background:'),
      		'name'      => 'evolved_form_appointment_button[contacts_appointment_background]',
      ));
      
      $buttonappointmentfieldset->addField('contacts_appointment_fontcolor', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Color, text:'),
      		'name'      => 'evolved_form_appointment_button[contacts_appointment_fontcolor]',
      ));
      
      $buttonappointmentfieldset->addField('contacts_appointment_font', 'select_fonts', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Font family:'),
      		'name'      => 'evolved_form_appointment_button[contacts_appointment_font]',
      		'values' => Mage::getModel('evolved/Font')->toOptionArray(),
      ));
      
      $buttonappointmentfieldset->addField('contacts_appointment_text_size', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Size, text:'),
      		'name'      => 'evolved_form_appointment_button[contacts_appointment_text_size]',
      ));
      
      $buttonappointmentfieldset->addField('contacts_appointment_text_texttransform', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Transform, text'),
      		'name'      => 'evolved_form_appointment_button[contacts_appointment_text_texttransform]',
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
      
      $buttonappointmentfieldset->addField('contacts_appointment_text_style', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Style, text'),
      		'name'      => 'evolved_form_appointment_button[contacts_appointment_text_style]',
      		'values'    => array(
      				array('value'=>'','label'=>'Please Select'),
      				array('value'=>'normal','label'=>'normal'),
      				array('value'=>'italic','label'=>'italic'),
      				array('value'=>'oblique','label'=>'oblique'),
      				array('value'=>'initial','label'=>'initial'),
      				array('value'=>'inherit','label'=>'inherit'),
      		),
      ));
      
      $buttonappointmentfieldset->addField('contacts_appointment_text_weight', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Weight, text'),
      		'name'      => 'evolved_form_appointment_button[contacts_appointment_text_weight]',
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
      
      $buttonproductlistsidefieldset = $form->addFieldset('evolved_form_productlistside_button', array('legend'=>Mage::helper('evolved')->__('Product List (Sidebar)')));
      $buttonproductlistsidefieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
      
      $buttonproductlistsidefieldset->addField('productlist_block_button_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Color, background:'),
      		'name'      => 'evolved_form_productlistside_button[productlist_block_button_background]',
      		'note' => Mage::helper('evolved')->__('Leave empty to use main color'),
      ));
      
      $buttonproductlistsidefieldset->addField('productlist_block_button_background_hovercolor', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Color, background, hover:'),
      		'name'      => 'evolved_form_productlistside_button[productlist_block_button_background_hovercolor]',
      ));
      
      $buttonproductlistsidefieldset->addField('productlist_block_button_textcolor', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Color, text:'),
      		'name'      => 'evolved_form_productlistside_button[productlist_block_button_textcolor]',
      ));
      
      $buttonproductlistsidefieldset->addField('productlist_block_button_text_hovercolor', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Color, text, hover:'),
      		'name'      => 'evolved_form_productlistside_button[productlist_block_button_text_hovercolor]',
      ));
      
      $buttonproductlistsidefieldset->addField('productlist_block_button_text_size', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Size, text:'),
      		'name'      => 'evolved_form_productlistside_button[productlist_block_button_text_size]',
      ));
      
      $buttonproductlistsidefieldset->addField('productlist_block_button_text_texttransform', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Transform, text'),
      		'name'      => 'evolved_form_productlistside_button[productlist_block_button_text_texttransform]',
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
      
      $buttonproductlistsidefieldset->addField('productlist_block_button_text_style', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Style, text'),
      		'name'      => 'evolved_form_productlistside_button[productlist_block_button_text_style]',
      		'values'    => array(
      				array('value'=>'','label'=>'Please Select'),
      				array('value'=>'normal','label'=>'normal'),
      				array('value'=>'italic','label'=>'italic'),
      				array('value'=>'oblique','label'=>'oblique'),
      				array('value'=>'initial','label'=>'initial'),
      				array('value'=>'inherit','label'=>'inherit'),
      		),
      ));
      
      $buttonproductlistsidefieldset->addField('productlist_block_button_text_weight', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Weight, text'),
      		'name'      => 'evolved_form_productlistside_button[productlist_block_button_text_weight]',
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
      
      /************ Start Inquire Button *********************/
      $inquirebuttonfieldset = $form->addFieldset('evolved_form_productdetails_inquirebutton', array('legend'=>Mage::helper('evolved')->__('Product Details (Inquire Button)')));
      $inquirebuttonfieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
      $inquirebuttonfieldset->addType('select_fonts', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Font'));
      
      $inquirebuttonfieldset->addField('productdetails_Inquire_background_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Color, background:'),
      		'name'      => 'evolved_form_productdetails_inquirebutton[productdetails_Inquire_background_color]',
      ));
      
      $inquirebuttonfieldset->addField('productdetails_Inquire_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Color, text:'),
      		'name'      => 'evolved_form_productdetails_inquirebutton[productdetails_Inquire_color]',
      ));
      
      $inquirebuttonfieldset->addField('productdetails_Inquire_font_size', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Size, text (pixels):'),
      		'name'      => 'evolved_form_productdetails_inquirebutton[productdetails_Inquire_font_size]',
      ));
      
      $inquirebuttonfieldset->addField('productdetails_Inquire_text_texttransform', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Transform, text'),
      		'name'      => 'evolved_form_productdetails_inquirebutton[productdetails_Inquire_text_texttransform]',
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
      
      $inquirebuttonfieldset->addField('productdetails_Inquire_text_style', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Style, text'),
      		'name'      => 'evolved_form_productdetails_inquirebutton[productdetails_Inquire_text_style]',
      		'values'    => array(
      				array('value'=>'','label'=>'Please Select'),
      				array('value'=>'normal','label'=>'normal'),
      				array('value'=>'italic','label'=>'italic'),
      				array('value'=>'oblique','label'=>'oblique'),
      				array('value'=>'initial','label'=>'initial'),
      				array('value'=>'inherit','label'=>'inherit'),
      		),
      ));
      
      $inquirebuttonfieldset->addField('productdetails_Inquire_text_weight', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Weight, text'),
      		'name'      => 'evolved_form_productdetails_inquirebutton[productdetails_Inquire_text_weight]',
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
      /************ End Inquire Button *********************/
      
      $myaccountbuttonfieldset = $form->addFieldset('evolved_form_productdetails_myaccountbutton', array('legend'=>Mage::helper('evolved')->__('My Account / Login (Right Sidebar)')));
      $myaccountbuttonfieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
      
      $myaccountbuttonfieldset->addField('myaccount_rightsidebar_button_background_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Color, background:'),
      		'name'      => 'evolved_form_productdetails_myaccountbutton[myaccount_rightsidebar_button_background_color]',
      ));
       
      $myaccountbuttonfieldset->addField('myaccount_rightsidebar_button_text_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Color, text:'),
      		'name'      => 'evolved_form_productdetails_myaccountbutton[myaccount_rightsidebar_button_text_color]',
      ));
      
      $myaccountbuttonfieldset->addField('myaccount_rightsidebar_button_text_size', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Size, text:'),
      		'name'      => 'evolved_form_productdetails_myaccountbutton[myaccount_rightsidebar_button_text_size]',
      ));
      
      $myaccountbuttonfieldset->addField('myaccount_rightsidebar_button_text_texttransform', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Transform, text'),
      		'name'      => 'evolved_form_productdetails_myaccountbutton[myaccount_rightsidebar_button_text_texttransform]',
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
      
      $myaccountbuttonfieldset->addField('myaccount_rightsidebar_button_text_style', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Style, text'),
      		'name'      => 'evolved_form_productdetails_myaccountbutton[myaccount_rightsidebar_button_text_style]',
      		'values'    => array(
      				array('value'=>'','label'=>'Please Select'),
      				array('value'=>'normal','label'=>'normal'),
      				array('value'=>'italic','label'=>'italic'),
      				array('value'=>'oblique','label'=>'oblique'),
      				array('value'=>'initial','label'=>'initial'),
      				array('value'=>'inherit','label'=>'inherit'),
      		),
      ));
      
      $myaccountbuttonfieldset->addField('myaccount_rightsidebar_button_text_weight', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Weight, text'),
      		'name'      => 'evolved_form_productdetails_myaccountbutton[myaccount_rightsidebar_button_text_weight]',
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
      
      $checkoutbuttonfieldset = $form->addFieldset('evolved_form_productdetails_checkoutbutton', array('legend'=>Mage::helper('evolved')->__('Checkout')));
      $checkoutbuttonfieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
      
      $checkoutbuttonfieldset->addField('checkout_button_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Color, background:'),
      		'name'      => 'evolved_form_productdetails_checkoutbutton[checkout_button_background]',
      ));
      
      $checkoutbuttonfieldset->addField('checkout_button_hover_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Color, background, hover:'),
      		'name'      => 'evolved_form_productdetails_checkoutbutton[checkout_button_hover_background]',
      ));
      
      $checkoutbuttonfieldset->addField('checkout_button_text_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Color, text:'),
      		'name'      => 'evolved_form_productdetails_checkoutbutton[checkout_button_text_color]',
      ));
      
      $checkoutbuttonfieldset->addField('checkout_button_hover_text_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Color, text, hover:'),
      		'name'      => 'evolved_form_productdetails_checkoutbutton[checkout_button_hover_text_color]',
      ));
      
      $checkoutbuttonfieldset->addField('checkout_button_text_size', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Size, text:'),
      		'name'      => 'evolved_form_productdetails_checkoutbutton[checkout_button_text_size]',
      ));
      
      $checkoutbuttonfieldset->addField('checkout_button_text_texttransform', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Transform, text'),
      		'name'      => 'evolved_form_productdetails_checkoutbutton[checkout_button_text_texttransform]',
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
      
      $checkoutbuttonfieldset->addField('checkout_button_text_style', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Style, text'),
      		'name'      => 'evolved_form_productdetails_checkoutbutton[checkout_button_text_style]',
      		'values'    => array(
      				array('value'=>'','label'=>'Please Select'),
      				array('value'=>'normal','label'=>'normal'),
      				array('value'=>'italic','label'=>'italic'),
      				array('value'=>'oblique','label'=>'oblique'),
      				array('value'=>'initial','label'=>'initial'),
      				array('value'=>'inherit','label'=>'inherit'),
      		),
      ));
      
      $checkoutbuttonfieldset->addField('checkout_button_text_weight', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Weight, text'),
      		'name'      => 'evolved_form_productdetails_checkoutbutton[checkout_button_text_weight]',
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
      
      $shoppingcartbuttonfieldset = $form->addFieldset('evolved_form_productdetails_shoppingcartbutton', array('legend'=>Mage::helper('evolved')->__('Shopping Cart')));
      $shoppingcartbuttonfieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
      
      $shoppingcartbuttonfieldset->addField('buttons_shopping_background_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Color, background:'),
      		'name'      => 'evolved_form_productdetails_shoppingcartbutton[buttons_shopping_background_color]',
      ));
      
      $shoppingcartbuttonfieldset->addField('buttons_shopping_bghover_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Color, background, hover:'),
      		'name'      => 'evolved_form_productdetails_shoppingcartbutton[buttons_shopping_bghover_color]',
      ));
      
      $shoppingcartbuttonfieldset->addField('buttons_shopping_text_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Color, text:'),
      		'name'      => 'evolved_form_productdetails_shoppingcartbutton[buttons_shopping_text_color]',
      ));
      
      $shoppingcartbuttonfieldset->addField('buttons_shopping_text_hover_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Color, text, hover:'),
      		'name'      => 'evolved_form_productdetails_shoppingcartbutton[buttons_shopping_text_hover_color]',
      ));
      
      $shoppingcartbuttonfieldset->addField('buttons_shopping_text_size', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Size, text:'),
      		'name'      => 'evolved_form_productdetails_shoppingcartbutton[buttons_shopping_text_size]',
      ));
      
      $shoppingcartbuttonfieldset->addField('buttons_shopping_text_texttransform', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Transform, text'),
      		'name'      => 'evolved_form_productdetails_shoppingcartbutton[buttons_shopping_text_texttransform]',
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
      
      $shoppingcartbuttonfieldset->addField('buttons_shopping_text_style', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Style, text'),
      		'name'      => 'evolved_form_productdetails_shoppingcartbutton[buttons_shopping_text_style]',
      		'values'    => array(
      				array('value'=>'','label'=>'Please Select'),
      				array('value'=>'normal','label'=>'normal'),
      				array('value'=>'italic','label'=>'italic'),
      				array('value'=>'oblique','label'=>'oblique'),
      				array('value'=>'initial','label'=>'initial'),
      				array('value'=>'inherit','label'=>'inherit'),
      		),
      ));
      
      $shoppingcartbuttonfieldset->addField('buttons_shopping_text_weight', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Button ‐ Weight, text'),
      		'name'      => 'evolved_form_productdetails_shoppingcartbutton[buttons_shopping_text_weight]',
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
      
      Mage::getSingleton('core/session')->setBlockName('evolved_buttons');
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
