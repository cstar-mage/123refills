<?php

class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Tab_Footer extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      
      $configSettings = Mage::getSingleton('cms/wysiwyg_config')->getConfig(
      		array(
      				'add_images' => true,
      				'add_widgets' => true,
      				'add_variables' => true,
      				'files_browser_window_url'=> Mage::helper("adminhtml")->getUrl("adminhtml/cms_wysiwyg_images/index"),
      		));
      
      //$fieldset = $form->addFieldset('evolved_form_footer', array('legend'=>Mage::helper('evolved')->__('Footer')));   
      //$fieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));

      $generalfieldset = $form->addFieldset('evolved_form_footergeneral', array('legend'=>Mage::helper('evolved')->__('General Setting')));
      $generalfieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
      
      $generalfieldset->addField('footer_above_space', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Margin above footer (pixels)'),
      		'name'      => 'evolved_form_footergeneral[footer_above_space]',
      ));
      
      $generalfieldset->addField('footer_all_text_size', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Size, font (pixels):'),
      		'name'      => 'evolved_form_footergeneral[footer_all_text_size]',
      ));
      
      $generalfieldset->addField('footer_background_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, background'),
      		'name'      => 'evolved_form_footergeneral[footer_background_color]',
      ));
      
      $generalfieldset->addField('footer_text_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, text:'),
      		'name'      => 'evolved_form_footergeneral[footer_text_color]',
      ));
      
      $generalfieldset->addField('footer_link_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, text, link:'),
      		'name'      => 'evolved_form_footergeneral[footer_link_color]',
      ));
      
      $generalfieldset->addField('footer_title_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, text, title:'),
      		'name'      => 'evolved_form_footergeneral[footer_title_color]',
      ));
      
      $generalfieldset->addField('footer_title_texttransform', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Transform, text, title:'),
      		'name'      => 'evolved_form_footergeneral[footer_title_texttransform]',
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
      
      $generalfieldset->addField('footer_title_style', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Style, text, title:'),
      		'name'      => 'evolved_form_footergeneral[footer_title_style]',
      		'values'    => array(
      				array('value'=>'','label'=>'Please Select'),
      				array('value'=>'normal','label'=>'normal'),
      				array('value'=>'italic','label'=>'italic'),
      				array('value'=>'oblique','label'=>'oblique'),
      				array('value'=>'initial','label'=>'initial'),
      				array('value'=>'inherit','label'=>'inherit'),
      		),
      ));
      
      $generalfieldset->addField('footer_title_weight', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Weight, text, title:'),
      		'name'      => 'evolved_form_footergeneral[footer_title_weight]',
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
      
      $generalfieldset->addField('footer_copyright_background_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Copyright ‐ Color, background:'),
      		'name'      => 'evolved_form_footergeneral[footer_copyright_background_color]',
      ));
      
     $generalfieldset->addField('footer_copyright_text_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Copyright ‐ Color, text:'),
      		'name'      => 'evolved_form_footergeneral[footer_copyright_text_color]',
      ));
      
      $generalfieldset->addField('footer_copyright_link_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Copyright ‐ Color, text, link:'),
      		'name'      => 'evolved_form_footergeneral[footer_copyright_link_color]',
      ));
      
      $generalfieldset->addField('footer_copyright_text_size', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Copyright ‐ Size, font (pixels):'),
      		'name'      => 'evolved_form_footergeneral[footer_copyright_text_size]',
      ));
      
      $generalfieldset->addField('footer_copyright_text_texttransform', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Copyright ‐ Transform, text'),
      		'name'      => 'evolved_form_footergeneral[footer_copyright_text_texttransform]',
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
      
      $generalfieldset->addField('footer_copyright_text_style', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Copyright ‐ Style, text'),
      		'name'      => 'evolved_form_footergeneral[footer_copyright_text_style]',
      		'values'    => array(
      				array('value'=>'','label'=>'Please Select'),
      				array('value'=>'normal','label'=>'normal'),
      				array('value'=>'italic','label'=>'italic'),
      				array('value'=>'oblique','label'=>'oblique'),
      				array('value'=>'initial','label'=>'initial'),
      				array('value'=>'inherit','label'=>'inherit'),
      		),
      ));
      
      $generalfieldset->addField('footer_copyright_text_weight', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Copyright ‐ Weight, text'),
      		'name'      => 'evolved_form_footergeneral[footer_copyright_text_weight]',
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
      
      $generalfieldset->addField('footer_responsive_dropdown_link_enable', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Responsive Dropdown Links:'),
      		'name'      => 'evolved_form_footergeneral[footer_responsive_dropdown_link_enable]',
      		'options'   => array(
      				'' => Mage::helper('evolved')->__(''),
      				'0' => Mage::helper('evolved')->__('Disable'),
      				'1' => Mage::helper('evolved')->__('Enable'),
      		),
      ));
      
      $generalfieldset->addField('footer_responsive_dropdown_background_color_title', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Dropdown - Color, background, title'),
      		'name'      => 'evolved_form_footergeneral[footer_responsive_dropdown_background_color_title]',
      ));
      
      $generalfieldset->addField('footer_responsive_dropdown_background_color_link_sublevel', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Dropdown - Color, background, link (sub-level)'),
      		'name'      => 'evolved_form_footergeneral[footer_responsive_dropdown_background_color_link_sublevel]',
      ));
      
      $generalfieldset->addField('footer_responsive_dropdown_color_title', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Dropdown - Color, title'),
      		'name'      => 'evolved_form_footergeneral[footer_responsive_dropdown_color_title]',
      ));
      
      $generalfieldset->addField('footer_responsive_dropdown_size_title', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Dropdown - Size, title:'),
      		'name'      => 'evolved_form_footergeneral[footer_responsive_dropdown_size_title]',
      ));
      
      $generalfieldset->addField('footer_responsive_dropdown_texttransform_title', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Dropdown - Transform, title	'),
      		'name'      => 'evolved_form_footergeneral[footer_responsive_dropdown_texttransform_title]',
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
      
      $generalfieldset->addField('footer_responsive_dropdown_style_title', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Dropdown - Style, title'),
      		'name'      => 'evolved_form_footergeneral[footer_responsive_dropdown_style_title]',
      		'values'    => array(
      				array('value'=>'','label'=>'Please Select'),
      				array('value'=>'normal','label'=>'normal'),
      				array('value'=>'italic','label'=>'italic'),
      				array('value'=>'oblique','label'=>'oblique'),
      				array('value'=>'initial','label'=>'initial'),
      				array('value'=>'inherit','label'=>'inherit'),
      		),
      ));
      
      $generalfieldset->addField('footer_responsive_dropdown_weight_title', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Dropdown - Weight, title'),
      		'name'      => 'evolved_form_footergeneral[footer_responsive_dropdown_weight_title]',
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
      
      
      $advancedfieldset = $form->addFieldset('evolved_form_footeradvanced', array('legend'=>Mage::helper('evolved')->__('Advanced Settings')));
      $advancedfieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
      
      $advancedfieldset->addField('footer_border_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Border color:'),
      		'name'      => 'evolved_form_footeradvanced[footer_border_color]',
      ));
      
      $advancedfieldset->addField('footer_linkhover_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Link hover color:'),
      		'name'      => 'evolved_form_footeradvanced[footer_linkhover_color]',
      ));
      
      $advancedfieldset->addField('footer_linkhover_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Link hover background color:'),
      		'name'      => 'evolved_form_footeradvanced[footer_linkhover_background]',
      ));
      
      $advancedfieldset->addField('footer_newsletter_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Newsletter background color:'),
      		'name'      => 'evolved_form_footeradvanced[footer_newsletter_background]',
      ));
      /*
      $advancedfieldset->addField('footer_button_text_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button text color:'),
      		'name'      => 'footer_button_text_color',
      ));
      
      $advancedfieldset->addField('footer_button_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button background color:'),
      		'name'      => 'footer_button_background',
      ));
      
      $advancedfieldset->addField('footer_button_text_hover', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button text hover color:'),
      		'name'      => 'footer_button_text_hover',
      ));
      
      $advancedfieldset->addField('footer_button_hover_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button hover background color:'),
      		'name'      => 'footer_button_hover_background',
      ));*/
      
      $advancedfieldset->addField('footer_copyright_linkhover_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Copyright link hover background color:'),
      		'name'      => 'evolved_form_footeradvanced[footer_copyright_linkhover_background]',
      ));
      
      $advancedfieldset->addField('footer_copyright_linkhover_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Copyright link hover color:'),
      		'name'      => 'evolved_form_footeradvanced[footer_copyright_linkhover_color]',
      ));
      
      $advancedfieldset2 = $form->addFieldset('evolved_form_footer_advanced', array('legend'=>Mage::helper('evolved')->__('Footer Elements')));
      $advancedfieldset2->addField('footer_style_column', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Footer Style (Must need to apply css rules):'),
      		'name'      => 'evolved_form_footer_advanced[footer_style_column]',
      		'options'   => array(
      				'' => Mage::helper('evolved')->__(''),
      				'1' => Mage::helper('evolved')->__('Single Row'),
      				'2' => Mage::helper('evolved')->__('2 Columns'),
      				'3' => Mage::helper('evolved')->__('3 Columns'),
      				'4' => Mage::helper('evolved')->__('4 Columns'),
      				'5' => Mage::helper('evolved')->__('5 Columns'),
      				'6' => Mage::helper('evolved')->__('6 Columns'),
      		),
      ));
      
      $advancedfieldset2->addField('footer_newsletter_style', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Newsletter Style:'),
      		'name'      => 'evolved_form_footer_advanced[footer_newsletter_style]',
      		'options'   => array(
      				'None' => Mage::helper('evolved')->__('None'),
      				'Light' => Mage::helper('evolved')->__('Light'),
      				'Dark' => Mage::helper('evolved')->__('Dark'),
      		),
      ));
      
      $advancedfieldset2->addField('footer_enabled_column_1', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Column-1:'),
      		'name'      => 'evolved_form_footer_advanced[footer_enabled_column_1]',
      		'options'   => array(
      				-1 => Mage::helper('evolved')->__('Please Select'),
      				0 => Mage::helper('evolved')->__('Disable'),
      				1 => Mage::helper('evolved')->__('Enable'),
      		),
      ));
      $advancedfieldset2->addField('footer_content_column_1', 'editor', array(
      		'label'     => Mage::helper('evolved')->__('Column-1 Content:'),
      		'name'      => 'evolved_form_footer_advanced[footer_content_column_1]',
      		'config'    => $configSettings,
      ));
      
      $advancedfieldset2->addField('footer_enabled_column_2', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Column-2:'),
      		'name'      => 'evolved_form_footer_advanced[footer_enabled_column_2]',
      		'options'   => array(
      				-1 => Mage::helper('evolved')->__('Please Select'),
      				0 => Mage::helper('evolved')->__('Disable'),
      				1 => Mage::helper('evolved')->__('Enable'),
      		),
      ));
      $advancedfieldset2->addField('footer_content_column_2', 'editor', array(
      		'label'     => Mage::helper('evolved')->__('Column-2 Content:'),
      		'name'      => 'evolved_form_footer_advanced[footer_content_column_2]',
      		'config'    => $configSettings,
      ));
      
      $advancedfieldset2->addField('footer_enabled_column_3', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Column-3:'),
      		'name'      => 'evolved_form_footer_advanced[footer_enabled_column_3]',
      		'options'   => array(
      				-1 => Mage::helper('evolved')->__('Please Select'),
      				0 => Mage::helper('evolved')->__('Disable'),
      				1 => Mage::helper('evolved')->__('Enable'),
      		),
      ));
      $advancedfieldset2->addField('footer_content_column_3', 'editor', array(
      		'label'     => Mage::helper('evolved')->__('Column-3 Content:'),
      		'name'      => 'evolved_form_footer_advanced[footer_content_column_3]',
      		'config'    => $configSettings,
      ));
      
      $advancedfieldset2->addField('footer_enabled_column_4', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Column-4 (Social):'),
      		'name'      => 'evolved_form_footer_advanced[footer_enabled_column_4]',
      		'options'   => array(
      				-1 => Mage::helper('evolved')->__('Please Select'),
      				0 => Mage::helper('evolved')->__('Disable'),
      				1 => Mage::helper('evolved')->__('Enable'),
      				2 => Mage::helper('evolved')->__('Enable with Newsletter'),
      		),
      ));
      /* $advancedfieldset2->addField('footer_content_column_4', 'editor', array( // Loading dynamic from social tab fields
       'label'     => Mage::helper('evolved')->__('Footer Column-4 Content:'),
       'name'      => 'footer_content_column_4',
       'config'    => $configSettings,
      )); */
      
      $advancedfieldset2->addField('footer_enabled_column_5', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Column-5 (Newsletter):'),
      		'name'      => 'evolved_form_footer_advanced[footer_enabled_column_5]',
      		'options'   => array(
      				-1 => Mage::helper('evolved')->__('Please Select'),
      				0 => Mage::helper('evolved')->__('Disable'),
      				1 => Mage::helper('evolved')->__('Enable'),
      				2 => Mage::helper('evolved')->__('Enable with Social'),
      		),
      ));
      
      $advancedfieldset2->addField('footer_enabled_column_6', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Column-6:'),
      		'name'      => 'evolved_form_footer_advanced[footer_enabled_column_6]',
      		'options'   => array(
      				-1 => Mage::helper('evolved')->__('Please Select'),
      				0 => Mage::helper('evolved')->__('Disable'),
      				1 => Mage::helper('evolved')->__('Enable'),
      		),
      ));
      
      $advancedfieldset2->addField('footer_content_column_6', 'editor', array(
      		'label'     => Mage::helper('evolved')->__('Column-6 Content:'),
      		'name'      => 'evolved_form_footer_advanced[footer_content_column_6]',
      		'config'    => $configSettings,
      ));
      
    
      $advancedfieldset2->addField('Jump_to_Top', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Jump_to_Top:'),
      		'name'      => 'evolved_form_footer_advanced[Jump_to_Top]',
      		'options'   => array(
      				-1 => Mage::helper('evolved')->__('Please Select'),
      				0 => Mage::helper('evolved')->__('Disable'),
      				1 => Mage::helper('evolved')->__('Enable'),
      		),
      ));
      
	  
	  
      $fieldset3 = $form->addFieldset('evolved_footer_sort_order_of_elements', array('legend'=>Mage::helper('evolved')->__('Sort Order of Elements')));
      
      $fieldset3->addField('footer_sort_column_1', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Column 1:'),
      		'name'      => 'evolved_footer_sort_order_of_elements[footer_sort_column_1]',
      ));
      
      $fieldset3->addField('footer_sort_column_2', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Column 2:'),
      		'name'      => 'evolved_footer_sort_order_of_elements[footer_sort_column_2]',
      ));
      
      $fieldset3->addField('footer_sort_column_3', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Column 3:'),
      		'name'      => 'evolved_footer_sort_order_of_elements[footer_sort_column_3]',
      ));
      
      $fieldset3->addField('footer_sort_column_4', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Column 4:'),
      		'name'      => 'evolved_footer_sort_order_of_elements[footer_sort_column_4]',
      ));
      
      $fieldset3->addField('footer_sort_column_5', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Column 5:'),
      		'name'      => 'evolved_footer_sort_order_of_elements[footer_sort_column_5]',
      ));
    
      $fieldset3->addField('footer_sort_column_6', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Column 6:'),
      		'name'      => 'evolved_footer_sort_order_of_elements[footer_sort_column_6]',
      ));
	  
	   
      //$footerbarfieldset = $form->addFieldset('evolved_form_footerbar', array('legend'=>Mage::helper('evolved')->__('Drop up button')));
      $footerbarfieldset = $form->addFieldset('evolved_form_footerbar', array('legend'=>Mage::helper('evolved')->__('Call-to-action (CTA) bar')));
      $footerbarfieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
      
      $footerbarfieldset->addField('footer_enable_footerbar', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Enable Footer Bar:'),
      		'name'      => 'evolved_form_footerbar[footer_enable_footerbar]',
      		'options'   => array(
      				'-1' => Mage::helper('evolved')->__('Please Select'),
      				'0' => Mage::helper('evolved')->__('Disable'),
      				'subscribe_and_social_media' => Mage::helper('evolved')->__('Subscribe and Social Media'),
      				'subscribe_only' => Mage::helper('evolved')->__('Subscribe only'),
      				'social_media_only' => Mage::helper('evolved')->__('Social media only'),
      				'html_only' => Mage::helper('evolved')->__('HTML only'),
      		),
      ));
      
      $footerbarfieldset->addField('footer_footerbar_position', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Position:'),
      		'name'      => 'evolved_form_footerbar[footer_footerbar_position]',
      		'options'   => array(
      				'-1' => Mage::helper('evolved')->__('Please Select'),
      				'above_footer_elements' => Mage::helper('evolved')->__('Above footer elements'),
      				'below_footer_elements' => Mage::helper('evolved')->__('Below footer elements'),
      		),
      ));
      
      $footerbarfieldset->addField('footer_footerbar_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, background:'),
      		'name'      => 'evolved_form_footerbar[footer_footerbar_background]',
      ));
      
      $footerbarfieldset->addField('footer_footerbar_text', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, text:'),
      		'name'      => 'evolved_form_footerbar[footer_footerbar_text]',
      ));
      
      /*$footerbarfieldset->addField('footer_footerbar_height', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Height (pixels):'),
      		'name'      => 'footer_footerbar_height',
      ));*/
      
      $footerbarfieldset->addField('footer_footerbar_paddingtopbottom', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Padding top/bottom (pixels):'),
      		'name'      => 'evolved_form_footerbar[footer_footerbar_paddingtopbottom]',
      ));
      
      $footerbarfieldset->addField('footer_footerbar_htmlblock', 'editor', array(
      		'label'     => Mage::helper('evolved')->__('HTML Block:'),
      		'name'      => 'evolved_form_footerbar[footer_footerbar_htmlblock]',
      		'config'    => $configSettings,
      ));
      Mage::getSingleton('core/session')->setBlockName('evolved_footer');
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