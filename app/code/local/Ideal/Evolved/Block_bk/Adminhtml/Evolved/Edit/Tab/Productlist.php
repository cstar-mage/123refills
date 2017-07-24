<?php

class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Tab_Productlist extends Mage_Adminhtml_Block_Widget_Form
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
      
      $fieldsetgeneral = $form->addFieldset('evolved_form_productlist_general', array('legend'=>Mage::helper('evolved')->__('General')));
      $fieldsetgeneral->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));

      $fieldsetgeneral->addField('productlist_margin_below_header', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Margin below header (pixels):'),
      		'name'      => 'productlist_margin_below_header',
      ));
      
      $fieldsetgeneral->addField('productlist_producttitle_hover_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, background, titles, hover:'),
      		'name'      => 'productlist_producttitle_hover_background',
      ));
      
      $fieldsetgeneral->addField('productlist_product_name_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, titles:'),
      		'name'      => 'productlist_product_name_color',
      ));
      
      $fieldsetgeneral->addField('productlist_producttitle_hover_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, titles, hover:'),
      		'name'      => 'productlist_producttitle_hover_color',
      ));
      
      $fieldsetgeneral->addField('productlist_product_name_fontsize', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Size, titles (pixels):'),
      		'name'      => 'productlist_product_name_fontsize',
      ));
      
      $fieldsetgeneral->addField('productlist_product_name_texttransform', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Transform, titles'),
      		'name'      => 'productlist_product_name_texttransform',
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
      
      $fieldsetgeneral->addField('productlist_product_name_style', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Style, titles'),
      		'name'      => 'productlist_product_name_style',
      		'values'    => array(
      				array('value'=>'','label'=>'Please Select'),
      				array('value'=>'normal','label'=>'normal'),
      				array('value'=>'italic','label'=>'italic'),
      				array('value'=>'oblique','label'=>'oblique'),
      				array('value'=>'initial','label'=>'initial'),
      				array('value'=>'inherit','label'=>'inherit'),
      		),
      ));
      
      $fieldsetgeneral->addField('productlist_product_name_weight', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Weight, titles'),
      		'name'      => 'productlist_product_name_weight',
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
        
      /*$fieldsetgeneral->addField('productlist_description_texthover', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Description ‐ Color, text, hover:'),
      		'name'      => 'productlist_description_texthover',
      ));*/
      
      $fieldsetbreadcrumbs = $form->addFieldset('evolved_form_productlist_breadcrumbs', array('legend'=>Mage::helper('evolved')->__('Breadcrumbs')));
      $fieldsetbreadcrumbs->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
      
      $fieldsetbreadcrumbs->addField('breadcrumbs_enable_option', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Enable:'),
      		'name'      => 'breadcrumbs_enable_option',
      		'options'	=> array(
      				'-1'  => 'Please Select',
      		   '0' => 'Enable',
           	   '1' => 'Disable',
      				
      		),
      ));
      
      $fieldsetbreadcrumbs->addField('breadcrumbs_margin_below', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Margin below breadcrumbs (pixels):'),
      		'name'      => 'breadcrumbs_margin_below',
      ));
      
      $fieldsetbreadcrumbs->addField('breadcrumbs_background_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, background:'),
      		'name'      => 'breadcrumbs_background_color',
      ));
      
      $fieldsetbreadcrumbs->addField('breadcrumbs_link_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, link:'),
      		'name'      => 'breadcrumbs_link_color',
      ));
      
      $fieldsetbreadcrumbs->addField('breadcrumbs_link_hover_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, link, hover:'),
      		'name'      => 'breadcrumbs_link_hover_color',
      ));
      
      $fieldsetbreadcrumbs->addField('breadcrumbs_text_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, text:'),
      		'name'      => 'breadcrumbs_text_color',
      ));
      
      $fieldsetbreadcrumbs->addField('breadcrumbs_text_size', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Size, text:'),
      		'name'      => 'breadcrumbs_text_size',
      ));
      
      $fieldsetbreadcrumbs->addField('breadcrumbs_text_texttransform', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Transform, text'),
      		'name'      => 'breadcrumbs_text_texttransform',
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
      
      $fieldsetbreadcrumbs->addField('breadcrumbs_text_style', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Style, text'),
      		'name'      => 'breadcrumbs_text_style',
      		'values'    => array(
      				array('value'=>'','label'=>'Please Select'),
      				array('value'=>'normal','label'=>'normal'),
      				array('value'=>'italic','label'=>'italic'),
      				array('value'=>'oblique','label'=>'oblique'),
      				array('value'=>'initial','label'=>'initial'),
      				array('value'=>'inherit','label'=>'inherit'),
      		),
      ));
      
      $fieldsetbreadcrumbs->addField('breadcrumbs_text_weight', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Weight, text'),
      		'name'      => 'breadcrumbs_text_weight',
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
      
      $fieldsettoolbar = $form->addFieldset('evolved_form_productlist_toolbar', array('legend'=>Mage::helper('evolved')->__('Toolbar')));     
      $fieldsettoolbar->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
      
      $fieldsettoolbar->addField('productlist_grid_enable_image_size', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Toolbar Options - “Image Size”'),
      		'name'      => 'productlist_grid_enable_image_size',
      		'options'   => array(
      				'yes' => Mage::helper('evolved')->__('Enable'),
      				'no' => Mage::helper('evolved')->__('Disable'),
      		),
      ));
      
      $fieldsettoolbar->addField('productlist_grid_enable_item_count', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Toolbar Options - “Item count”'),
      		'name'      => 'productlist_grid_enable_item_count',
      		'options'   => array(
      				'yes' => Mage::helper('evolved')->__('Enable'),
      				'no' => Mage::helper('evolved')->__('Disable'),
      		),
      ));
      
      $fieldsettoolbar->addField('productlist_grid_enable_sortby', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Toolbar Options - “Sort by”'),
      		'name'      => 'productlist_grid_enable_sortby',
      		'options'   => array(
      				'yes' => Mage::helper('evolved')->__('Enable'),
      				'no' => Mage::helper('evolved')->__('Disable'),
      		),
      ));
      
      /*$fieldsettoolbar->addField('productlist_grid_enable_show_perpage', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Toolbar Options - “Show”'),
      		'name'      => 'productlist_grid_enable_show_perpage',
      		'options'   => array(
      				'yes' => Mage::helper('evolved')->__('Enable'),
      				'no' => Mage::helper('evolved')->__('Disable'),
      		),
      ));*/
      
      $fieldsettoolbar->addField('productlist_grid_enable_pagination', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Toolbar Options - “Pagination”'),
      		'name'      => 'productlist_grid_enable_pagination',
      		'options'   => array(
      				'yes' => Mage::helper('evolved')->__('Enable'),
      				'no' => Mage::helper('evolved')->__('Disable'),
      		),
      ));
      
      $fieldsettoolbar->addField('toolbar_dropdown_arrow_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__(' Toolbar Options - Color, arrow:'),
      		'name'      => 'toolbar_dropdown_arrow_color',
      ));
      
     
      
      $fieldsettoolbar->addField('toolbar_background_color', 'colorpicker', array(
          'label'     => Mage::helper('evolved')->__('Toolbar Background color:'),
          'name'      => 'toolbar_background_color',
      ));
      
      $fieldsettoolbar->addField('toolbar_pages_links_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Toolbar Pages Background color:'),
      		'name'      => 'toolbar_pages_links_background',
      ));
      
      $fieldsettoolbar->addField('toolbar_pages_links_hover_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Toolbar Pages Hover background color:'),
      		'name'      => 'toolbar_pages_links_hover_background',
      ));
      
      $fieldsettoolbar->addField('toolbar_dropdown_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Toolbar Dropdown Background color:'),
      		'name'      => 'toolbar_dropdown_background',
      ));
      
      $fieldsettoolbar->addField('toolbar_text_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Toolbar Text color:'),
      		'name'      => 'toolbar_text_color',
      ));
 
      $fieldsettoolbar->addField('toolbar_pages_links_textcolor', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Toolbar Pages Text color:'),
      		'name'      => 'toolbar_pages_links_textcolor',
      ));
      
      $fieldsettoolbar->addField('toolbar_text_size', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Size, text:'),
      		'name'      => 'toolbar_text_size',
      ));
      
      $fieldsettoolbar->addField('toolbar_text_texttransform', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Transform, text'),
      		'name'      => 'toolbar_text_texttransform',
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
      
      $fieldsettoolbar->addField('toolbar_text_style', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Style, text'),
      		'name'      => 'toolbar_text_style',
      		'values'    => array(
      				array('value'=>'','label'=>'Please Select'),
      				array('value'=>'normal','label'=>'normal'),
      				array('value'=>'italic','label'=>'italic'),
      				array('value'=>'oblique','label'=>'oblique'),
      				array('value'=>'initial','label'=>'initial'),
      				array('value'=>'inherit','label'=>'inherit'),
      		),
      ));
      
      $fieldsettoolbar->addField('toolbar_text_weight', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Weight, text'),
      		'name'      => 'toolbar_text_weight',
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
      
      /*$fieldsettoolbar->addField('toolbar_dropdown_linkhover_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Toolbar Dropdown Link hover color:'),
      		'name'      => 'toolbar_dropdown_linkhover_color',
      ));
      
      $fieldsettoolbar->addField('toolbar_dropdown_linkhover_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Toolbar Dropdown Link hover background color:'),
      		'name'      => 'toolbar_dropdown_linkhover_background',
      ));
      
      $fieldsettoolbar->addField('toolbar_dropdown_linkcolor', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Toolbar Dropdown Link color:'),
      		'name'      => 'toolbar_dropdown_linkcolor',
      ));*/
      
      $fieldsettoolbar->addField('toolbar_pages_links_hover_text', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Toolbar Pages Hover Text color:'),
      		'name'      => 'toolbar_pages_links_hover_text',
      ));
      
      $fieldsettoolbar->addField('toolbar_dropdown_textcolor', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Toolbar Dropdown Text color:'),
      		'name'      => 'toolbar_dropdown_textcolor',
      ));
        
      $fieldsetsidebar = $form->addFieldset('evolved_form_productlist_sidebar', array('legend'=>Mage::helper('evolved')->__('Sidebar')));
      $fieldsetsidebar->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));

      $fieldsetsidebar->addField('productlist_sidebar_enable', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Enable:'),
      		'name'      => 'productlist_sidebar_enable',
      		'options'   => array(
	      						'-1' => 'Please Select',
								'0' => 'Enable',
	      						'1' => 'Disable'   				
      						),
      ));
      
      $fieldsetsidebar->addField('productlist_block_background_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Block ‐ Color, background:'),
      		'name'      => 'productlist_block_background_color',
      ));
      
      $fieldsetsidebar->addField('productlist_block_linkhover_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Block ‐ Color, background, link, hover:'),
      		'name'      => 'productlist_block_linkhover_background',
      ));
      
      $fieldsetsidebar->addField('productlist_block_topborder_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Block ‐ Color, border, top:'),
      		'name'      => 'productlist_block_topborder_color',
      		'note' => Mage::helper('evolved')->__('Leave empty to use main color'),
      ));
      
      $fieldsetsidebar->addField('productlist_block_title_below_border_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, border below title:'),
      		'name'      => 'productlist_block_title_below_border_color',
      ));
      
      $fieldsetsidebar->addField('productlist_block_title_below_border_size', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Size, border below title:'),
      		'name'      => 'productlist_block_title_below_border_size',
      ));
      
      $fieldsetsidebar->addField('productlist_block_padding_leftright', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Padding, left/right (pixels):'),
      		'name'      => 'productlist_block_padding_leftright',
      ));
      
      $fieldsetsidebar->addField('productlist_block_itemsborder_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Block ‐ Color, border, items:'),
      		'name'      => 'productlist_block_itemsborder_color',
      		'note' => Mage::helper('evolved')->__('Items divider ( wishlist, checkout progress etc )'),
      ));
      
      $fieldsetsidebar->addField('productlist_block_link_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Block ‐ Color, link:'),
      		'name'      => 'productlist_block_link_color',
      ));
      
      $fieldsetsidebar->addField('productlist_block_linkhover_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Block ‐ Color, link, hover:'),
      		'name'      => 'productlist_block_linkhover_color',
      ));
      
      $fieldsetsidebar->addField('productlist_block_title_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Block ‐ Color, title:'),
      		'name'      => 'productlist_block_title_color',
      ));
      
      $fieldsetsidebar->addField('productlist_block_text_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Block ‐ Color, text:'),
      		'name'      => 'productlist_block_text_color',
      ));
          
      $fieldsetsidebar->addField('productlist_block_title_fontsize', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Block ‐ Size, text:'),
      		'name'      => 'productlist_block_title_fontsize',
      		'note' => Mage::helper('evolved')->__('Font size in PX'),
      ));
      

      

      

      
      /*$fieldsetsidebar->addField('productlist_block_link_icon_color', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Block link icon color:'),
      		'name'      => 'productlist_block_link_icon_color',
      		'options'   => array(
      				'black' => Mage::helper('evolved')->__('Black'),
      				'white' => Mage::helper('evolved')->__('White'),
      		),
      ));*/
      
      /*$fieldsetsidebar->addField('productlist_block_button_textcolor', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button text color:'),
      		'name'      => 'productlist_block_button_textcolor',
      ));
      
      $fieldsetsidebar->addField('productlist_block_button_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button background color:'),
      		'name'      => 'productlist_block_button_background',
      		'note' => Mage::helper('evolved')->__('Leave empty to use main color'),
      ));
      
      $fieldsetsidebar->addField('productlist_block_button_text_hovercolor', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button text hover color:'),
      		'name'      => 'productlist_block_button_text_hovercolor',
      ));
      
      $fieldsetsidebar->addField('productlist_block_button_background_hovercolor', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button background hover color:'),
      		'name'      => 'productlist_block_button_background_hovercolor',
      ));*/
      
      /*  Poll block */
      $fieldsetsidebar->addField('productlist_poll_question_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Poll Question ‐ Color, background:'),
      		'name'      => 'sidebar_poll_question_background',
      ));
      
      $fieldsetsidebar->addField('productlist_poll_question_textcolor', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Poll Question ‐ Color, text:'),
      		'name'      => 'sidebar_poll_question_textcolor',
      ));
     
      $fieldsetsidebar->addField('productlist_sidebar_left_editor_block', 'editor', array(
      		'label'     => Mage::helper('evolved')->__('Block:'),
      		'name'      => 'productlist_sidebar_left_editor_block',
      		'style'     =>  'height:100px;',
      		'config'    => $configSettings,
      		'after_element_html' => '<style>.add-widget,.add-variable { display:none; }</style>',
      ));
      
   //   $fieldset2 = $form->addFieldset('evolved_form_productlist', array('legend'=>Mage::helper('evolved')->__('Advanced')));
    //  $fieldset2->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
      
     /* $fieldset2->addField('productlist_rating_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Rating background:'),
      		'name'      => 'productlist_rating_background',
      ));
      
      $fieldset2->addField('productlist_hover_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Hover background:'),
      		'name'      => 'productlist_hover_background',
      ));
      */

      
     /* $fieldset2->addField('productlist_productprice_hover_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Product price hover color:'),
      		'name'      => 'productlist_productprice_hover_color',
      ));*/
      
      /* Grid mode */

      /*$fieldset2->addField('productlist_grid_addto_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Add-to buttons background:'),
      		'name'      => 'productlist_grid_addto_background',
      		'note'      => Mage::helper('evolved')->__('"Add to cart", "Wishlist", "Compare" buttons'),
      ));
      
      $fieldset2->addField('productlist_grid_addto_hover_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Add-to buttons hover background:'),
      		'name'      => 'productlist_grid_addto_hover_background',
      ));
      
      $fieldset2->addField('productlist_grid_addto_buttons_icon', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Add-to buttons Icon color:'),
      		'name'      => 'productlist_grid_addto_buttons_icon',
      		'options'   => array(
      				'black' => Mage::helper('evolved')->__('Black'),
      				'white' => Mage::helper('evolved')->__('White'),
      		),
      ));
      */
      /* List mode */

	/*
      $fieldset2->addField('productlist_addto_textcolor', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Add-to buttons text color:'),
      		'name'      => 'productlist_addto_textcolor',
      ));
      
      $fieldset2->addField('productlist_addto_texthover', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Add-to buttons text hover color:'),
      		'name'      => 'productlist_addto_texthover',
      ));
      */
      
     /* $fieldset2->addField('productlist_list_addto_hover_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Add-to buttons hover background:'),
      		'name'      => 'productlist_list_addto_hover_background',
      ));
      
      $fieldset2->addField('productlist_list_addto_buttons_icon', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Add-to buttons Icon color:'),
      		'name'      => 'productlist_list_addto_buttons_icon',
      		'options'   => array(
      				'black' => Mage::helper('evolved')->__('Black'),
      				'white' => Mage::helper('evolved')->__('White'),
      		),
      ));
      */
      
      $fieldsetproductlist = $form->addFieldset('evolved_form_productlist_productlist', array('legend'=>Mage::helper('evolved')->__('Product List')));
      $fieldsetproductlist->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
      
      $fieldsetproductlist->addField('productlist_productlist_proimage_border_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Product Images - Color, border:'),
      		'name'      => 'productlist_productlist_proimage_border_color',
      ));
      
      $fieldsetproductlist->addField('productlist_productlist_proimage_border_size', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Product Images - Size, border (pixels):'),
      		'name'      => 'productlist_productlist_proimage_border_size',
      ));
      
      $fieldsetproductlist->addField('productlist_productlist_prodescription', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Product Description:'),
      		'name'      => 'productlist_productlist_prodescription',
      		'options'   => array(
      				'' => Mage::helper('evolved')->__('Please Select'),
      				'hover' => Mage::helper('evolved')->__('Hover'),
      				'static' => Mage::helper('evolved')->__('Static'),
      		),
      ));
      
      $fieldsetproductlist->addField('productlist_productlist_prodescription_background_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Product Description - Color, background:'),
      		'name'      => 'productlist_productlist_prodescription_background_color',
      ));
      
      $fieldsetproductlist->addField('productlist_productlist_prodescription_text_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Product Description - Color, text:'),
      		'name'      => 'productlist_productlist_prodescription_text_color',
      ));
      
      $fieldsetproductlist->addField('productlist_productlist_prodescription_background_opacity', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Product Description - Opacity, background:'),
      		'name'      => 'productlist_productlist_prodescription_background_opacity',
      ));
      Mage::getSingleton('core/session')->setBlockName('evolved_productlist');
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