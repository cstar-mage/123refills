<?php

class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Tab_Productdetails extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
     // $fieldset = $form->addFieldset('evolved_form_productdetails', array('legend'=>Mage::helper('evolved')->__('Product Details')));
     // $fieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
    //  $fieldset->addType('select_fonts', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Font'));
	  
      /************ Start General Setting *********************/
      $generalfieldset = $form->addFieldset('evolved_form_productdetails_generalsetting', array('legend'=>Mage::helper('evolved')->__('General Settings')));
      $generalfieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
      $generalfieldset->addType('select_fonts', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Font'));
      
      $generalfieldset->addField('productdetails_title_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Title ‐ Color, text:'),
      		'name'      => 'productdetails_title_color',
      ));
      
      $generalfieldset->addField('productdetails_title_font_size', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Title ‐ Size, text (pixels):'),
      		'name'      => 'productdetails_title_font_size',
      ));
      
      $generalfieldset->addField('productdetails_title_texttransform', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Title ‐ Transform, text'),
      		'name'      => 'productdetails_title_texttransform',
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
      
      $generalfieldset->addField('productdetails_title_style', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Title ‐ Style, text'),
      		'name'      => 'productdetails_title_style',
      		'values'    => array(
      				array('value'=>'','label'=>'Please Select'),
      				array('value'=>'normal','label'=>'normal'),
      				array('value'=>'italic','label'=>'italic'),
      				array('value'=>'oblique','label'=>'oblique'),
      				array('value'=>'initial','label'=>'initial'),
      				array('value'=>'inherit','label'=>'inherit'),
      		),
      ));
      
      $generalfieldset->addField('productdetails_title_weight', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Title ‐ Weight, text'),
      		'name'      => 'productdetails_title_weight',
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
      
      $generalfieldset->addField('productdetails_sku_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('SKU ‐ Color, text:'),
      		'name'      => 'productdetails_sku_color',
      ));
      
      $generalfieldset->addField('productdetails_sku_font_size', 'text', array(
      		'label'     => Mage::helper('evolved')->__('SKU ‐ Size, text (pixels):'),
      		'name'      => 'productdetails_sku_font_size',
      ));
      
      $generalfieldset->addField('productdetails_sku_texttransform', 'select', array(
      		'label'     => Mage::helper('evolved')->__('SKU ‐ Transform, text'),
      		'name'      => 'productdetails_sku_texttransform',
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
      
      $generalfieldset->addField('productdetails_sku_style', 'select', array(
      		'label'     => Mage::helper('evolved')->__('SKU ‐ Style, text'),
      		'name'      => 'productdetails_sku_style',
      		'values'    => array(
      				array('value'=>'','label'=>'Please Select'),
      				array('value'=>'normal','label'=>'normal'),
      				array('value'=>'italic','label'=>'italic'),
      				array('value'=>'oblique','label'=>'oblique'),
      				array('value'=>'initial','label'=>'initial'),
      				array('value'=>'inherit','label'=>'inherit'),
      		),
      ));
      
      $generalfieldset->addField('productdetails_sku_weight', 'select', array(
      		'label'     => Mage::helper('evolved')->__('SKU ‐ Weight, text'),
      		'name'      => 'productdetails_sku_weight',
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
      
      $generalfieldset->addField('productdetails_social_turn', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Social Icons Enable:'),
      		'name'      => 'productdetails_social_turn',
      		'options'   => array(
      				'1' => Mage::helper('evolved')->__('Yes'),
      				'0' => Mage::helper('evolved')->__('No'),
      		),
      ));
       
      $generalfieldset->addField('productdetails_social_enable', 'multiselect', array(
      		'label'     => Mage::helper('evolved')->__('Social Icons List:'),
      		'name'      => 'productdetails_social_enable',
      		'values' => array(
      				'1' => array(
      						'value'=> array(array('value'=>'facebooklike' , 'label' => 'Like') , array('value'=>'facebookshare' , 'label' =>'Share') ),
      						'label' => 'Facebook'
      				),
      				'2' => array(
      						'value'=> array(array('value'=>'twittershare' , 'label' => 'Share')),
      						'label' => 'Twitter'
      				),
      				'3' => array(
      						'value'=> array(array('value'=>'pinterestshare' , 'label' => 'Share')),
      						'label' => 'Pinterest'
      				),
      				'4' => array(
      						'value'=> array(array('value'=>'googleplusshare' , 'label' => 'Share')),
      						'label' => 'Google Plus'
      				),
      				'5' => array(
      						'value'=> array(array('value'=>'emailtofriendshare' , 'label' => 'Mail')),
      						'label' => 'Email To Friend'
      				),
      				'6' => array(
      						'value'=> array(array('value'=>'instagramshare' , 'label' => 'Mail')),
      						'label' => 'Instagram'
      				),
      		),
      ));
      /************ End General Setting *********************/
      
      /************ Start Inquire Button *********************/
      /*$inquirebuttonfieldset = $form->addFieldset('evolved_form_productdetails_inquirebutton', array('legend'=>Mage::helper('evolved')->__('Inquire Button')));
      $inquirebuttonfieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
      $inquirebuttonfieldset->addType('select_fonts', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Font'));
      $inquirebuttonfieldset->addField('productdetails_Inquire_background_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Inquire background color:'),
      		'name'      => 'productdetails_Inquire_background_color',
      ));
      
      $inquirebuttonfieldset->addField('productdetails_Inquire_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Inquire color:'),
      		'name'      => 'productdetails_Inquire_color',
      ));
      
      $inquirebuttonfieldset->addField('productdetails_Inquire_font_size', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Inquire font size:'),
      		'name'      => 'productdetails_Inquire_font_size',
      ));*/
      /************ End Inquire Button *********************/
      
      /************ Start Recent Products*********************/
      $recentproductsfieldset = $form->addFieldset('evolved_form_productdetails_recentproducts', array('legend'=>Mage::helper('evolved')->__('Recent Products')));
      $recentproductsfieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
      $recentproductsfieldset->addType('select_fonts', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Font'));
      
      $recentproductsfieldset->addField('productdetails_link_background_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, background, link:'),
      		'name'      => 'productdetails_link_background_color',
      ));
      
      $recentproductsfieldset->addField('productdetails_linkhover_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, background, link, hover:'),
      		'name'      => 'productdetails_linkhover_background',
      ));
      
      $recentproductsfieldset->addField('productdetails_text_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, text:'),
      		'name'      => 'productdetails_text_color',
      ));

      $recentproductsfieldset->addField('productdetails_link_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, text, link:'),
      		'name'      => 'productdetails_link_color',
      ));
      
      $recentproductsfieldset->addField('productdetails_linkhover_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, text, link hover:'),
      		'name'      => 'productdetails_linkhover_color',
      ));
      
      $recentproductsfieldset->addField('productdetails_recently_product_title_texttransform', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Transform, text'),
      		'name'      => 'productdetails_recently_product_title_texttransform',
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
      
      $recentproductsfieldset->addField('productdetails_recently_product_title_style', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Style, text'),
      		'name'      => 'productdetails_recently_product_title_style',
      		'values'    => array(
      				array('value'=>'','label'=>'Please Select'),
      				array('value'=>'normal','label'=>'normal'),
      				array('value'=>'italic','label'=>'italic'),
      				array('value'=>'oblique','label'=>'oblique'),
      				array('value'=>'initial','label'=>'initial'),
      				array('value'=>'inherit','label'=>'inherit'),
      		),
      ));
      
      $recentproductsfieldset->addField('productdetails_recently_product_title_weight', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Weight, text'),
      		'name'      => 'productdetails_recently_product_title_weight',
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
      
      $recentproductsfieldset->addField('productdetails_recently_product_font_size', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Size, text:'),
      		'name'      => 'productdetails_recently_product_font_size',
      ));
      
      $recentproductsfieldset->addField('fonts_productpage', 'select_fonts', array(
      		'name' => 'fonts_productpage',
      		'label' => Mage::helper('evolved')->__('Font:'),
      		'values' => Mage::getModel('evolved/Font')->toOptionArray(),
      		'note'  => Mage::helper('evolved')->__('Enable google font to use this option'),
      ));
      
      /************ End Recent Products*********************/

      /* Price */
      /************ Start Price *********************/
      $pricefieldset = $form->addFieldset('evolved_form_productdetails_price', array('legend'=>Mage::helper('evolved')->__('Price')));
      $pricefieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
      $pricefieldset->addType('select_fonts', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Font'));

      $pricefieldset->addField('productdetails_price_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, Price:'),
      		'name'      => 'productdetails_price_color',
      ));
      
      $pricefieldset->addField('productdetails_oldprice_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, Old Price:'),
      		'name'      => 'productdetails_oldprice_color',
      ));
      
      $pricefieldset->addField('productdetails_price_textcolor', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, Text:'),
      		'name'      => 'productdetails_price_textcolor',
      		'note' => Mage::helper('evolved')->__('Text in price block ( As low, From, To )'),
      ));
      /************ End Price *********************/
      
      /************ Start Attribute *********************/
      $attributefieldset = $form->addFieldset('evolved_form_productdetails_attribute', array('legend'=>Mage::helper('evolved')->__('Attribute Table')));
      $attributefieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
      $attributefieldset->addType('select_fonts', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Font'));
      
      $attributefieldset->addField('productdetails_tab_enable', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Enable:'),
      		'name'      => 'productdetails_tab_enable',
      		'options'   => array(
      				'yes' => Mage::helper('evolved')->__('Yes'),
      				'no' => Mage::helper('evolved')->__('No'),
      		),
      ));
      
      $attributefieldset->addField('productdetails_tabcontent_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Table ‐ Color, background:'),
      		'name'      => 'productdetails_tabcontent_background',
      ));
      
      $attributefieldset->addField('productdetails_tabcontent_textcolor', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Table ‐ Color, text:'),
      		'name'      => 'productdetails_tabcontent_textcolor',
      ));
      
      $attributefieldset->addField('productdetails_tabcontent_border_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Table ‐ Color, border:'),
      		'name'      => 'productdetails_tabcontent_border_color',
      ));
      
      $attributefieldset->addField('productdetails_attribute_border_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Table ‐ Color, text, border:'),
      		'name'      => 'productdetails_attribute_border_color',
      ));
       
      $attributefieldset->addField('productdetails_attribute_fontsize', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Table ‐ Size, font (pixels):'),
      		'name'      => 'productdetails_attribute_fontsize',
      ));
      
      $attributefieldset->addField('productdetails_tabcontent_link_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, background, link:'),
      		'name'      => 'productdetails_tabcontent_link_background',
      ));
      
      $attributefieldset->addField('productdetails_tabcontent_linkhover_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, background, link, hover:'),
      		'name'      => 'productdetails_tabcontent_linkhover_background',
      ));
     
      $attributefieldset->addField('productdetails_tabcontent_link_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, text, link:'),
      		'name'      => 'productdetails_tabcontent_link_color',
      ));
      
      $attributefieldset->addField('productdetails_tabcontent_linkhover_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, text, link, hover:'),
      		'name'      => 'productdetails_tabcontent_linkhover_color',
      ));
      
      
      $attributefieldset->addField('productdetails_attribute_odd_background_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, background, odd rows:'),
      		'name'      => 'productdetails_attribute_odd_background_color',
      ));
      
      $attributefieldset->addField('productdetails_attribute_even_background_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, background, even rows:'),
      		'name'      => 'productdetails_attribute_even_background_color',
      ));
      
      $attributefieldset->addField('productdetails_attribute_odd_text_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, text, odd rows:'),
      		'name'      => 'productdetails_attribute_odd_text_color',
      ));
      
     $attributefieldset->addField('productdetails_attribute_even_text_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, text, even rows:'),
      		'name'      => 'productdetails_attribute_even_text_color',
      ));   

     $attributefieldset->addField('productdetails_attribute_table_heading_background', 'colorpicker', array(
     		'label'     => Mage::helper('evolved')->__('Attribute table heading background:'),
     		'name'      => 'productdetails_attribute_table_heading_background',
     ));
      
      /*  Tab Heading */
      /* Tab Content */
	  
      $attributetabletabsfieldset = $form->addFieldset('evolved_form_productdetails_attribute_table_tab', array('legend'=>Mage::helper('evolved')->__('Attribute Table Tabs')));
      $attributetabletabsfieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
      $attributetabletabsfieldset->addType('select_fonts', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Font'));
      
      $attributetabletabsfieldset->addField('productdetails_tabhead_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Tab ‐ Color, background:'),
      		'name'      => 'productdetails_tabhead_background',
      ));
      
      $attributetabletabsfieldset->addField('productdetails_tabhead_hover_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Tab ‐ Color, background, hover:'),
      		'name'      => 'productdetails_tabhead_hover_background',
      ));
      
      
      $attributetabletabsfieldset->addField('productdetails_tabhead_textcolor', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Tab ‐ Color, text:'),
      		'name'      => 'productdetails_tabhead_textcolor',
      ));
      
      $attributetabletabsfieldset->addField('productdetails_tabhead_texthover_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Tab ‐ Color, text, hover:'),
      		'name'      => 'productdetails_tabhead_texthover_color',
      ));
      
      $attributetabletabsfieldset->addField('productdetails_tabhead_border_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Tab ‐ Color, border:'),
      		'name'      => 'productdetails_tabhead_border_color',
      ));
      
      $attributetabletabsfieldset->addField('productdetails_tab_attribute_option', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Tab ‐ Attribute, option:'),
      		'name'      => 'productdetails_tab_attribute_option',
      		'options'   => array(
      				'inside' => Mage::helper('evolved')->__('Inside'),
      				'outside' => Mage::helper('evolved')->__('Outside'),
      		),
      ));
      
      $attributetabletabsfieldset->addField('productdetails_active_tabhead_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Active Tab ‐ Color, background:'),
      		'name'      => 'productdetails_active_tabhead_background',
      ));
      
      $attributetabletabsfieldset->addField('productdetails_active_tabhead_hover_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Active Tab ‐ Color, background, hover:'),
      		'name'      => 'productdetails_active_tabhead_hover_background',
      ));
      
      $attributetabletabsfieldset->addField('productdetails_active_tabhead_text_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Active Tab ‐ Color, text color:'),
      		'name'      => 'productdetails_active_tabhead_text_color',
      ));
      
      $attributetabletabsfieldset->addField('productdetails_active_tabhead_hover_text_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Active Tab ‐ Color, text, hover:'),
      		'name'      => 'productdetails_active_tabhead_hover_text_color',
      ));
      
      /************ End Attribute *********************/
      

      
      /* Review */
      /*
      $fieldset->addField('productdetails_rating_stars_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Rating stars background:'),
      		'name'      => 'productdetails_rating_stars_background',
      ));
      
      $fieldset->addField('productdetails_rating_form_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Rating form background:'),
      		'name'      => 'productdetails_rating_form_background',
      ));
      
      $fieldset->addField('productdetails_rating_form_text', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Rating form text:'),
      		'name'      => 'productdetails_rating_form_text',
      ));
      
      $fieldset->addField('productdetails_rating_form_inactive', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Rating form inactive element:'),
      		'name'      => 'productdetails_rating_form_inactive',
      ));
      
      $fieldset->addField('productdetails_rating_form_active', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Rating form active element:'),
      		'name'      => 'productdetails_rating_form_active',
      ));
      
      $fieldset->addField('productdetails_review_form_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Review form background:'),
      		'name'      => 'productdetails_review_form_background',
      ));
      
      $fieldset->addField('productdetails_review_form_text', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Review form text:'),
      		'name'      => 'productdetails_review_form_text',
      ));
		*/
      
      $fieldsetZoom = $form->addFieldset('evolved_form_productdetails_zoom', array('legend'=>Mage::helper('evolved')->__('Zoom Options')));
      
      $fieldsetZoom->addField('productdetails_zoom_disabled', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Enable Zoom:'),
      		'name'      => 'productdetails_zoom_disabled',
      		'options'   => array(
      				'true' => Mage::helper('evolved')->__('No'),
      				'false' => Mage::helper('evolved')->__('Yes'),
      		),
      ));
      
      $fieldsetZoom->addField('productdetails_mobile_zoom_disabled', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Enable Mobile Zoom:'),
      		'name'      => 'productdetails_mobile_zoom_disabled',
      		'options'   => array(
      				'true' => Mage::helper('evolved')->__('No'),
      				'false' => Mage::helper('evolved')->__('Yes'),
      		),
      ));
      
      $fieldsetZoom->addField('productdetails_zoom_expand_disabled', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Enable Expand:'),
      		'name'      => 'productdetails_zoom_expand_disabled',
      		'options'   => array(
      				'true' => Mage::helper('evolved')->__('No'),
      				'false' => Mage::helper('evolved')->__('Yes'),
      		),
      ));

      $fieldsetZoom->addField('productdetails_zoom_height', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Zoom height (pixels):'),
      		'name'      => 'productdetails_zoom_height',
      ));
      
      $fieldsetZoom->addField('productdetails_zoom_width', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Zoom width (pixels):'),
      		'name'      => 'productdetails_zoom_width',
      ));
 
      $fieldsetZoom->addField('productdetails_zoom_position', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Zoom position:'),
      		'name'      => 'productdetails_zoom_position',
      		'options'   => array(
      				'inner' => Mage::helper('evolved')->__('Inner'),
      				'left' => Mage::helper('evolved')->__('Left'),
      				'right' => Mage::helper('evolved')->__('Right'),
      				'top' => Mage::helper('evolved')->__('Top'),
      				'bottom' => Mage::helper('evolved')->__('Bottom'),
      		),
      ));
      
  /*    $fieldsetZoom->addField('productdetails_zoom_align', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Zoom align:'),
      		'name'      => 'productdetails_zoom_align',
      		'options'   => array(
      				'center' => Mage::helper('evolved')->__('Center'),
      				'left' => Mage::helper('evolved')->__('Left'),
      				'right' => Mage::helper('evolved')->__('Right'),
      				'top' => Mage::helper('evolved')->__('Top'),
      				'bottom' => Mage::helper('evolved')->__('Bottom'),
      		),
      ));
    */  
      Mage::getSingleton('core/session')->setBlockName('evolved_productdetails');
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