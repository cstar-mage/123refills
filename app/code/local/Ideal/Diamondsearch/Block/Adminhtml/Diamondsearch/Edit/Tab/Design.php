<?php

class Ideal_Diamondsearch_Block_Adminhtml_Diamondsearch_Edit_Tab_Design extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
	  
  	  $fieldset = $form->addFieldset('diamondsearch_form_general', array('legend'=>Mage::helper('diamondsearch')->__('General')));

		$fieldset->addField('include_jquery', 'select', array(
          'label'     => Mage::helper('diamondsearch')->__('Include jQuery'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'include_jquery',
          'value'  => Mage::getStoreConfig("diamondsearch/general_settings/include_jquery"),
          'values' => array('0' => 'No', '1'=>'Yes'),
        ));

		$fieldset->addField('ds_skin', 'select', array(
				'label'     => Mage::helper('diamondsearch')->__('Skin'),
				'class'     => 'required-entry',
				'required'  => true,
				'name'      => 'ds_skin',
				'value'  => Mage::getStoreConfig("diamondsearch/general_settings/ds_skin"),
				'values' => array('New' => 'New', 'Old'=>'Old'),
		));
		
		$fieldset->addField('view_mode', 'select', array(
				'label'     => Mage::helper('diamondsearch')->__('Default View Mode'),
				'class'     => 'required-entry',
				'required'  => true,
				'name'      => 'view_mode',
				'value'  => Mage::getStoreConfig("diamondsearch/general_settings/view_mode"),
				'values' => array('list_only' => 'List Only', 'grid_only' => 'Grid Only', 'both'=>'Both'),
		));
		
		$fieldset->addField('frontend_url', 'text', array(
          'label'     => Mage::helper('diamondsearch')->__('Front-end URL'),
          'required'  => true,
          'name'      => 'frontend_url',
          'value'  => Mage::getStoreConfig("diamondsearch/general_settings/frontend_url")
        ));
        
		$fieldset->addField('show_origin', 'select', array(
          'label'     => Mage::helper('diamondsearch')->__('Show Origin'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'show_origin',
          'value'  => Mage::getStoreConfig("diamondsearch/general_settings/show_origin"),
          'values' => array('0' => 'No', '1'=>'Yes'),
        ));
		
    	$fieldset->addField('show_rapper', 'select', array(
          'label'     => Mage::helper('diamondsearch')->__('Show Rap %'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'show_rapper',
          'value'  => Mage::getStoreConfig("diamondsearch/general_settings/show_rapper"),
          'values' => array('0' => 'No', '1'=>'Yes'),
        ));
    	
		$fieldset->addField('header_text', 'textarea', array(
          'label'     => Mage::helper('diamondsearch')->__('Header Text'),
          'name'      => 'header_text',
          'value'  	=> Mage::getStoreConfig("diamondsearch/general_settings/header_text"),
          'note' => 'will be shown at top of search'
        ));

		$fieldset->addField('compare_request', 'select', array(
				'label'     => Mage::helper('diamondsearch')->__('Use Compare as Request'),
				'class'     => 'required-entry',
				'required'  => true,
				'name'      => 'compare_request',
				'value'  => Mage::getStoreConfig("diamondsearch/general_settings/compare_request"),
				'values' => array('0' => 'No', '1'=>'Yes'),
		));
		
		$fieldset->addField('showblock_detail', 'select', array(
				'label'     => Mage::helper('diamondsearch')->__('Show Details Block'),
				'class'     => 'required-entry',
				'required'  => true,
				'name'      => 'showblock_detail',
				'value'  => Mage::getStoreConfig("diamondsearch/general_settings/showblock_detail"),
				'values' => array('0' => 'No', '1'=>'Yes'),
		));
		
		$fieldset->addField('showcolumn_rapdiscount', 'select', array(
          'label'     => Mage::helper('diamondsearch')->__('Show Column RAP%'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'showcolumn_rapdiscount',
          'value'  => Mage::getStoreConfig("diamondsearch/general_settings/showcolumn_rapdiscount"),
          'values' => array('0' => 'No', '1'=>'Yes'),
        ));
		$fieldset->addField('showcolumn_availability', 'select', array(
          'label'     => Mage::helper('diamondsearch')->__('Show Column Availability'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'showcolumn_availability',
          'value'  => Mage::getStoreConfig("diamondsearch/general_settings/showcolumn_availability"),
          'values' => array('0' => 'No', '1'=>'Yes'),
        ));
		$fieldset->addField('showcolumn_dimensions', 'select', array(
          'label'     => Mage::helper('diamondsearch')->__('Show Column Dimensions'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'showcolumn_dimensions',
          'value'  => Mage::getStoreConfig("diamondsearch/general_settings/showcolumn_dimensions"),
          'values' => array('0' => 'No', '1'=>'Yes'),
        ));
		$fieldset->addField('showcolumn_depth', 'select', array(
          'label'     => Mage::helper('diamondsearch')->__('Show Column Depth'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'showcolumn_depth',
          'value'  => Mage::getStoreConfig("diamondsearch/general_settings/showcolumn_depth"),
          'values' => array('0' => 'No', '1'=>'Yes'),
        ));
		$fieldset->addField('showcolumn_tabl', 'select', array(
          'label'     => Mage::helper('diamondsearch')->__('Show Column Table'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'showcolumn_tabl',
          'value'  => Mage::getStoreConfig("diamondsearch/general_settings/showcolumn_tabl"),
          'values' => array('0' => 'No', '1'=>'Yes'),
        ));
        $fieldset->addField('disable_lab', 'select', array(
          'label'     => Mage::helper('diamondsearch')->__('Disable Showing Lab'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'disable_lab',
          'value'  => Mage::getStoreConfig("diamondsearch/general_settings/disable_lab"),
          'values' => array('0' => 'No', '1'=>'Yes'),
        ));
		$fieldset->addField('inhouse_vendor', 'text', array(
          'label'     => Mage::helper('diamondsearch')->__('In House Vendor'),
          'required'  => false,
          'name'      => 'inhouse_vendor',
          'value'  => Mage::getStoreConfig("diamondsearch/general_settings/inhouse_vendor")
        ));
		$fieldset->addField('showcolumn_inhouse', 'select', array(
          'label'     => Mage::helper('diamondsearch')->__('Show Column InHouse'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'showcolumn_inhouse',
          'value'  => Mage::getStoreConfig("diamondsearch/general_settings/showcolumn_inhouse"),
          'values' => array('0' => 'No', '1'=>'Yes'),
        ));
        
        $fieldset->addField('showcolumn_inhouse_tab', 'select', array(
          'label'     => Mage::helper('diamondsearch')->__('Show InHouse On Advance Search Tab'),
          'name'      => 'showcolumn_inhouse_tab',
          'value'  => Mage::getStoreConfig("diamondsearch/general_settings/showcolumn_inhouse_tab"),
          'values' => array('0' => 'No', '1'=>'Yes'),
        ));
        
         $fieldset->addField('inhousetextcolumn', 'text', array(
          'label'     => Mage::helper('diamondsearch')->__('InHouse Title For Column'),
          'required'  => false,
          'name'      => 'inhousetextcolumn',
          'value'  => Mage::getStoreConfig("diamondsearch/general_settings/inhousetextcolumn"),
           
        )); 
        
        $fieldset->addField('show_only_inhouse', 'select', array(
          'label'     => Mage::helper('diamondsearch')->__('Show Only InHouse Diamonds'),
          'name'      => 'show_only_inhouse',
          'value'  => Mage::getStoreConfig("diamondsearch/general_settings/show_only_inhouse"),
          'values' => array('0' => 'No', '1'=>'Yes'),
        ));
		
		$fieldset->addField('inhouse_text_ifno', 'text', array(
          'label'     => Mage::helper('diamondsearch')->__('InHouse Text For No'),
          'required'  => false,
          'name'      => 'inhousetext',
          'value'  => Mage::getStoreConfig("diamondsearch/general_settings/inhousetext"),
		  'note' => 'if diamond is not InHouse'
        ));
        
         $fieldset->addField('inhousetextyes', 'text', array(
          'label'     => Mage::helper('diamondsearch')->__('InHouse Text For Yes'),
          'required'  => false,
          'name'      => 'inhousetextyes',
          'value'  => Mage::getStoreConfig("diamondsearch/general_settings/inhousetextyes"),
           
        ));
        
		
		$fieldset->addField('sample_avilability', 'select', array(
				'label'     => Mage::helper('diamondsearch')->__('Display Actual Photos When Available'),
				'name'      => 'sample_avilability',
				'value'  => Mage::getStoreConfig("diamondsearch/general_settings/sample_avilability"),
				'values' => array('0' => 'No', '1'=>'Yes'),
				'note' => 'On select Yes Actual Photos will display'
		));
		
		$fieldset->addField('deafault_filter_by', 'select', array(
				'label'     => Mage::helper('diamondsearch')->__('Default Filter By'),
				'name'      => 'deafault_filter_by',
				'value'  => Mage::getStoreConfig("diamondsearch/general_settings/deafault_filter_by"),
				'values' => array('carat'=>'Carat','totalprice' => 'Price', 'certificate'=>'Report', 'dimensions'=>'Dimensions','is_fancy'=>'Fancy Color','inhouse'=>'In-House'),
		));
		
		$fieldset->addField('deafault_sort_by', 'select', array(
				'label'     => Mage::helper('diamondsearch')->__('Default Sort By'),
				'name'      => 'deafault_sort_by',
				'value'  => Mage::getStoreConfig("diamondsearch/general_settings/deafault_sort_by"),
				'values' => array('asc'=>'ASC','desc' => 'DESC'),
		));

		$fieldset->addField('spacial_diamond_avilability', 'select', array(
				'label'     => Mage::helper('diamondsearch')->__('Display Special Diamonds'),
				'name'      => 'spacial_diamond_avilability',
				'value'  => Mage::getStoreConfig("diamondsearch/general_settings/spacial_diamond_avilability"),
				'values' => array('0' => 'No', '1'=>'Yes'),
				'note' => 'On select Yes Special Diamonds Wil display'
		));
		
		$fieldset->addField('disable_advanced_search', 'select', array(
				'label'     => Mage::helper('diamondsearch')->__('Disable Advanced Search'),
				'name'      => 'disable_advanced_search',
				'value'  => Mage::getStoreConfig("diamondsearch/general_settings/disable_advanced_search"),
				'values' => array('0' => 'No', '1'=>'Yes'),
				'note' => 'This will hide Advanced Search block'
		));
		
		$fieldset->addField('enable_optionslider_color_clarity', 'select', array(
				'label'     => Mage::helper('diamondsearch')->__('Enable Options Slider for Color and Clarity'),
				'name'      => 'enable_optionslider_color_clarity',
				'value'  => Mage::getStoreConfig("diamondsearch/general_settings/enable_optionslider_color_clarity"),
				'values' => array('0' => 'No', '1'=>'Yes')
		)); 
		
		$fieldset->addField('custom_diamond_certificate', 'select', array(
				'label'     => Mage::helper('diamondsearch')->__('Enable Custom Advanced Search Certificate'),
				'name'      => 'custom_diamond_certificate',
				'value'  => Mage::getStoreConfig("diamondsearch/general_settings/custom_diamond_certificate"),
				'values' => array('0' => 'No', '1'=>'Yes')
		)); 
		
		
		$fieldset->addField('custom_diamond_inhouse', 'select', array(
				'label'     => Mage::helper('diamondsearch')->__('Enable Custom Advanced Search In-House'),
				'name'      => 'custom_diamond_inhouse',
				'value'  => Mage::getStoreConfig("diamondsearch/general_settings/custom_diamond_inhouse"),
				'values' => array('0' => 'No', '1'=>'Yes')
		));
		
		
		$fieldset->addField('custom_diamond_image', 'select', array(
				'label'     => Mage::helper('diamondsearch')->__('Enable Custom Advanced Search Image'),
				'name'      => 'custom_diamond_image',
				'value'  => Mage::getStoreConfig("diamondsearch/general_settings/custom_diamond_image"),
				'values' => array('0' => 'No', '1'=>'Yes')
		)); 
		
		$fieldset->addField('diamondscarat_min', 'text', array(
          'label'     => Mage::helper('diamondsearch')->__('Carat Min'),
          'required'  => false,
          'name'      => 'diamondscarat_min',
          'value'  => Mage::getStoreConfig("diamondsearch/general_settings/diamondscarat_min"),
           
        ));   
        
        $fieldset->addField('diamondscarat_max', 'text', array(
          'label'     => Mage::helper('diamondsearch')->__('Carat Max'),
          'required'  => false,
          'name'      => 'diamondscarat_max',
          'value'  => Mage::getStoreConfig("diamondsearch/general_settings/diamondscarat_max"),
           
        ));
        $fieldset->addField('diamondscookie_expirytime', 'text', array(
          'label'     => Mage::helper('diamondsearch')->__('Session Expiry Time'),
          'required'  => true,
          'name'      => 'diamondscookie_expirytime',
          'value'  => Mage::getStoreConfig("diamondsearch/general_settings/diamondscookie_expirytime"),
          'note' => 'in Minutes'
        ));
        $fieldset->addField('diamonds_show_bankwireprice', 'select', array(
				'label'     => Mage::helper('diamondsearch')->__('Show Bankwire Price'),
				'name'      => 'diamonds_show_bankwireprice',
				'value'  => Mage::getStoreConfig("diamondsearch/general_settings/diamonds_show_bankwireprice"),
				'values' => array('0' => 'No', '1'=>'Yes'),
				'note' => 'in Details page'
		)); 
		
		$fieldset->addField('show_measurement_image', 'select', array(
				'label'     => Mage::helper('diamondsearch')->__('Show Measurement Image'),
				'name'      => 'show_measurement_image',
				'value'  => Mage::getStoreConfig("diamondsearch/general_settings/show_measurement_image"),
				'values' => array('0' => 'No', '1'=>'Yes'),
				'note' => 'in Details page'
		)); 
       
        $fieldset->addField('diamondsview_addtocart_disabled_shapes', 'text', array(
          'label'     => Mage::helper('diamondsearch')->__('Disable Add To Cart for Shapes'),
          'required'  => false,
          'name'      => 'diamondsview_addtocart_disabled_shapes',
          'value'  => Mage::getStoreConfig("diamondsearch/general_settings/diamondsview_addtocart_disabled_shapes"),
          'note' => 'Comma separated. In Details page'
        ));
        
        $fieldset->addField('diamondsview_button_text', 'text', array(
          'label'     => Mage::helper('diamondsearch')->__('View Diamond button Text'),
          'required'  => false,
          'name'      => 'diamondsview_button_text',
          'value'  => Mage::getStoreConfig("diamondsearch/general_settings/diamondsview_button_text"),
        ));
        
        $fieldset->addField('diamondsview_carat_title', 'textarea', array(
			'label'     => Mage::helper('diamondsearch')->__('Carat title'),
			'name'      => 'diamondsview_carat_title',
			'style'		=> 'height:100px',
			'value'  	=> Mage::getStoreConfig("diamondsearch/general_settings/diamondsview_carat_title"),
			'note' => 'Can use HTML here'
		));
		
		$fieldset->addField('use_as_gemsearch', 'select', array(
				'label'     => Mage::helper('diamondsearch')->__('Use as Gem-Search'),
				'name'      => 'use_as_gemsearch',
				'value'  => Mage::getStoreConfig("diamondsearch/general_settings/use_as_gemsearch"),
				'values' => array('0' => 'No', '1'=>'Yes'),
				'note' => 'this will change Labels from Diamond to Gem'
		)); 
		
		/*
		$fieldset->addField('atribute_position_avilability', 'select', array(
				'label'     => Mage::helper('diamondsearch')->__('Display As Atribute Position'),
				'name'      => 'atribute_position_avilability',
				'value'  => Mage::getStoreConfig("diamondsearch/general_settings/atribute_position_avilability"),
				'values' => array('0' => 'No', '1'=>'Yes'),
				'note' => 'On select yes Atribute will display as Atribute Position'
		)); */ 
		

		$fieldset->addField('diamond_description', 'textarea', array(
				'label'     => Mage::helper('diamondsearch')->__('Description Text'),
				'name'      => 'diamond_description',
				'style'		=> 'height:100px',
				'value'  	=> Mage::getStoreConfig("diamondsearch/general_settings/diamond_description"),
				'note' => 'For details page. Use these variables: {{carat}}, {{cut}}, {{clarity}}, {{shape}}, {{certificate}}'
		));
		$fieldset->addField('diamondinquiry_customform', 'textarea', array(
				'label'     => Mage::helper('diamondsearch')->__('Custom Inquiry Form Script'),
				'name'      => 'diamondinquiry_customform',
				'style'		=> 'height:100px',
				'value'  	=> Mage::getStoreConfig("diamondsearch/general_settings/diamondinquiry_customform"),
		));
	  
		/*
		$fieldset->addField('certificate_sample', 'image', array(
				'label' => Mage::helper('diamondsearch')->__('Sample Certificate Image'),
				'required' => false,
				'name' => 'certificate_sample',
				'value'  	=> Mage::getStoreConfig("diamondsearch/general_settings/certificate_sample"),
		));*/
		
      $fieldset = $form->addFieldset('diamondsearch_form_design', array('legend'=>Mage::helper('diamondsearch')->__('Item information')));
     
	  $fieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Diamondsearch_Block_Adminhtml_Diamondsearch_Edit_Renderer_Color'));
      
	  $fieldset->addField('shape_color', 'colorpicker', array(
	  		'label'     => Mage::helper('diamondsearch')->__('Shape Color'),
	  		'name'      => 'shape_color',
	  		'value'	  => Mage::getStoreConfig("diamondsearch/design_settings/shape_color")
	  ));
	  
	  $fieldset->addField('shape_bgcolor', 'colorpicker', array(
	  		'label'     => Mage::helper('diamondsearch')->__('Shape Bg. Color'),
	  		'name'      => 'shape_bgcolor',
	  		'value'	  => Mage::getStoreConfig("diamondsearch/design_settings/shape_bgcolor")
	  ));
	  
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

      $fieldset->addField('colorswitch_button_textcolor', 'colorpicker', array(
      		'label'     => Mage::helper('diamondsearch')->__('Color Switcher Button Text Color'),
      		'name'      => 'colorswitch_button_textcolor',
      		'value'	  => Mage::getStoreConfig("diamondsearch/design_settings/colorswitch_button_textcolor")
      ));
      
      $fieldset->addField('colorswitch_button_color', 'colorpicker', array(
      		'label'     => Mage::helper('diamondsearch')->__('Color Switcher Button Color'),
      		'name'      => 'colorswitch_button_color',
      		'value'	  => Mage::getStoreConfig("diamondsearch/design_settings/colorswitch_button_color")
      ));
      
      $fieldset->addField('colorswitch_button_hover_color', 'colorpicker', array(
      		'label'     => Mage::helper('diamondsearch')->__('Color Switcher Button Hover Color'),
      		'name'      => 'colorswitch_button_hover_color',
      		'value'	  => Mage::getStoreConfig("diamondsearch/design_settings/colorswitch_button_hover_color")
      ));
      
	  $fieldset->addField('advanced_search_textcolor', 'colorpicker', array(
          'label'     => Mage::helper('diamondsearch')->__('Advanced Search Text Color'),
          'name'      => 'advanced_search_textcolor',
		  'value'	  => Mage::getStoreConfig("diamondsearch/design_settings/advanced_search_textcolor")
      ));
      
      $fieldset->addField('advanced_search_bgcolor', 'colorpicker', array(
          'label'     => Mage::helper('diamondsearch')->__('Advanced Search Bg. Color'),
          'name'      => 'advanced_search_bgcolor',
		  'value'	  => Mage::getStoreConfig("diamondsearch/design_settings/advanced_search_bgcolor")
      ));

			$fieldset->addField('tabs_textcolor', 'colorpicker', array(
          'label'     => Mage::helper('diamondsearch')->__('Tabs Text Color'),
          'name'      => 'tabs_textcolor',
		  'value'	  => Mage::getStoreConfig("diamondsearch/design_settings/tabs_textcolor")
      ));
      
      $fieldset->addField('tabs_bgcolor', 'colorpicker', array(
          'label'     => Mage::helper('diamondsearch')->__('Tabs Bg. Color'),
          'name'      => 'tabs_bgcolor',
		  'value'	  => Mage::getStoreConfig("diamondsearch/design_settings/tabs_bgcolor")
      ));

	$fieldset->addField('table_header_textcolor', 'colorpicker', array(
          'label'     => Mage::helper('diamondsearch')->__('Table Header Text Color'),
          'name'      => 'table_header_textcolor',
		  'value'	  => Mage::getStoreConfig("diamondsearch/design_settings/table_header_textcolor")
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
      
      $fieldset->addField('table_sort_arrow_style', 'select', array(
      		'label'     => Mage::helper('diamondsearch')->__('Table Sort Arrow Style'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'table_sort_arrow_style',
      		'value'  => Mage::getStoreConfig("diamondsearch/design_settings/table_sort_arrow_style"),
      		'values' => array(
      				'1' => array(
      						'value'=> 'dark',
      						'label' => 'Dark'
      				),
      				'2' => array(
      						'value'=> 'light',
      						'label' => 'Light'
      				),
      		)
      ));
      
	  $fieldset->addField('diamond_font_color', 'colorpicker', array(
		'label'     => Mage::helper('diamondsearch')->__('Grid Diamond Font Color'),
		'name'      => 'diamond_font_color',
		'value'	  => Mage::getStoreConfig("diamondsearch/design_settings/diamond_font_color")
	  )); 

		$fieldset->addField('view_button_textcolor', 'colorpicker', array(
          'label'     => Mage::helper('diamondsearch')->__('View Button Text Color'),
          'name'      => 'view_button_textcolor',
		  'value'	  => Mage::getStoreConfig("diamondsearch/design_settings/view_button_textcolor")
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
	$fieldset->addField('viewpage_table_textcolor', 'colorpicker', array(
      		'label'     => Mage::helper('diamondsearch')->__('Table Text Color'),
      		'name'      => 'viewpage_table_textcolor',
      		'note'		=> 'in details page',
      		'value'	  => Mage::getStoreConfig("diamondsearch/design_settings/viewpage_table_textcolor")
      ));
      $fieldset->addField('viewpage_table_bgcolor', 'colorpicker', array(
      		'label'     => Mage::helper('diamondsearch')->__('Table Bg. Color'),
      		'name'      => 'viewpage_table_bgcolor',
      		'note'		=> 'in details page',
      		'value'	  => Mage::getStoreConfig("diamondsearch/design_settings/viewpage_table_bgcolor")
      ));
      $fieldset->addField('viewpage_button_textcolor', 'colorpicker', array(
      		'label'     => Mage::helper('diamondsearch')->__('Button Text Color'),
      		'name'      => 'viewpage_button_textcolor',
      		'note'		=> 'in details page',
      		'value'	  => Mage::getStoreConfig("diamondsearch/design_settings/viewpage_button_textcolor")
      ));
      $fieldset->addField('viewpage_button_bgcolor', 'colorpicker', array(
      		'label'     => Mage::helper('diamondsearch')->__('Button Bg. Color'),
      		'name'      => 'viewpage_button_bgcolor',
      		'note'		=> 'in details page',
      		'value'	  => Mage::getStoreConfig("diamondsearch/design_settings/viewpage_button_bgcolor")
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
