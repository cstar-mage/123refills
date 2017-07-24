<?php
class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Tab_Header extends Mage_Adminhtml_Block_Widget_Form
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
      
      $fieldsetgeneral = $form->addFieldset('evolved_form_header_general', array('legend'=>Mage::helper('evolved')->__('General Settings')));
      $fieldsetgeneral->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
      
      $fieldsetgeneral->addField('header_background_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Background, color:'),
      		'name'      => 'evolved_form_header_general[header_background_color]',
      ));
      
      $fieldsetgeneral->addField('header_background_image', 'image', array(
      		'label'     => Mage::helper('evolved')->__('Background, image:'),
      		'name'      => 'evolved_form_header_general[header_background_image]',
      ));
      
      $fieldsetgeneral->addField('header_background_image_repeat', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Background, image repeat:'),
      		'name'      => 'evolved_form_header_general[header_background_image_repeat]',
      		'options'   => array(
      				'no-repeat' => Mage::helper('evolved')->__('no-repeat'),
      				'repeat-x' => Mage::helper('evolved')->__('repeat-x'),
      				'repeat-y' => Mage::helper('evolved')->__('repeat-y'),
      				'repeat' => Mage::helper('evolved')->__('repeat'),
      		),
      ));
      
      $fieldsetgeneral->addField('header_background_image_position', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Background, image alignment:'),
      		'name'      => 'evolved_form_header_general[header_background_image_position]',
      		'options'   => array(
      				'left' => Mage::helper('evolved')->__('left'),
      				'center' => Mage::helper('evolved')->__('center'),
      				'right' => Mage::helper('evolved')->__('right'),
      		),
      ));
      
      $fieldsetgeneral->addField('header_underline_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Underline below header:'),
      		'name'      => 'evolved_form_header_general[header_underline_color]',
      ));
      
      $fieldsetgeneral->addField('header_bottom_space', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Margin below header:'),
      		'name'      => 'evolved_form_header_general[header_bottom_space]',
      ));
      
      $fieldsetgeneral->addField('sticky_header_options', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Sticky Header:'),
      		'name'      => 'evolved_form_header_general[sticky_header_options]',
      		'options'   => array(
      				'enable' => Mage::helper('evolved')->__('Enable'),
      				'disable' => Mage::helper('evolved')->__('Disable'),
      		),
      ));
      
      $fieldsetgeneral->addField('header_height', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Height:'),
      		'name'      => 'evolved_form_header_general[header_height]',
      ));

      $fieldsetlogo = $form->addFieldset('evolved_form_header_logo', array('legend'=>Mage::helper('evolved')->__('Logo')));
      $fieldsetlogo->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
      
      $fieldsetlogo->addField('header_logo_placement', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Alignment:'),
      		'name'      => 'evolved_form_header_logo[header_logo_placement]',
      		'options'   => array(
      				'left' => Mage::helper('evolved')->__('Left Aligned'),
      				'center' => Mage::helper('evolved')->__('Center'),
      		),
      ));
      
      $fieldsetlogo->addField('header_responsive_logo_placement', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Alignment, responsive'),
      		'name'      => 'evolved_form_header_logo[header_responsive_logo_placement]',
      		'options'   => array(
      				'left' => Mage::helper('evolved')->__('Left Aligned'),
      				'center' => Mage::helper('evolved')->__('Center'),
      		),
      ));
      
      $fieldsetlogo->addField('header_logo_background_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Logo background color:'),
      		'name'      => 'evolved_form_header_logo[header_logo_background_color]',
      		'note'  => Mage::helper('evolved')->__('Leave empty to use main color'),
      ));
      
      
      $fieldsetlogo->addField('margin_above_logo', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Margin above logo (pixels):'),
      		'name'      => 'evolved_form_header_logo[margin_above_logo]',
      ));
      
      
      $fieldsetDropdownstoplink = $form->addFieldset('evolved_form_header_dropdown_toplink', array('legend'=>Mage::helper('evolved')->__('Top Links')));
      $fieldsetDropdownstoplink->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
      /*
	$fieldsetDropdownstoplink->addField('header_dropdown_toplink_option', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Top Links Style:'),
      		'name'      => 'header_dropdown_toplink_option',
      		'options'   => array(
					'simple' => Mage::helper('evolved')->__('Simple'),
      				'dropdown' => Mage::helper('evolved')->__('Dropdown'),
      		),
      		'style'   => "display:none; "
      ));
	*/
      
      $fieldsetDropdownstoplink->addField('header_dropdown_toplink_alignment', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Alignment:'),
      		'name'      => 'evolved_form_header_dropdown_toplink[header_dropdown_toplink_alignment]',
      		'options'   => array(
      				'left' => Mage::helper('evolved')->__('Left'),
      				'center' => Mage::helper('evolved')->__('Center'),
      				'right' => Mage::helper('evolved')->__('Right'),
      		),
      ));
      
      $fieldsetDropdownstoplink->addField('header_topbar_background_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, background:'),
      		'name'      => 'evolved_form_header_dropdown_toplink[header_topbar_background_color]',
      ));
      
      $fieldsetDropdownstoplink->addField('header_topbar_texthover_background_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, background, hover:'),
      		'name'      => 'evolved_form_header_dropdown_toplink[header_topbar_texthover_background_color]',
      ));
      
      $fieldsetDropdownstoplink->addField('header_topbar_text_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, text:'),
      		'name'      => 'evolved_form_header_dropdown_toplink[header_topbar_text_color]',
      ));
   
      $fieldsetDropdownstoplink->addField('header_topbar_texthover_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, text, hover:'),
      		'name'      => 'evolved_form_header_dropdown_toplink[header_topbar_texthover_color]',
      		'note'  => Mage::helper('evolved')->__('Leave empty to use main color'),
      ));
      
      $fieldsetDropdownstoplink->addField('header_dropdown_toplink_fontsize', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Font size (pixels):'),
      		'name'      => 'evolved_form_header_dropdown_toplink[header_dropdown_toplink_fontsize]',
      ));
      
      $fieldsetDropdownstoplink->addField('header_topbar_text_texttransform', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Transform, text'),
      		'name'      => 'evolved_form_header_dropdown_toplink[header_topbar_text_texttransform]',
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
      
      $fieldsetDropdownstoplink->addField('header_topbar_text_style', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Style, text'),
      		'name'      => 'evolved_form_header_dropdown_toplink[header_topbar_text_style]',
      		'values'    => array(
      				array('value'=>'','label'=>'Please Select'),
      				array('value'=>'normal','label'=>'normal'),
      				array('value'=>'italic','label'=>'italic'),
      				array('value'=>'oblique','label'=>'oblique'),
      				array('value'=>'initial','label'=>'initial'),
      				array('value'=>'inherit','label'=>'inherit'),
      		),
      ));
      
      $fieldsetDropdownstoplink->addField('header_topbar_text_weight', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Weight, text'),
      		'name'      => 'evolved_form_header_dropdown_toplink[header_topbar_text_weight]',
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
      
      $fieldsetDropdownstoplink->addField('header_dropdown_toplink_margintop', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Margin above Top Links (pixels):'),
      		'name'      => 'evolved_form_header_dropdown_toplink[header_dropdown_toplink_margintop]',
      )); 
   
     $fieldsetDropdownstoplink->addField('top_links_option', 'multiselect', array(
      		'label'     => Mage::helper('evolved')->__('Top Links options'),
      		'name'      => 'evolved_form_header_dropdown_toplink[top_links_option]',
      		'values' => array(
				      				array('value'=>'' , 'label' => 'Please Select'),
      							    array('value'=>'catalogsearch/advanced/' , 'label' => 'Search'),
      								array('value'=>'checkout/cart/' , 'label' => 'Cart'),
      								array('value'=>'checkout/' , 'label' => 'Checkout'),
      								array('value'=>'customer/account/create/' , 'label' => 'Register'),
      								array('value'=>'customer/account/login/' , 'label' => 'Login'),
      								array('value'=>'customer/account/' , 'label' => 'My Account'),
      								array('value'=>'wishlist/' , 'label' =>'Wishlist'),
      								array('value'=>'contacts/' , 'label' =>'Contact us')
      						),
      ));
     
     $fieldsetDropdownstoplink->addField('header_topbar_custom_block', 'editor', array(
     		'label'     => Mage::helper('evolved')->__('Custom Block:'),
     		'name'      => 'evolved_form_header_dropdown_toplink[header_topbar_custom_block]',
     		'config'    => $configSettings,
     ));

     
     /**************** start remove this option *********************/
      /*$fieldsetDropdownstoplink->addField('header_icon_color', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Icon color:'),
      		'name'      => 'header_icon_color',
      		'options'   => array(
      				'black' => Mage::helper('evolved')->__('Black'),
      				'blue' => Mage::helper('evolved')->__('Blue'),
      		),
      ));
      
      $fieldsetDropdownstoplink->addField('header_topbar_text_fontsize', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Top Bar text font size:'),
      		'name'      => 'header_topbar_text_fontsize',
      ));*/

      /**************** end remove this option *********************/

      

      /*
      $fieldsetDropdownstoplink->addField('header_dropdown_background_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Dropdown background color:'),
      		'name'      => 'header_dropdown_background_color',
      ));
      
      $fieldsetDropdownstoplink->addField('header_dropdown_item_background_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Dropdown item background color:'),
      		'name'      => 'header_dropdown_item_background_color',
      		'note'  => Mage::helper('evolved')->__('I.e. - products list in cart dropdown'),
      ));
      
      $fieldsetDropdownstoplink->addField('header_dropdown_editremove_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Dropdown edit / remove buttons background color:'),
      		'name'      => 'header_dropdown_editremove_background',
      		'note'  => Mage::helper('evolved')->__('In cart dropdown'),
      ));
      
      $fieldsetDropdownstoplink->addField('header_dropdown_editremove_icon', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Dropdown edit / remove buttons Icon color'),
      		'name'      => 'header_dropdown_editremove_icon',
      		'options'   => array(
      				'black' => Mage::helper('evolved')->__('Black'),
      				'white' => Mage::helper('evolved')->__('White'),
      		),
      ));
      
      $fieldsetDropdownstoplink->addField('header_dropdown_text_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Dropdown text color:'),
      		'name'      => 'header_dropdown_text_color',
      ));
      
      $fieldsetDropdownstoplink->addField('header_dropdown_texthover_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Dropdown text hover color:'),
      		'name'      => 'header_dropdown_texthover_color',
      ));
      
      $fieldsetDropdownstoplink->addField('header_dropdown_background_hover', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Dropdown background hover color:'),
      		'name'      => 'header_dropdown_background_hover',
      ));
      
      $fieldsetDropdownstoplink->addField('header_dropdown_background_hover_text_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Dropdown background hover text color:'),
      		'name'      => 'header_dropdown_background_hover_text_color',
      ));
      */

      $fieldsetnavigation = $form->addFieldset('evolved_form_navigation', array('legend'=>Mage::helper('evolved')->__('Navigation')));
       
      $fieldsetnavigation->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
      
      $fieldsetnavigation->addField('navigation_menu_alignment', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Alignment:'),
      		'name'      => 'evolved_form_navigation[navigation_menu_alignment]',
      		'options'   => array(
      				'left' => Mage::helper('evolved')->__('Left'),
      				'center' => Mage::helper('evolved')->__('Center'),
      				'right' => Mage::helper('evolved')->__('Right'),
      		),
      ));
      
      /*$fieldsetnavigation->addField('navigation_menu_spacing', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Menu spacing:'),
      		'name'      => 'navigation_menu_spacing',
      ));*/
      
      $fieldsetnavigation->addField('navigation_top_background_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, background:'),
      		'name'      => 'evolved_form_navigation[navigation_top_background_color]',
      		'note'  => Mage::helper('evolved')->__('Leave empty to use main theme color'),
      ));
      
      /************************ start new option ******************************/
      $fieldsetnavigation->addField('navigation_top_hover_background_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, background, hover:'),
      		'name'      => 'evolved_form_navigation[navigation_top_hover_background_color]',
      ));
      /************************ end new option ******************************/
      
      $fieldsetnavigation->addField('navigation_top_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, text:'),
      		'name'      => 'evolved_form_navigation[navigation_top_color]',
      ));

      $fieldsetnavigation->addField('navigation_top_hover_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, text, hover:'),
      		'name'      => 'evolved_form_navigation[navigation_top_hover_color]',
      ));
      
      $fieldsetnavigation->addField('navigation_top_font_size', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Font size (pixels):'),
      		'name'      => 'evolved_form_navigation[navigation_top_font_size]',
      		'note'  => Mage::helper('evolved')->__('Top level ONLY Font size in PX'),
      ));
      
      $fieldsetnavigation->addField('navigation_top_text_texttransform', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Transform, text'),
      		'name'      => 'evolved_form_navigation[navigation_top_text_texttransform]',
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
      
      $fieldsetnavigation->addField('navigation_top_text_style', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Style, text'),
      		'name'      => 'evolved_form_navigation[navigation_top_text_style]',
      		'values'    => array(
      				array('value'=>'','label'=>'Please Select'),
      				array('value'=>'normal','label'=>'normal'),
      				array('value'=>'italic','label'=>'italic'),
      				array('value'=>'oblique','label'=>'oblique'),
      				array('value'=>'initial','label'=>'initial'),
      				array('value'=>'inherit','label'=>'inherit'),
      		),
      ));
      
      $fieldsetnavigation->addField('navigation_top_text_weight', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Weight, text'),
      		'name'      => 'evolved_form_navigation[navigation_top_text_weight]',
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
      
      $fieldsetnavigation->addField('navigation_sub_container_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Dropdown ‐ Color, background:'),
      		'name'      => 'evolved_form_navigation[navigation_sub_container_background]',
      ));
      
      $fieldsetnavigation->addField('navigation_sub_link_hover_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Dropdown ‐ Color, background, hover:'),
      		'name'      => 'evolved_form_navigation[navigation_sub_link_hover_background]',
      ));
      
      $fieldsetnavigation->addField('navigation_sub_link_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Dropdown ‐ Color, text:'),
      		'name'      => 'evolved_form_navigation[navigation_sub_link_color]',
      ));
     
      $fieldsetnavigation->addField('navigation_sub_link_hover_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Dropdown ‐ Color, text, hover:'),
      		'name'      => 'evolved_form_navigation[navigation_sub_link_hover_color]',
      ));
      
      $fieldsetnavigation->addField('navigation_sub_text_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Dropdown ‐ Color, parent text:'),
      		'name'      => 'evolved_form_navigation[navigation_sub_text_color]',
      ));
      
      /******************** start remove this ************************/
      $fieldsetnavigation->addField('navigation_megamenu_border_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Dropdown ‐ Color, border'),
      		'name'      => 'evolved_form_navigation[navigation_megamenu_border_color]',
      ));
      /******************** end remove this ************************/
      
      $fieldsetnavigation->addField('navigation_menu_font_size', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Dropdown ‐ Font size (pixels):'),
      		'name'      => 'evolved_form_navigation[navigation_menu_font_size]',
      		'note'  => Mage::helper('evolved')->__('Top level ONLY Font size in PX'),
      ));
      
      $fieldsetnavigation->addField('navigation_menu_text_texttransform', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Dropdown ‐ Transform, text'),
      		'name'      => 'evolved_form_navigation[navigation_menu_text_texttransform]',
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
      
      $fieldsetnavigation->addField('navigation_menu_text_style', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Dropdown ‐ Style, text'),
      		'name'      => 'evolved_form_navigation[navigation_menu_text_style]',
      		'values'    => array(
      				array('value'=>'','label'=>'Please Select'),
      				array('value'=>'normal','label'=>'normal'),
      				array('value'=>'italic','label'=>'italic'),
      				array('value'=>'oblique','label'=>'oblique'),
      				array('value'=>'initial','label'=>'initial'),
      				array('value'=>'inherit','label'=>'inherit'),
      		),
      ));
      
      $fieldsetnavigation->addField('navigation_menu_text_weight', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Dropdown ‐ Weight, text'),
      		'name'      => 'evolved_form_navigation[navigation_menu_text_weight]',
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
      

      
      /*$fieldsetnavigation->addField('navigation_sub_icon_color', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Sub level Icon color:'),
      		'name'      => 'navigation_sub_icon_color',
      		'options'   => array(
      				'black' => Mage::helper('evolved')->__('Black'),
      				'white' => Mage::helper('evolved')->__('White'),
      		),
      ));
      */
      
      /******************** start remove this ************************/
      /*$fieldsetnavigation->addField('navigation_sub_icon_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Sub level Icon color:'),
      		'name'      => 'navigation_sub_icon_color',
      ));*/

      /******************** end remove this ************************/
      
      $fieldset = $form->addFieldset('evolved_form_header', array('legend'=>Mage::helper('evolved')->__('Search')));
      $fieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
      
      $fieldset->addField('header_search_enable', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Enable:'),
      		'name'      => 'evolved_form_header[header_search_enable]',
      		'options'   => array(
      				'clickable' => Mage::helper('evolved')->__('Clickable'),
      				'enable' => Mage::helper('evolved')->__('Enable'),
      				'disable' => Mage::helper('evolved')->__('Disable'),
      		),
      ));
      
      $fieldset->addField('header_search_inside_menu_enable', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Enable, inside menu:'),
      		'name'      => 'evolved_form_header[header_search_inside_menu_enable]',
      		'options'   => array(
      				'1' => Mage::helper('evolved')->__('Enable'),
      				'0' => Mage::helper('evolved')->__('Disable'),
      		),
      ));
      
      $fieldset->addField('header_search_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, background:'),
      		'name'      => 'evolved_form_header[header_search_background]',
      ));
      
      $fieldset->addField('header_search_text_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, text:'),
      		'name'      => 'evolved_form_header[header_search_text_color]',
      ));
      
      
      
      /***************** start remove this ********************************/
      $fieldset->addField('header_search_icon', 'image', array(
      		'label'     => Mage::helper('evolved')->__('Image, search icon:'),
      		'name'      => 'evolved_form_header[header_search_icon]',
      ));

      /***************** end remove this ********************************/
      
      $fieldsetadvancedsetting = $form->addFieldset('evolved_form_header_advanced_navigation', array('legend'=>Mage::helper('evolved')->__('Advanced Settings')));
      $fieldsetadvancedsetting->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
      
      $fieldsetadvancedsetting->addField('header_navigation_margin_between_links', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Navigation ‐ Margin between links (pixels):'),
      		'name'      => 'evolved_form_header_advanced_navigation[header_navigation_margin_between_links]',
      ));
      
      $fieldsetadvancedsetting->addField('header_navigation_margin_below_links', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Navigation ‐ Margin below links (pixels):'),
      		'name'      => 'evolved_form_header_advanced_navigation[header_navigation_margin_below_links]',
      ));
      
      $fieldsetadvancedsetting->addField('header_navigation_padding_abovebelow_text', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Navigation ‐ Padding above/below text (pixels):'),
      		'name'      => 'evolved_form_header_advanced_navigation[header_navigation_padding_abovebelow_text]',
      ));
      
      $fieldsetadvancedsetting->addField('header_navigation_padding_side_text', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Navigation ‐ Padding sides of text (pixels) :'),
      		'name'      => 'evolved_form_header_advanced_navigation[header_navigation_padding_side_text]',
      ));
      
      $fieldsetadvancedsetting->addField('header_navigation_border_top_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Navigation ‐ Color, border, top :'),
      		'name'      => 'evolved_form_header_advanced_navigation[header_navigation_border_top_color]',
      ));
      
      $fieldsetadvancedsetting->addField('header_navigation_border_bottom_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Navigation ‐ Color, border, bottom :'),
      		'name'      => 'evolved_form_header_advanced_navigation[header_navigation_border_bottom_color]',
      ));
      
      $fieldsetadvancedsetting->addField('header_navigation_border_top_size', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Navigation ‐ Size, border, top (pixels) :'),
      		'name'      => 'evolved_form_header_advanced_navigation[header_navigation_border_top_size]',
      ));
      
      $fieldsetadvancedsetting->addField('header_navigation_border_bottom_size', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Navigation ‐ Size, border, bottom (pixels) :'),
      		'name'      => 'evolved_form_header_advanced_navigation[header_navigation_border_bottom_size]',
      ));
      Mage::getSingleton('core/session')->setBlockName('evolved_header');
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