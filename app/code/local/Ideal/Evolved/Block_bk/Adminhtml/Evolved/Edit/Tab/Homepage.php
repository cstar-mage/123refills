<!-- <script>
function selectpageelementstylewidth(str,element)
{
	if(str=="full-width")
	{
		//alert(str + "  " + element);
	}
	else if(str=="1240-pixels")
	{
		//alert(str + "  " + element);
	}
	else if(str=="1050-pixels")
	{
		//alert(str + "  " + element);		
	}
}
</script>  -->
<?php

class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Tab_Homepage extends Mage_Adminhtml_Block_Widget_Form
{
	
	protected function _prepareLayout() {
	    parent::_prepareLayout();
	    if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
	        $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
	        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
	    }
	}
	
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
      
      /////-------------------------------------Page Element 1----------------------------------------------////
      $fieldset_page_element_one = $form->addFieldset('evolved_homepage_element_one', array('legend'=>Mage::helper('evolved')->__('Page Element 1')));
      $fieldset_page_element_one->addField('homepage_element_one_style_enable', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Page Element Style:'),
      		'name'      => 'homepage_element_one_style_enable',
      		'options'   => array(
      				'1' => Mage::helper('evolved')->__('Enable'),
      				'0' => Mage::helper('evolved')->__('Disable'),
      		),
      ));
      
      $fieldset_page_element_one->addField('homepage_element_1_sort_order', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Sort Order:'),
      		'name'      => 'homepage_element_1_sort_order',
      		'style' => 'width:50px'
      ));

      
      $fieldset_page_element_one->addField('homepage_element_one_style', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Page Element Style:'),
      		'name'      => 'homepage_element_one_style',
      		'options'   => array(
      				'' => Mage::helper('evolved')->__('Select Page Element Style'),
					'homepage_element_1_1920_by_480_banner' => Mage::helper('evolved')->__('Single Banner Narrow - full screen'),
					'homepage_element_1_1920_by_800_banner' => Mage::helper('evolved')->__('Single Banner Tall - full screen'),
					'homepage_element_1_30_70_boxes_full_width' => Mage::helper('evolved')->__('Three Boxes Featured Right - full screen'),
					'homepage_element_1_70_30_boxes_full_width' => Mage::helper('evolved')->__('Three Boxes Featured Left - full screen'),
					'homepage_element_1_33_percentage_640_by_400_three_boxes_full_width' => Mage::helper('evolved')->__('Three Boxes - full screen'),
					'homepage_element_1_25_percentage_480_by_400_four_boxes_full_width' => Mage::helper('evolved')->__('Four Boxes - full screen'),
					'homepage_element_1_1050_by_170_banner' => Mage::helper('evolved')->__('Promo Single Banner - Centered'),
					'homepage_element_1_1050_by_170_banner' => Mage::helper('evolved')->__('Promo Single Banner - Centered'),
					'homepage_element_1_50_percentage_522_by_170_two_boxes_width' => Mage::helper('evolved')->__('Two Boxes Narrow - Centered'),
					'homepage_element_1_50_percentage_522_by_346_two_boxes_width' => Mage::helper('evolved')->__('Two Boxes Tall - Centered'),
					'homepage_element_1_33_percentage_346_by_170_three_boxes_width' => Mage::helper('evolved')->__('Three Boxes Narrow - Centered'),
					'homepage_element_1_33_percentage_346_by_346_three_boxes_width' => Mage::helper('evolved')->__('Three Boxes Square - Centered'),
					'homepage_element_1_33_percentage_left_50_percentage_right_boxes_right_updown_width' => Mage::helper('evolved')->__('Three Boxes Featured Left - Centered'),
					'homepage_element_1_25_percentage_258_by_170_four_boxes_width' => Mage::helper('evolved')->__('Four Boxes Accross - Centered'),
					'homepage_element_1_33_percentage_346_by_346_three_boxes_middle_updown_width' => Mage::helper('evolved')->__('Four Boxes Featured Sides - Centered'),
					'homepage_element_1_33_percentage_346_by_346_three_boxes_leftright_updown_width' => Mage::helper('evolved')->__('Four Boxes Featured Middle - Centered'),
      				//'homepage_element_1_show_newarrival_product' => Mage::helper('evolved')->__('New Arrival Product'),
      				//'homepage_element_1_show_special_product' => Mage::helper('evolved')->__('Special Products'),
      				//'homepage_element_1_show_bestsellers_product' => Mage::helper('evolved')->__('Best Sellers Product'),
      				//'homepage_element_1_show_mostviewed_product' => Mage::helper('evolved')->__('Most Viewed Product'),
      				'homepage_element_1_show_featured_product' => Mage::helper('evolved')->__('Featured Product'),
      				'homepage_element_1_show_brand_manager' => Mage::helper('evolved')->__('Brand Manager'),
      				'homepage_element_1_show_slideshow_banner' => Mage::helper('evolved')->__('Slide Show Banner'),
      				'homepage_element_1_show_diamondrow' => Mage::helper('evolved')->__('Loose Diamonds'),
      				'homepage_element_1_show_textrow' => Mage::helper('evolved')->__('Text Row'),
       				'homepage_element_1_show_image_with_feature_slider' => Mage::helper('evolved')->__('Image with Feature Slider'),
      				
      				/*
      				'homepage_element_1_1920_by_480_banner' => Mage::helper('evolved')->__('Banner Small'),
					'homepage_element_1_1920_by_800_banner' => Mage::helper('evolved')->__('Banner Large'),
					'homepage_element_1_30_70_boxes_full_width' => Mage::helper('evolved')->__('3-box, Featured Right'),
					'homepage_element_1_70_30_boxes_full_width' => Mage::helper('evolved')->__('3-box, Featured Left'),
					'homepage_element_1_33_percentage_640_by_400_three_boxes_full_width' => Mage::helper('evolved')->__('3-box'),
					'homepage_element_1_25_percentage_480_by_400_four_boxes_full_width' => Mage::helper('evolved')->__('4-box'),
					'homepage_element_1_1050_by_170_banner' => Mage::helper('evolved')->__('Promo Banner'),
					'homepage_element_1_50_percentage_522_by_170_two_boxes_width' => Mage::helper('evolved')->__('2-box Small'),
					'homepage_element_1_50_percentage_522_by_346_two_boxes_width' => Mage::helper('evolved')->__('2-box Large'),
					'homepage_element_1_33_percentage_346_by_170_three_boxes_width' => Mage::helper('evolved')->__('3-box Small'),
					'homepage_element_1_33_percentage_346_by_346_three_boxes_width' => Mage::helper('evolved')->__('3-box Large'),
					'homepage_element_1_33_percentage_left_50_percentage_right_boxes_right_updown_width' => Mage::helper('evolved')->__('3-box, Featured Left'),
					'homepage_element_1_25_percentage_258_by_170_four_boxes_width' => Mage::helper('evolved')->__('4-box'),
					'homepage_element_1_33_percentage_346_by_346_three_boxes_middle_updown_width' => Mage::helper('evolved')->__('4-box, Featured Sides'),
					'homepage_element_1_33_percentage_346_by_346_three_boxes_leftright_updown_width' => Mage::helper('evolved')->__('4-box, Featured Middle'),
      				//'homepage_element_1_show_newarrival_product' => Mage::helper('evolved')->__('New Arrival Product'),
      				//'homepage_element_1_show_special_product' => Mage::helper('evolved')->__('Special Products'),
      				//'homepage_element_1_show_bestsellers_product' => Mage::helper('evolved')->__('Best Sellers Product'),
      				//'homepage_element_1_show_mostviewed_product' => Mage::helper('evolved')->__('Most Viewed Product'),
      				'homepage_element_1_show_featured_product' => Mage::helper('evolved')->__('Featured Products'),
      				'homepage_element_1_show_brand_manager' => Mage::helper('evolved')->__('Brand Slider'),
      				'homepage_element_1_show_slideshow_banner' => Mage::helper('evolved')->__('Slide Show Banner'),
      				'homepage_element_1_show_diamondrow' => Mage::helper('evolved')->__('Loose Diamonds'),
      				'homepage_element_1_show_textrow' => Mage::helper('evolved')->__('Text Row'),
       				'homepage_element_1_show_image_with_feature_slider' => Mage::helper('evolved')->__('Image with Feature Slider'),
      				 */
      		),
      		'onchange' => "selectpageelementstyleone(this.value)",
      ))
      ->setAfterElementHtml("<div class='tooltip_element_main'></div>
      		<script type=\"text/javascript\">
				url = jQuery(location).attr('protocol') + '//' + jQuery(location).attr('hostname');
      			function selectpageelementstyleone(style)
      			{
      				//alert(style);
      				jQuery('#evolved_homepage_element_one .allpageelementmaintable').css('display','none');
      		      	jQuery('#evolved_homepage_element_one #' + style).css('display','block');
      			}
      		</script>
      	");
      
      $fieldset_page_element_one->addField('homepage_element_one_style_margintop', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Margin Top In Pixels:'),
      		'name'      => 'homepage_element_one_style_margintop',
      ));
	  
	     $fieldset_page_element_one->addField('homepage_element_one_width_after', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Remove Element After Width (px):'),
      		'name'      => 'homepage_element_one_width_after',
      		'style' => 'width:50px'
      ));
	   /*$fieldset_page_element_one->addField('homepage_element_one_width_after_enable', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Page Element Style Enable After Above Width:'),
      		'name'      => 'homepage_element_one_width_after_enable',
      		'options'   => array(
      				'1' => Mage::helper('evolved')->__('Yes'),
      				'0' => Mage::helper('evolved')->__('No'),
      		),
      ));*/


      $fieldset_page_element_one->addType('elementone', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Pageelementstyle_Elementone'));
      $fieldset_page_element_one->addField('elementone', 'elementone', array(
      		'name'      => 'elementone',
      ));
	  
	
	  
	        $fieldset_page_element_two = $form->addFieldset('evolved_homepage_element_two', array('legend'=>Mage::helper('evolved')->__('Page Element 2')));
	        $fieldset_page_element_two->addField('homepage_element_two_style_enable', 'select', array(
	        		'label'     => Mage::helper('evolved')->__('Page Element Style:'),
	        		'name'      => 'homepage_element_two_style_enable',
	        		'options'   => array(
	        				'1' => Mage::helper('evolved')->__('Enable'),
	        				'0' => Mage::helper('evolved')->__('Disable'),
	        		),
	        ));
	        
	        $fieldset_page_element_two->addField('homepage_element_2_sort_order', 'text', array(
	        		'label'     => Mage::helper('evolved')->__('Sort Order:'),
	        		'name'      => 'homepage_element_2_sort_order',
	        		'style' => 'width:50px'
	        ));

      $fieldset_page_element_two->addField('homepage_element_two_style', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Page Element Style:'),
      		'name'      => 'homepage_element_two_style',
      		'options'   => array(
      				'' => Mage::helper('evolved')->__('Select Page Element Style'),
					'homepage_element_2_1920_by_480_banner' => Mage::helper('evolved')->__('Single Banner Narrow - full screen'),
					'homepage_element_2_1920_by_800_banner' => Mage::helper('evolved')->__('Single Banner Tall - full screen'),
					'homepage_element_2_30_70_boxes_full_width' => Mage::helper('evolved')->__('Three Boxes Featured Right - full screen'),
					'homepage_element_2_70_30_boxes_full_width' => Mage::helper('evolved')->__('Three Boxes Featured Left - full screen'),
					'homepage_element_2_33_percentage_640_by_400_three_boxes_full_width' => Mage::helper('evolved')->__('Three Boxes - full screen'),
					'homepage_element_2_25_percentage_480_by_400_four_boxes_full_width' => Mage::helper('evolved')->__('Four Boxes - full screen'),
					'homepage_element_2_1050_by_170_banner' => Mage::helper('evolved')->__('Promo Single Banner - Centered'),
					'homepage_element_2_1050_by_170_banner' => Mage::helper('evolved')->__('Promo Single Banner - Centered'),
					'homepage_element_2_50_percentage_522_by_170_two_boxes_width' => Mage::helper('evolved')->__('Two Boxes Narrow - Centered'),
					'homepage_element_2_50_percentage_522_by_346_two_boxes_width' => Mage::helper('evolved')->__('Two Boxes Tall - Centered'),
					'homepage_element_2_33_percentage_346_by_170_three_boxes_width' => Mage::helper('evolved')->__('Three Boxes Narrow - Centered'),
					'homepage_element_2_33_percentage_346_by_346_three_boxes_width' => Mage::helper('evolved')->__('Three Boxes Square - Centered'),
					'homepage_element_2_33_percentage_left_50_percentage_right_boxes_right_updown_width' => Mage::helper('evolved')->__('Three Boxes Featured Left - Centered'),
					'homepage_element_2_25_percentage_258_by_170_four_boxes_width' => Mage::helper('evolved')->__('Four Boxes Accross - Centered'),
					'homepage_element_2_33_percentage_346_by_346_three_boxes_middle_updown_width' => Mage::helper('evolved')->__('Four Boxes Featured Sides - Centered'),
					'homepage_element_2_33_percentage_346_by_346_three_boxes_leftright_updown_width' => Mage::helper('evolved')->__('Four Boxes Featured Middle - Centered'),
      				//'homepage_element_2_show_newarrival_product' => Mage::helper('evolved')->__('New Arrival Product'),
      				//'homepage_element_2_show_special_product' => Mage::helper('evolved')->__('Special Products'),
      				//'homepage_element_2_show_bestsellers_product' => Mage::helper('evolved')->__('Best Sellers Product'),
      				//'homepage_element_2_show_mostviewed_product' => Mage::helper('evolved')->__('Most Viewed Product'),
      				'homepage_element_2_show_featured_product' => Mage::helper('evolved')->__('Featured Product'),
      				'homepage_element_2_show_brand_manager' => Mage::helper('evolved')->__('Brand Manager'),
      				'homepage_element_2_show_slideshow_banner' => Mage::helper('evolved')->__('Slide Show Banner'),
      				'homepage_element_2_show_diamondrow' => Mage::helper('evolved')->__('Loose Diamonds'),
      				'homepage_element_2_show_textrow' => Mage::helper('evolved')->__('Text Row'),
      				'homepage_element_2_show_image_with_feature_slider' => Mage::helper('evolved')->__('Image with Feature Slider'),
      		),
      		'onchange' => "selectpageelementstyletwo(this.value)",
      ))
      ->setAfterElementHtml("
      		<script type=\"text/javascript\">
      			function selectpageelementstyletwo(style)
      			{
      				//alert(style);
      				jQuery('#evolved_homepage_element_two .allpageelementmaintable').css('display','none');
      		      	jQuery('#evolved_homepage_element_two #' + style).css('display','block');
      			}      		
      		</script>
      	");
      $fieldset_page_element_two->addField('homepage_element_two_style_margintop', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Margin Top In Pixels:'),
      		'name'      => 'homepage_element_two_style_margintop',
      ));
	  
	  $fieldset_page_element_two->addField('homepage_element_two_width_after', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Remove Element After Width (px):'),
      		'name'      => 'homepage_element_two_width_after',
      		'style' => 'width:50px'
      ));
	   /*$fieldset_page_element_two->addField('homepage_element_two_width_after_enable', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Page Element Style Enable After Above Width:'),
      		'name'      => 'homepage_element_two_width_after_enable',
      		'options'   => array(
      				'1' => Mage::helper('evolved')->__('Yes'),
      				'0' => Mage::helper('evolved')->__('No'),
      		),
      ));*/
	  
		      $fieldset_page_element_two->addType('elementtwo', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Pageelementstyle_Elementtwo'));
      $fieldset_page_element_two->addField('elementtwo', 'elementtwo', array(
      		'name'      => 'elementtwo',
      ));
	  
	  	        $fieldset_page_element_three = $form->addFieldset('evolved_homepage_element_three', array('legend'=>Mage::helper('evolved')->__('Page Element 3')));
	  	        $fieldset_page_element_three->addField('homepage_element_three_style_enable', 'select', array(
	  	        		'label'     => Mage::helper('evolved')->__('Page Element Style:'),
	  	        		'name'      => 'homepage_element_three_style_enable',
	  	        		'options'   => array(
	  	        				'1' => Mage::helper('evolved')->__('Enable'),
	  	        				'0' => Mage::helper('evolved')->__('Disable'),
	  	        		),
	  	        ));
	  	        
	  	        $fieldset_page_element_three->addField('homepage_element_3_sort_order', 'text', array(
	  	        		'label'     => Mage::helper('evolved')->__('Sort Order:'),
	  	        		'name'      => 'homepage_element_3_sort_order',
	  	        		'style' => 'width:50px'
	  	        ));

      $fieldset_page_element_three->addField('homepage_element_three_style', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Page Element Style:'),
      		'name'      => 'homepage_element_three_style',
      		'options'   => array(
      				'' => Mage::helper('evolved')->__('Select Page Element Style'),
					'homepage_element_3_1920_by_480_banner' => Mage::helper('evolved')->__('Single Banner Narrow - full screen'),
					'homepage_element_3_1920_by_800_banner' => Mage::helper('evolved')->__('Single Banner Tall - full screen'),
					'homepage_element_3_30_70_boxes_full_width' => Mage::helper('evolved')->__('Three Boxes Featured Right - full screen'),
					'homepage_element_3_70_30_boxes_full_width' => Mage::helper('evolved')->__('Three Boxes Featured Left - full screen'),
					'homepage_element_3_33_percentage_640_by_400_three_boxes_full_width' => Mage::helper('evolved')->__('Three Boxes - full screen'),
					'homepage_element_3_25_percentage_480_by_400_four_boxes_full_width' => Mage::helper('evolved')->__('Four Boxes - full screen'),
					'homepage_element_3_1050_by_170_banner' => Mage::helper('evolved')->__('Promo Single Banner - Centered'),
					'homepage_element_3_1050_by_170_banner' => Mage::helper('evolved')->__('Promo Single Banner - Centered'),
					'homepage_element_3_50_percentage_522_by_170_two_boxes_width' => Mage::helper('evolved')->__('Two Boxes Narrow - Centered'),
					'homepage_element_3_50_percentage_522_by_346_two_boxes_width' => Mage::helper('evolved')->__('Two Boxes Tall - Centered'),
					'homepage_element_3_33_percentage_346_by_170_three_boxes_width' => Mage::helper('evolved')->__('Three Boxes Narrow - Centered'),
					'homepage_element_3_33_percentage_346_by_346_three_boxes_width' => Mage::helper('evolved')->__('Three Boxes Square - Centered'),
					'homepage_element_3_33_percentage_left_50_percentage_right_boxes_right_updown_width' => Mage::helper('evolved')->__('Three Boxes Featured Left - Centered'),
					'homepage_element_3_25_percentage_258_by_170_four_boxes_width' => Mage::helper('evolved')->__('Four Boxes Accross - Centered'),
					'homepage_element_3_33_percentage_346_by_346_three_boxes_middle_updown_width' => Mage::helper('evolved')->__('Four Boxes Featured Sides - Centered'),
					'homepage_element_3_33_percentage_346_by_346_three_boxes_leftright_updown_width' => Mage::helper('evolved')->__('Four Boxes Featured Middle - Centered'),
      				//'homepage_element_3_show_newarrival_product' => Mage::helper('evolved')->__('New Arrival Product'),
      				//'homepage_element_3_show_special_product' => Mage::helper('evolved')->__('Special Products'),
      				//'homepage_element_3_show_bestsellers_product' => Mage::helper('evolved')->__('Best Sellers Product'),
      				//'homepage_element_3_show_mostviewed_product' => Mage::helper('evolved')->__('Most Viewed Product'),
      				'homepage_element_3_show_featured_product' => Mage::helper('evolved')->__('Featured Product'),
      				'homepage_element_3_show_brand_manager' => Mage::helper('evolved')->__('Brand Manager'),
      				'homepage_element_3_show_slideshow_banner' => Mage::helper('evolved')->__('Slide Show Banner'),
      				'homepage_element_3_show_diamondrow' => Mage::helper('evolved')->__('Loose Diamonds'),
      				'homepage_element_3_show_textrow' => Mage::helper('evolved')->__('Text Row'),
      				'homepage_element_3_show_image_with_feature_slider' => Mage::helper('evolved')->__('Image with Feature Slider'),
      		),
      		'onchange' => "selectpageelementstylethree(this.value)",
      ))
      ->setAfterElementHtml("
      		<script type=\"text/javascript\">
      			function selectpageelementstylethree(style)
      			{
      				//alert(style);
      				jQuery('#evolved_homepage_element_three .allpageelementmaintable').css('display','none');
      		      	jQuery('#evolved_homepage_element_three #' + style).css('display','block');
      			}      		
      		</script>
      	");
      $fieldset_page_element_three->addField('homepage_element_three_style_margintop', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Margin Top In Pixels:'),
      		'name'      => 'homepage_element_three_style_margintop',
      ));
	  
	  $fieldset_page_element_three->addField('homepage_element_three_width_after', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Remove Element After Width (px):'),
      		'name'      => 'homepage_element_three_width_after',
      		'style' => 'width:50px'
      ));
	  /* $fieldset_page_element_three->addField('homepage_element_three_width_after_enable', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Page Element Style Enable After Above Width:'),
      		'name'      => 'homepage_element_three_width_after_enable',
      		'options'   => array(
      				'1' => Mage::helper('evolved')->__('Yes'),
      				'0' => Mage::helper('evolved')->__('No'),
      		),
      ));*/
	  
		$fieldset_page_element_three->addType('elementthree', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Pageelementstyle_Elementthree'));
      $fieldset_page_element_three->addField('elementthree', 'elementthree', array(
      		'name'      => 'elementthree',
      ));
	  
	  	        $fieldset_page_element_four = $form->addFieldset('evolved_homepage_element_four', array('legend'=>Mage::helper('evolved')->__('Page Element 4')));
	  	        $fieldset_page_element_four->addField('homepage_element_four_style_enable', 'select', array(
	  	        		'label'     => Mage::helper('evolved')->__('Page Element Style:'),
	  	        		'name'      => 'homepage_element_four_style_enable',
	  	        		'options'   => array(
	  	        				'1' => Mage::helper('evolved')->__('Enable'),
	  	        				'0' => Mage::helper('evolved')->__('Disable'),
	  	        		),
	  	        ));
	  	        
	  	        $fieldset_page_element_four->addField('homepage_element_4_sort_order', 'text', array(
	  	        		'label'     => Mage::helper('evolved')->__('Sort Order:'),
	  	        		'name'      => 'homepage_element_4_sort_order',
	  	        		'style' => 'width:50px'
	  	        ));

      $fieldset_page_element_four->addField('homepage_element_four_style', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Page Element Style:'),
      		'name'      => 'homepage_element_four_style',
      		'options'   => array(
      				'' => Mage::helper('evolved')->__('Select Page Element Style'),
					'homepage_element_4_1920_by_480_banner' => Mage::helper('evolved')->__('Single Banner Narrow - full screen'),
					'homepage_element_4_1920_by_800_banner' => Mage::helper('evolved')->__('Single Banner Tall - full screen'),
					'homepage_element_4_30_70_boxes_full_width' => Mage::helper('evolved')->__('Three Boxes Featured Right - full screen'),
					'homepage_element_4_70_30_boxes_full_width' => Mage::helper('evolved')->__('Three Boxes Featured Left - full screen'),
					'homepage_element_4_33_percentage_640_by_400_three_boxes_full_width' => Mage::helper('evolved')->__('Three Boxes - full screen'),
					'homepage_element_4_25_percentage_480_by_400_four_boxes_full_width' => Mage::helper('evolved')->__('Four Boxes - full screen'),
					'homepage_element_4_1050_by_170_banner' => Mage::helper('evolved')->__('Promo Single Banner - Centered'),
					'homepage_element_4_1050_by_170_banner' => Mage::helper('evolved')->__('Promo Single Banner - Centered'),
					'homepage_element_4_50_percentage_522_by_170_two_boxes_width' => Mage::helper('evolved')->__('Two Boxes Narrow - Centered'),
					'homepage_element_4_50_percentage_522_by_346_two_boxes_width' => Mage::helper('evolved')->__('Two Boxes Tall - Centered'),
					'homepage_element_4_33_percentage_346_by_170_three_boxes_width' => Mage::helper('evolved')->__('Three Boxes Narrow - Centered'),
					'homepage_element_4_33_percentage_346_by_346_three_boxes_width' => Mage::helper('evolved')->__('Three Boxes Square - Centered'),
					'homepage_element_4_33_percentage_left_50_percentage_right_boxes_right_updown_width' => Mage::helper('evolved')->__('Three Boxes Featured Left - Centered'),
					'homepage_element_4_25_percentage_258_by_170_four_boxes_width' => Mage::helper('evolved')->__('Four Boxes Accross - Centered'),
					'homepage_element_4_33_percentage_346_by_346_three_boxes_middle_updown_width' => Mage::helper('evolved')->__('Four Boxes Featured Sides - Centered'),
					'homepage_element_4_33_percentage_346_by_346_three_boxes_leftright_updown_width' => Mage::helper('evolved')->__('Four Boxes Featured Middle - Centered'),
      				//'homepage_element_4_show_newarrival_product' => Mage::helper('evolved')->__('New Arrival Product'),
      				//'homepage_element_4_show_special_product' => Mage::helper('evolved')->__('Special Products'),
      				//'homepage_element_4_show_bestsellers_product' => Mage::helper('evolved')->__('Best Sellers Product'),
      				//'homepage_element_4_show_mostviewed_product' => Mage::helper('evolved')->__('Most Viewed Product'),
      				'homepage_element_4_show_featured_product' => Mage::helper('evolved')->__('Featured Product'),
      				'homepage_element_4_show_brand_manager' => Mage::helper('evolved')->__('Brand Manager'),
      				'homepage_element_4_show_slideshow_banner' => Mage::helper('evolved')->__('Slide Show Banner'),
      				'homepage_element_4_show_diamondrow' => Mage::helper('evolved')->__('Loose Diamonds'),
      				'homepage_element_4_show_textrow' => Mage::helper('evolved')->__('Text Row'),
      				'homepage_element_4_show_image_with_feature_slider' => Mage::helper('evolved')->__('Image with Feature Slider'),
      		),
      		'onchange' => "selectpageelementstylefour(this.value)",
      ))
      ->setAfterElementHtml("
      		<script type=\"text/javascript\">
      			function selectpageelementstylefour(style)
      			{
      				//alert(style);
      				jQuery('#evolved_homepage_element_four .allpageelementmaintable').css('display','none');
      		      	jQuery('#evolved_homepage_element_four #' + style).css('display','block');
      			}      		
      		</script>
      	");
      $fieldset_page_element_four->addField('homepage_element_four_style_margintop', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Margin Top In Pixels:'),
      		'name'      => 'homepage_element_four_style_margintop',
      ));
	  
	  $fieldset_page_element_four->addField('homepage_element_four_width_after', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Remove Element After Width (px):'),
      		'name'      => 'homepage_element_four_width_after',
      		'style' => 'width:50px'
      ));
	  /* $fieldset_page_element_four->addField('homepage_element_four_width_after_enable', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Page Element Style Enable After Above Width:'),
      		'name'      => 'homepage_element_four_width_after_enable',
      		'options'   => array(
      				'1' => Mage::helper('evolved')->__('Yes'),
      				'0' => Mage::helper('evolved')->__('No'),
      		),
      ));*/
	  
	$fieldset_page_element_four->addType('elementfour', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Pageelementstyle_Elementfour'));
      $fieldset_page_element_four->addField('elementfour', 'elementfour', array(
      		'name'      => 'elementfour',
      ));
	  
	$fieldset_page_element_five = $form->addFieldset('evolved_homepage_element_five', array('legend'=>Mage::helper('evolved')->__('Page Element 5')));
	$fieldset_page_element_five->addField('homepage_element_five_style_enable', 'select', array(
	  	        		'label'     => Mage::helper('evolved')->__('Page Element Style:'),
	  	        		'name'      => 'homepage_element_five_style_enable',
	  	        		'options'   => array(
	  	        				'1' => Mage::helper('evolved')->__('Enable'),
	  	        				'0' => Mage::helper('evolved')->__('Disable'),
	  	        		),
	  	        ));
	
	$fieldset_page_element_five->addField('homepage_element_5_sort_order', 'text', array(
			'label'     => Mage::helper('evolved')->__('Sort Order:'),
			'name'      => 'homepage_element_5_sort_order',
			'style' => 'width:50px'
	));

      $fieldset_page_element_five->addField('homepage_element_five_style', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Page Element Style:'),
      		'name'      => 'homepage_element_five_style',
      		'options'   => array(
      				'' => Mage::helper('evolved')->__('Select Page Element Style'),
					'homepage_element_5_1920_by_480_banner' => Mage::helper('evolved')->__('Single Banner Narrow - full screen'),
					'homepage_element_5_1920_by_800_banner' => Mage::helper('evolved')->__('Single Banner Tall - full screen'),
					'homepage_element_5_30_70_boxes_full_width' => Mage::helper('evolved')->__('Three Boxes Featured Right - full screen'),
					'homepage_element_5_70_30_boxes_full_width' => Mage::helper('evolved')->__('Three Boxes Featured Left - full screen'),
					'homepage_element_5_33_percentage_640_by_400_three_boxes_full_width' => Mage::helper('evolved')->__('Three Boxes - full screen'),
					'homepage_element_5_25_percentage_480_by_400_four_boxes_full_width' => Mage::helper('evolved')->__('Four Boxes - full screen'),
					'homepage_element_5_1050_by_170_banner' => Mage::helper('evolved')->__('Promo Single Banner - Centered'),
					'homepage_element_5_1050_by_170_banner' => Mage::helper('evolved')->__('Promo Single Banner - Centered'),
					'homepage_element_5_50_percentage_522_by_170_two_boxes_width' => Mage::helper('evolved')->__('Two Boxes Narrow - Centered'),
					'homepage_element_5_50_percentage_522_by_346_two_boxes_width' => Mage::helper('evolved')->__('Two Boxes Tall - Centered'),
					'homepage_element_5_33_percentage_346_by_170_three_boxes_width' => Mage::helper('evolved')->__('Three Boxes Narrow - Centered'),
					'homepage_element_5_33_percentage_346_by_346_three_boxes_width' => Mage::helper('evolved')->__('Three Boxes Square - Centered'),
					'homepage_element_5_33_percentage_left_50_percentage_right_boxes_right_updown_width' => Mage::helper('evolved')->__('Three Boxes Featured Left - Centered'),
					'homepage_element_5_25_percentage_258_by_170_four_boxes_width' => Mage::helper('evolved')->__('Four Boxes Accross - Centered'),
					'homepage_element_5_33_percentage_346_by_346_three_boxes_middle_updown_width' => Mage::helper('evolved')->__('Four Boxes Featured Sides - Centered'),
					'homepage_element_5_33_percentage_346_by_346_three_boxes_leftright_updown_width' => Mage::helper('evolved')->__('Four Boxes Featured Middle - Centered'),
      				//'homepage_element_5_show_newarrival_product' => Mage::helper('evolved')->__('New Arrival Product'),
      				//'homepage_element_5_show_special_product' => Mage::helper('evolved')->__('Special Products'),
      				//'homepage_element_5_show_bestsellers_product' => Mage::helper('evolved')->__('Best Sellers Product'),
      				//'homepage_element_5_show_mostviewed_product' => Mage::helper('evolved')->__('Most Viewed Product'),
      				'homepage_element_5_show_featured_product' => Mage::helper('evolved')->__('Featured Product'),
      				'homepage_element_5_show_brand_manager' => Mage::helper('evolved')->__('Brand Manager'),
      				'homepage_element_5_show_slideshow_banner' => Mage::helper('evolved')->__('Slide Show Banner'),
      				'homepage_element_5_show_diamondrow' => Mage::helper('evolved')->__('Loose Diamonds'),
      				'homepage_element_5_show_textrow' => Mage::helper('evolved')->__('Text Row'),
      				'homepage_element_5_show_image_with_feature_slider' => Mage::helper('evolved')->__('Image with Feature Slider'),
      		),
      		'onchange' => "selectpageelementstylefive(this.value)",
      ))
      ->setAfterElementHtml("
      		<script type=\"text/javascript\">
      			function selectpageelementstylefive(style)
      			{
      				//alert(style);
      				jQuery('#evolved_homepage_element_five .allpageelementmaintable').css('display','none');
      		      	jQuery('#evolved_homepage_element_five #' + style).css('display','block');
      			}      		
      		</script>
      	");
      $fieldset_page_element_five->addField('homepage_element_five_style_margintop', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Margin Top In Pixels:'),
      		'name'      => 'homepage_element_five_style_margintop',
      ));
	  
	  $fieldset_page_element_five->addField('homepage_element_five_width_after', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Remove Element After Width (px):'),
      		'name'      => 'homepage_element_five_width_after',
      		'style' => 'width:50px'
      ));
	   /*$fieldset_page_element_five->addField('homepage_element_five_width_after_enable', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Page Element Style Enable After Above Width:'),
      		'name'      => 'homepage_element_five_width_after_enable',
      		'options'   => array(
      				'1' => Mage::helper('evolved')->__('Yes'),
      				'0' => Mage::helper('evolved')->__('No'),
      		),
      ));*/
	  
						$fieldset_page_element_five->addType('elementfive', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Pageelementstyle_Elementfive'));
      $fieldset_page_element_five->addField('elementfive', 'elementfive', array(
      		'name'      => 'elementfive',
      ));
	  
	  
	  $fieldset_page_element_six = $form->addFieldset('evolved_homepage_element_six', array('legend'=>Mage::helper('evolved')->__('Page Element 6')));
	$fieldset_page_element_six->addField('homepage_element_six_style_enable', 'select', array(
	  	        		'label'     => Mage::helper('evolved')->__('Page Element Style:'),
	  	        		'name'      => 'homepage_element_six_style_enable',
	  	        		'options'   => array(
	  	        				'1' => Mage::helper('evolved')->__('Enable'),
	  	        				'0' => Mage::helper('evolved')->__('Disable'),
	  	        		),
	  	        ));
	
	$fieldset_page_element_six->addField('homepage_element_6_sort_order', 'text', array(
			'label'     => Mage::helper('evolved')->__('Sort Order:'),
			'name'      => 'homepage_element_6_sort_order',
			'style' => 'width:50px'
	));

      $fieldset_page_element_six->addField('homepage_element_six_style', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Page Element Style:'),
      		'name'      => 'homepage_element_six_style',
      		'options'   => array(
      				'' => Mage::helper('evolved')->__('Select Page Element Style'),
					'homepage_element_6_1920_by_480_banner' => Mage::helper('evolved')->__('Single Banner Narrow - full screen'),
					'homepage_element_6_1920_by_800_banner' => Mage::helper('evolved')->__('Single Banner Tall - full screen'),
					'homepage_element_6_30_70_boxes_full_width' => Mage::helper('evolved')->__('Three Boxes Featured Right - full screen'),
					'homepage_element_6_70_30_boxes_full_width' => Mage::helper('evolved')->__('Three Boxes Featured Left - full screen'),
					'homepage_element_6_33_percentage_640_by_400_three_boxes_full_width' => Mage::helper('evolved')->__('Three Boxes - full screen'),
					'homepage_element_6_25_percentage_480_by_400_four_boxes_full_width' => Mage::helper('evolved')->__('Four Boxes - full screen'),
					'homepage_element_6_1050_by_170_banner' => Mage::helper('evolved')->__('Promo Single Banner - Centered'),
					'homepage_element_6_1050_by_170_banner' => Mage::helper('evolved')->__('Promo Single Banner - Centered'),
					'homepage_element_6_50_percentage_522_by_170_two_boxes_width' => Mage::helper('evolved')->__('Two Boxes Narrow - Centered'),
					'homepage_element_6_50_percentage_522_by_346_two_boxes_width' => Mage::helper('evolved')->__('Two Boxes Tall - Centered'),
					'homepage_element_6_33_percentage_346_by_170_three_boxes_width' => Mage::helper('evolved')->__('Three Boxes Narrow - Centered'),
					'homepage_element_6_33_percentage_346_by_346_three_boxes_width' => Mage::helper('evolved')->__('Three Boxes Square - Centered'),
					'homepage_element_6_33_percentage_left_50_percentage_right_boxes_right_updown_width' => Mage::helper('evolved')->__('Three Boxes Featured Left - Centered'),
					'homepage_element_6_25_percentage_258_by_170_four_boxes_width' => Mage::helper('evolved')->__('Four Boxes Accross - Centered'),
					'homepage_element_6_33_percentage_346_by_346_three_boxes_middle_updown_width' => Mage::helper('evolved')->__('Four Boxes Featured Sides - Centered'),
					'homepage_element_6_33_percentage_346_by_346_three_boxes_leftright_updown_width' => Mage::helper('evolved')->__('Four Boxes Featured Middle - Centered'),
      				//'homepage_element_6_show_newarrival_product' => Mage::helper('evolved')->__('New Arrival Product'),
      				//'homepage_element_6_show_special_product' => Mage::helper('evolved')->__('Special Products'),
      				//'homepage_element_6_show_bestsellers_product' => Mage::helper('evolved')->__('Best Sellers Product'),
      				//'homepage_element_6_show_mostviewed_product' => Mage::helper('evolved')->__('Most Viewed Product'),
      				'homepage_element_6_show_featured_product' => Mage::helper('evolved')->__('Featured Product'),
      				'homepage_element_6_show_brand_manager' => Mage::helper('evolved')->__('Brand Manager'),
      				'homepage_element_6_show_slideshow_banner' => Mage::helper('evolved')->__('Slide Show Banner'),
      				'homepage_element_6_show_diamondrow' => Mage::helper('evolved')->__('Loose Diamonds'),
      				'homepage_element_6_show_textrow' => Mage::helper('evolved')->__('Text Row'),
      				'homepage_element_6_show_image_with_feature_slider' => Mage::helper('evolved')->__('Image with Feature Slider'),
      		),
      		'onchange' => "selectpageelementstylesix(this.value)",
      ))
      ->setAfterElementHtml("
      		<script type=\"text/javascript\">
      			function selectpageelementstylesix(style)
      			{
      				//alert(style);
      				jQuery('#evolved_homepage_element_six .allpageelementmaintable').css('display','none');
      		      	jQuery('#evolved_homepage_element_six #' + style).css('display','block');
      			}      		
      		</script>
      	");
      $fieldset_page_element_six->addField('homepage_element_six_style_margintop', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Margin Top In Pixels:'),
      		'name'      => 'homepage_element_six_style_margintop',
      ));
	  
	  $fieldset_page_element_six->addField('homepage_element_six_width_after', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Remove Element After Width (px):'),
      		'name'      => 'homepage_element_six_width_after',
      		'style' => 'width:50px'
      ));
	   /*$fieldset_page_element_six->addField('homepage_element_six_width_after_enable', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Page Element Style Enable After Above Width:'),
      		'name'      => 'homepage_element_six_width_after_enable',
      		'options'   => array(
      				'1' => Mage::helper('evolved')->__('Yes'),
      				'0' => Mage::helper('evolved')->__('No'),
      		),
      ));*/
	  
	  $fieldset_page_element_six->addType('elementsix', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Pageelementstyle_Elementsix'));
      $fieldset_page_element_six->addField('elementsix', 'elementsix', array(
      		'name'      => 'elementsix',
      ));
	  
	  $fieldset_page_element_seven = $form->addFieldset('evolved_homepage_element_seven', array('legend'=>Mage::helper('evolved')->__('Page Element 7')));
	$fieldset_page_element_seven->addField('homepage_element_seven_style_enable', 'select', array(
	  	        		'label'     => Mage::helper('evolved')->__('Page Element Style:'),
	  	        		'name'      => 'homepage_element_seven_style_enable',
	  	        		'options'   => array(
	  	        				'1' => Mage::helper('evolved')->__('Enable'),
	  	        				'0' => Mage::helper('evolved')->__('Disable'),
	  	        		),
	  	        ));
	
	$fieldset_page_element_seven->addField('homepage_element_7_sort_order', 'text', array(
			'label'     => Mage::helper('evolved')->__('Sort Order:'),
			'name'      => 'homepage_element_7_sort_order',
			'style' => 'width:50px'
	));

      $fieldset_page_element_seven->addField('homepage_element_seven_style', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Page Element Style:'),
      		'name'      => 'homepage_element_seven_style',
      		'options'   => array(
      				'' => Mage::helper('evolved')->__('Select Page Element Style'),
					'homepage_element_7_1920_by_480_banner' => Mage::helper('evolved')->__('Single Banner Narrow - full screen'),
					'homepage_element_7_1920_by_800_banner' => Mage::helper('evolved')->__('Single Banner Tall - full screen'),
					'homepage_element_7_30_70_boxes_full_width' => Mage::helper('evolved')->__('Three Boxes Featured Right - full screen'),
					'homepage_element_7_70_30_boxes_full_width' => Mage::helper('evolved')->__('Three Boxes Featured Left - full screen'),
					'homepage_element_7_33_percentage_640_by_400_three_boxes_full_width' => Mage::helper('evolved')->__('Three Boxes - full screen'),
					'homepage_element_7_25_percentage_480_by_400_four_boxes_full_width' => Mage::helper('evolved')->__('Four Boxes - full screen'),
					'homepage_element_7_1050_by_170_banner' => Mage::helper('evolved')->__('Promo Single Banner - Centered'),
					'homepage_element_7_1050_by_170_banner' => Mage::helper('evolved')->__('Promo Single Banner - Centered'),
					'homepage_element_7_50_percentage_522_by_170_two_boxes_width' => Mage::helper('evolved')->__('Two Boxes Narrow - Centered'),
					'homepage_element_7_50_percentage_522_by_346_two_boxes_width' => Mage::helper('evolved')->__('Two Boxes Tall - Centered'),
					'homepage_element_7_33_percentage_346_by_170_three_boxes_width' => Mage::helper('evolved')->__('Three Boxes Narrow - Centered'),
					'homepage_element_7_33_percentage_346_by_346_three_boxes_width' => Mage::helper('evolved')->__('Three Boxes Square - Centered'),
					'homepage_element_7_33_percentage_left_50_percentage_right_boxes_right_updown_width' => Mage::helper('evolved')->__('Three Boxes Featured Left - Centered'),
					'homepage_element_7_25_percentage_258_by_170_four_boxes_width' => Mage::helper('evolved')->__('Four Boxes Accross - Centered'),
					'homepage_element_7_33_percentage_346_by_346_three_boxes_middle_updown_width' => Mage::helper('evolved')->__('Four Boxes Featured Sides - Centered'),
					'homepage_element_7_33_percentage_346_by_346_three_boxes_leftright_updown_width' => Mage::helper('evolved')->__('Four Boxes Featured Middle - Centered'),
      				//'homepage_element_7_show_newarrival_product' => Mage::helper('evolved')->__('New Arrival Product'),
      				//'homepage_element_7_show_special_product' => Mage::helper('evolved')->__('Special Products'),
      				//'homepage_element_7_show_bestsellers_product' => Mage::helper('evolved')->__('Best Sellers Product'),
      				//'homepage_element_7_show_mostviewed_product' => Mage::helper('evolved')->__('Most Viewed Product'),
      				'homepage_element_7_show_featured_product' => Mage::helper('evolved')->__('Featured Product'),
      				'homepage_element_7_show_brand_manager' => Mage::helper('evolved')->__('Brand Manager'),
      				'homepage_element_7_show_slideshow_banner' => Mage::helper('evolved')->__('Slide Show Banner'),
      				'homepage_element_7_show_diamondrow' => Mage::helper('evolved')->__('Loose Diamonds'),
      				'homepage_element_7_show_textrow' => Mage::helper('evolved')->__('Text Row'),
      				'homepage_element_7_show_image_with_feature_slider' => Mage::helper('evolved')->__('Image with Feature Slider'),
      		),
      		'onchange' => "selectpageelementstyleseven(this.value)",
      ))
      ->setAfterElementHtml("
      		<script type=\"text/javascript\">
      			function selectpageelementstyleseven(style)
      			{
      				//alert(style);
      				jQuery('#evolved_homepage_element_seven .allpageelementmaintable').css('display','none');
      		      	jQuery('#evolved_homepage_element_seven #' + style).css('display','block');
      			}      		
      		</script>
      	");
      $fieldset_page_element_seven->addField('homepage_element_seven_style_margintop', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Margin Top In Pixels:'),
      		'name'      => 'homepage_element_seven_style_margintop',
      ));
	  
	  $fieldset_page_element_seven->addField('homepage_element_seven_width_after', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Remove Element After Width (px):'),
      		'name'      => 'homepage_element_seven_width_after',
      		'style' => 'width:50px'
      ));
	  /* $fieldset_page_element_seven->addField('homepage_element_seven_width_after_enable', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Page Element Style Enable After Above Width:'),
      		'name'      => 'homepage_element_seven_width_after_enable',
      		'options'   => array(
      				'1' => Mage::helper('evolved')->__('Yes'),
      				'0' => Mage::helper('evolved')->__('No'),
      		),
      ));*/
	  
	  $fieldset_page_element_seven->addType('elementseven', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Pageelementstyle_Elementseven'));
      $fieldset_page_element_seven->addField('elementseven', 'elementseven', array(
      		'name'      => 'elementseven',
      ));
	  
	  $fieldset_page_element_eight = $form->addFieldset('evolved_homepage_element_eight', array('legend'=>Mage::helper('evolved')->__('Page Element 8')));
	$fieldset_page_element_eight->addField('homepage_element_eight_style_enable', 'select', array(
	  	        		'label'     => Mage::helper('evolved')->__('Page Element Style:'),
	  	        		'name'      => 'homepage_element_eight_style_enable',
	  	        		'options'   => array(
	  	        				'1' => Mage::helper('evolved')->__('Enable'),
	  	        				'0' => Mage::helper('evolved')->__('Disable'),
	  	        		),
	  	        ));
	
	$fieldset_page_element_eight->addField('homepage_element_8_sort_order', 'text', array(
			'label'     => Mage::helper('evolved')->__('Sort Order:'),
			'name'      => 'homepage_element_8_sort_order',
			'style' => 'width:50px'
	));

      $fieldset_page_element_eight->addField('homepage_element_eight_style', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Page Element Style:'),
      		'name'      => 'homepage_element_eight_style',
      		'options'   => array(
      				'' => Mage::helper('evolved')->__('Select Page Element Style'),
					'homepage_element_8_1920_by_480_banner' => Mage::helper('evolved')->__('Single Banner Narrow - full screen'),
					'homepage_element_8_1920_by_800_banner' => Mage::helper('evolved')->__('Single Banner Tall - full screen'),
					'homepage_element_8_30_70_boxes_full_width' => Mage::helper('evolved')->__('Three Boxes Featured Right - full screen'),
					'homepage_element_8_70_30_boxes_full_width' => Mage::helper('evolved')->__('Three Boxes Featured Left - full screen'),
					'homepage_element_8_33_percentage_640_by_400_three_boxes_full_width' => Mage::helper('evolved')->__('Three Boxes - full screen'),
					'homepage_element_8_25_percentage_480_by_400_four_boxes_full_width' => Mage::helper('evolved')->__('Four Boxes - full screen'),
					'homepage_element_8_1050_by_170_banner' => Mage::helper('evolved')->__('Promo Single Banner - Centered'),
					'homepage_element_8_1050_by_170_banner' => Mage::helper('evolved')->__('Promo Single Banner - Centered'),
					'homepage_element_8_50_percentage_522_by_170_two_boxes_width' => Mage::helper('evolved')->__('Two Boxes Narrow - Centered'),
					'homepage_element_8_50_percentage_522_by_346_two_boxes_width' => Mage::helper('evolved')->__('Two Boxes Tall - Centered'),
					'homepage_element_8_33_percentage_346_by_170_three_boxes_width' => Mage::helper('evolved')->__('Three Boxes Narrow - Centered'),
					'homepage_element_8_33_percentage_346_by_346_three_boxes_width' => Mage::helper('evolved')->__('Three Boxes Square - Centered'),
					'homepage_element_8_33_percentage_left_50_percentage_right_boxes_right_updown_width' => Mage::helper('evolved')->__('Three Boxes Featured Left - Centered'),
					'homepage_element_8_25_percentage_258_by_170_four_boxes_width' => Mage::helper('evolved')->__('Four Boxes Accross - Centered'),
					'homepage_element_8_33_percentage_346_by_346_three_boxes_middle_updown_width' => Mage::helper('evolved')->__('Four Boxes Featured Sides - Centered'),
					'homepage_element_8_33_percentage_346_by_346_three_boxes_leftright_updown_width' => Mage::helper('evolved')->__('Four Boxes Featured Middle - Centered'),
      				//'homepage_element_8_show_newarrival_product' => Mage::helper('evolved')->__('New Arrival Product'),
      				//'homepage_element_8_show_special_product' => Mage::helper('evolved')->__('Special Products'),
      				//'homepage_element_8_show_bestsellers_product' => Mage::helper('evolved')->__('Best Sellers Product'),
      				//'homepage_element_8_show_mostviewed_product' => Mage::helper('evolved')->__('Most Viewed Product'),
      				'homepage_element_8_show_featured_product' => Mage::helper('evolved')->__('Featured Product'),
      				'homepage_element_8_show_brand_manager' => Mage::helper('evolved')->__('Brand Manager'),
      				'homepage_element_8_show_slideshow_banner' => Mage::helper('evolved')->__('Slide Show Banner'),
      				'homepage_element_8_show_diamondrow' => Mage::helper('evolved')->__('Loose Diamonds'),
      				'homepage_element_8_show_textrow' => Mage::helper('evolved')->__('Text Row'),
      				'homepage_element_8_show_image_with_feature_slider' => Mage::helper('evolved')->__('Image with Feature Slider'),
      		),
      		'onchange' => "selectpageelementstyleeight(this.value)",
      ))
      ->setAfterElementHtml("
      		<script type=\"text/javascript\">
      			function selectpageelementstyleeight(style)
      			{
      				//alert(style);
      				jQuery('#evolved_homepage_element_eight .allpageelementmaintable').css('display','none');
      		      	jQuery('#evolved_homepage_element_eight #' + style).css('display','block');
      			}      		
      		</script>
      	");
      $fieldset_page_element_eight->addField('homepage_element_eight_style_margintop', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Margin Top In Pixels:'),
      		'name'      => 'homepage_element_eight_style_margintop',
      ));
	  
	  $fieldset_page_element_eight->addField('homepage_element_eight_width_after', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Remove Element After Width (px):'),
      		'name'      => 'homepage_element_eight_width_after',
      		'style' => 'width:50px'
      ));
	  /* $fieldset_page_element_eight->addField('homepage_element_eight_width_after_enable', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Page Element Style Enable After Above Width:'),
      		'name'      => 'homepage_element_eight_width_after_enable',
      		'options'   => array(
      				'1' => Mage::helper('evolved')->__('Yes'),
      				'0' => Mage::helper('evolved')->__('No'),
      		),
      ));*/
	  
	  $fieldset_page_element_eight->addType('elementeight', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Pageelementstyle_Elementeight'));
      $fieldset_page_element_eight->addField('elementeight', 'elementeight', array(
      		'name'      => 'elementeight',
      ));
      
      $fieldset_page_element_nine = $form->addFieldset('evolved_homepage_element_nine', array('legend'=>Mage::helper('evolved')->__('Page Element 9')));
      $fieldset_page_element_nine->addField('homepage_element_nine_style_enable', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Page Element Style:'),
      		'name'      => 'homepage_element_nine_style_enable',
      		'options'   => array(
      				'1' => Mage::helper('evolved')->__('Enable'),
      				'0' => Mage::helper('evolved')->__('Disable'),
      		),
      ));
      
      $fieldset_page_element_nine->addField('homepage_element_9_sort_order', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Sort Order:'),
      		'name'      => 'homepage_element_9_sort_order',
      		'style' => 'width:50px'
      ));
      
      $fieldset_page_element_nine->addField('homepage_element_nine_style', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Page Element Style:'),
      		'name'      => 'homepage_element_nine_style',
      		'options'   => array(
      				'' => Mage::helper('evolved')->__('Select Page Element Style'),
      				'homepage_element_9_1920_by_480_banner' => Mage::helper('evolved')->__('Single Banner Narrow - full screen'),
      				'homepage_element_9_1920_by_800_banner' => Mage::helper('evolved')->__('Single Banner Tall - full screen'),
      				'homepage_element_9_30_70_boxes_full_width' => Mage::helper('evolved')->__('Three Boxes Featured Right - full screen'),
      				'homepage_element_9_70_30_boxes_full_width' => Mage::helper('evolved')->__('Three Boxes Featured Left - full screen'),
      				'homepage_element_9_33_percentage_640_by_400_three_boxes_full_width' => Mage::helper('evolved')->__('Three Boxes - full screen'),
      				'homepage_element_9_25_percentage_480_by_400_four_boxes_full_width' => Mage::helper('evolved')->__('Four Boxes - full screen'),
      				'homepage_element_9_1050_by_170_banner' => Mage::helper('evolved')->__('Promo Single Banner - Centered'),
      				'homepage_element_9_1050_by_170_banner' => Mage::helper('evolved')->__('Promo Single Banner - Centered'),
      				'homepage_element_9_50_percentage_522_by_170_two_boxes_width' => Mage::helper('evolved')->__('Two Boxes Narrow - Centered'),
      				'homepage_element_9_50_percentage_522_by_346_two_boxes_width' => Mage::helper('evolved')->__('Two Boxes Tall - Centered'),
      				'homepage_element_9_33_percentage_346_by_170_three_boxes_width' => Mage::helper('evolved')->__('Three Boxes Narrow - Centered'),
      				'homepage_element_9_33_percentage_346_by_346_three_boxes_width' => Mage::helper('evolved')->__('Three Boxes Square - Centered'),
      				'homepage_element_9_33_percentage_left_50_percentage_right_boxes_right_updown_width' => Mage::helper('evolved')->__('Three Boxes Featured Left - Centered'),
      				'homepage_element_9_25_percentage_258_by_170_four_boxes_width' => Mage::helper('evolved')->__('Four Boxes Accross - Centered'),
      				'homepage_element_9_33_percentage_346_by_346_three_boxes_middle_updown_width' => Mage::helper('evolved')->__('Four Boxes Featured Sides - Centered'),
      				'homepage_element_9_33_percentage_346_by_346_three_boxes_leftright_updown_width' => Mage::helper('evolved')->__('Four Boxes Featured Middle - Centered'),
      				//'homepage_element_9_show_newarrival_product' => Mage::helper('evolved')->__('New Arrival Product'),
      				//'homepage_element_9_show_special_product' => Mage::helper('evolved')->__('Special Products'),
      				//'homepage_element_9_show_bestsellers_product' => Mage::helper('evolved')->__('Best Sellers Product'),
      				//'homepage_element_9_show_mostviewed_product' => Mage::helper('evolved')->__('Most Viewed Product'),
      				'homepage_element_9_show_featured_product' => Mage::helper('evolved')->__('Featured Product'),
      				'homepage_element_9_show_brand_manager' => Mage::helper('evolved')->__('Brand Manager'),
      				'homepage_element_9_show_slideshow_banner' => Mage::helper('evolved')->__('Slide Show Banner'),
      				'homepage_element_9_show_diamondrow' => Mage::helper('evolved')->__('Loose Diamonds'),
      				'homepage_element_9_show_textrow' => Mage::helper('evolved')->__('Text Row'),
      				'homepage_element_9_show_image_with_feature_slider' => Mage::helper('evolved')->__('Image with Feature Slider'),
      		),
      		'onchange' => "selectpageelementstylenine(this.value)",
      ))
      ->setAfterElementHtml("
      		<script type=\"text/javascript\">
      			function selectpageelementstylenine(style)
      			{
      				//alert(style);
      				jQuery('#evolved_homepage_element_nine .allpageelementmaintable').css('display','none');
      		      	jQuery('#evolved_homepage_element_nine #' + style).css('display','block');
      			}
      		</script>
      	");
      $fieldset_page_element_nine->addField('homepage_element_nine_style_margintop', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Margin Top In Pixels:'),
      		'name'      => 'homepage_element_nine_style_margintop',
      ));
	  
	  $fieldset_page_element_nine->addField('homepage_element_nine_width_after', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Remove Element After Width (px):'),
      		'name'      => 'homepage_element_nine_width_after',
      		'style' => 'width:50px'
      ));
	   /*$fieldset_page_element_nine->addField('homepage_element_nine_width_after_enable', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Page Element Style Enable After Above Width:'),
      		'name'      => 'homepage_element_nine_width_after_enable',
      		'options'   => array(
      				'1' => Mage::helper('evolved')->__('Yes'),
      				'0' => Mage::helper('evolved')->__('No'),
      		),
      ));*/
	  
      $fieldset_page_element_nine->addType('elementnine', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Pageelementstyle_Elementnine'));
      $fieldset_page_element_nine->addField('elementnine', 'elementnine', array(
      		'name'      => 'elementnine',
      ));
      
      $fieldset_page_element_ten = $form->addFieldset('evolved_homepage_element_ten', array('legend'=>Mage::helper('evolved')->__('Page Element 10')));
      $fieldset_page_element_ten->addField('homepage_element_ten_style_enable', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Page Element Style:'),
      		'name'      => 'homepage_element_ten_style_enable',
      		'options'   => array(
      				'1' => Mage::helper('evolved')->__('Enable'),
      				'0' => Mage::helper('evolved')->__('Disable'),
      		),
      ));
      
      $fieldset_page_element_ten->addField('homepage_element_10_sort_order', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Sort Order:'),
      		'name'      => 'homepage_element_10_sort_order',
      		'style' => 'width:50px'
      ));
      
      $fieldset_page_element_ten->addField('homepage_element_ten_style', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Page Element Style:'),
      		'name'      => 'homepage_element_ten_style',
      		'options'   => array(
      				'' => Mage::helper('evolved')->__('Select Page Element Style'),
      				'homepage_element_10_1920_by_480_banner' => Mage::helper('evolved')->__('Single Banner Narrow - full screen'),
      				'homepage_element_10_1920_by_800_banner' => Mage::helper('evolved')->__('Single Banner Tall - full screen'),
      				'homepage_element_10_30_70_boxes_full_width' => Mage::helper('evolved')->__('Three Boxes Featured Right - full screen'),
      				'homepage_element_10_70_30_boxes_full_width' => Mage::helper('evolved')->__('Three Boxes Featured Left - full screen'),
      				'homepage_element_10_33_percentage_640_by_400_three_boxes_full_width' => Mage::helper('evolved')->__('Three Boxes - full screen'),
      				'homepage_element_10_25_percentage_480_by_400_four_boxes_full_width' => Mage::helper('evolved')->__('Four Boxes - full screen'),
      				'homepage_element_10_1050_by_170_banner' => Mage::helper('evolved')->__('Promo Single Banner - Centered'),
      				'homepage_element_10_1050_by_170_banner' => Mage::helper('evolved')->__('Promo Single Banner - Centered'),
      				'homepage_element_10_50_percentage_522_by_170_two_boxes_width' => Mage::helper('evolved')->__('Two Boxes Narrow - Centered'),
      				'homepage_element_10_50_percentage_522_by_346_two_boxes_width' => Mage::helper('evolved')->__('Two Boxes Tall - Centered'),
      				'homepage_element_10_33_percentage_346_by_170_three_boxes_width' => Mage::helper('evolved')->__('Three Boxes Narrow - Centered'),
      				'homepage_element_10_33_percentage_346_by_346_three_boxes_width' => Mage::helper('evolved')->__('Three Boxes Square - Centered'),
      				'homepage_element_10_33_percentage_left_50_percentage_right_boxes_right_updown_width' => Mage::helper('evolved')->__('Three Boxes Featured Left - Centered'),
      				'homepage_element_10_25_percentage_258_by_170_four_boxes_width' => Mage::helper('evolved')->__('Four Boxes Accross - Centered'),
      				'homepage_element_10_33_percentage_346_by_346_three_boxes_middle_updown_width' => Mage::helper('evolved')->__('Four Boxes Featured Sides - Centered'),
      				'homepage_element_10_33_percentage_346_by_346_three_boxes_leftright_updown_width' => Mage::helper('evolved')->__('Four Boxes Featured Middle - Centered'),
      				//'homepage_element_10_show_newarrival_product' => Mage::helper('evolved')->__('New Arrival Product'),
      				//'homepage_element_10_show_special_product' => Mage::helper('evolved')->__('Special Products'),
      				//'homepage_element_10_show_bestsellers_product' => Mage::helper('evolved')->__('Best Sellers Product'),
      				//'homepage_element_10_show_mostviewed_product' => Mage::helper('evolved')->__('Most Viewed Product'),
      				'homepage_element_10_show_featured_product' => Mage::helper('evolved')->__('Featured Product'),
      				'homepage_element_10_show_brand_manager' => Mage::helper('evolved')->__('Brand Manager'),
      				'homepage_element_10_show_slideshow_banner' => Mage::helper('evolved')->__('Slide Show Banner'),
      				'homepage_element_10_show_diamondrow' => Mage::helper('evolved')->__('Loose Diamonds'),
      				'homepage_element_10_show_textrow' => Mage::helper('evolved')->__('Text Row'),
      				'homepage_element_10_show_image_with_feature_slider' => Mage::helper('evolved')->__('Image with Feature Slider'),
      		),
      		'onchange' => "selectpageelementstyleten(this.value)",
      ))
      ->setAfterElementHtml("
      		<script type=\"text/javascript\">
      			function selectpageelementstyleten(style)
      			{
      				//alert(style);
      				jQuery('#evolved_homepage_element_ten .allpageelementmaintable').css('display','none');
      		      	jQuery('#evolved_homepage_element_ten #' + style).css('display','block');
      			}
      		</script>
      	");
      $fieldset_page_element_ten->addField('homepage_element_ten_style_margintop', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Margin Top In Pixels:'),
      		'name'      => 'homepage_element_ten_style_margintop',
      ));
	  
	  $fieldset_page_element_ten->addField('homepage_element_ten_width_after', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Remove Element After Width (px):'),
      		'name'      => 'homepage_element_ten_width_after',
      		'style' => 'width:50px'
      ));
	   /*$fieldset_page_element_ten->addField('homepage_element_ten_width_after_enable', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Page Element Style Enable After Above Width:'),
      		'name'      => 'homepage_element_ten_width_after_enable',
      		'options'   => array(
      				'1' => Mage::helper('evolved')->__('Yes'),
      				'0' => Mage::helper('evolved')->__('No'),
      		),
      ));*/
	  
      $fieldset_page_element_ten->addType('elementten', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Pageelementstyle_Elementten'));
      $fieldset_page_element_ten->addField('elementten', 'elementten', array(
      		'name'      => 'elementten',
      ));
      
      $fieldset_page_element_eleven = $form->addFieldset('evolved_homepage_element_eleven', array('legend'=>Mage::helper('evolved')->__('Page Element 11')));
      $fieldset_page_element_eleven->addField('homepage_element_eleven_style_enable', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Page Element Style:'),
      		'name'      => 'homepage_element_eleven_style_enable',
      		'options'   => array(
      				'1' => Mage::helper('evolved')->__('Enable'),
      				'0' => Mage::helper('evolved')->__('Disable'),
      		),
      ));
      
      $fieldset_page_element_eleven->addField('homepage_element_11_sort_order', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Sort Order:'),
      		'name'      => 'homepage_element_11_sort_order',
      		'style' => 'width:50px'
      ));
      
      $fieldset_page_element_eleven->addField('homepage_element_eleven_style', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Page Element Style:'),
      		'name'      => 'homepage_element_eleven_style',
      		'options'   => array(
      				'' => Mage::helper('evolved')->__('Select Page Element Style'),
      				'homepage_element_11_1920_by_480_banner' => Mage::helper('evolved')->__('Single Banner Narrow - full screen'),
      				'homepage_element_11_1920_by_800_banner' => Mage::helper('evolved')->__('Single Banner Tall - full screen'),
      				'homepage_element_11_30_70_boxes_full_width' => Mage::helper('evolved')->__('Three Boxes Featured Right - full screen'),
      				'homepage_element_11_70_30_boxes_full_width' => Mage::helper('evolved')->__('Three Boxes Featured Left - full screen'),
      				'homepage_element_11_33_percentage_640_by_400_three_boxes_full_width' => Mage::helper('evolved')->__('Three Boxes - full screen'),
      				'homepage_element_11_25_percentage_480_by_400_four_boxes_full_width' => Mage::helper('evolved')->__('Four Boxes - full screen'),
      				'homepage_element_11_1050_by_170_banner' => Mage::helper('evolved')->__('Promo Single Banner - Centered'),
      				'homepage_element_11_1050_by_170_banner' => Mage::helper('evolved')->__('Promo Single Banner - Centered'),
      				'homepage_element_11_50_percentage_522_by_170_two_boxes_width' => Mage::helper('evolved')->__('Two Boxes Narrow - Centered'),
      				'homepage_element_11_50_percentage_522_by_346_two_boxes_width' => Mage::helper('evolved')->__('Two Boxes Tall - Centered'),
      				'homepage_element_11_33_percentage_346_by_170_three_boxes_width' => Mage::helper('evolved')->__('Three Boxes Narrow - Centered'),
      				'homepage_element_11_33_percentage_346_by_346_three_boxes_width' => Mage::helper('evolved')->__('Three Boxes Square - Centered'),
      				'homepage_element_11_33_percentage_left_50_percentage_right_boxes_right_updown_width' => Mage::helper('evolved')->__('Three Boxes Featured Left - Centered'),
      				'homepage_element_11_25_percentage_258_by_170_four_boxes_width' => Mage::helper('evolved')->__('Four Boxes Accross - Centered'),
      				'homepage_element_11_33_percentage_346_by_346_three_boxes_middle_updown_width' => Mage::helper('evolved')->__('Four Boxes Featured Sides - Centered'),
      				'homepage_element_11_33_percentage_346_by_346_three_boxes_leftright_updown_width' => Mage::helper('evolved')->__('Four Boxes Featured Middle - Centered'),
      				//'homepage_element_11_show_newarrival_product' => Mage::helper('evolved')->__('New Arrival Product'),
      				//'homepage_element_11_show_special_product' => Mage::helper('evolved')->__('Special Products'),
      				//'homepage_element_11_show_bestsellers_product' => Mage::helper('evolved')->__('Best Sellers Product'),
      				//'homepage_element_11_show_mostviewed_product' => Mage::helper('evolved')->__('Most Viewed Product'),
      				'homepage_element_11_show_featured_product' => Mage::helper('evolved')->__('Featured Product'),
      				'homepage_element_11_show_brand_manager' => Mage::helper('evolved')->__('Brand Manager'),
      				'homepage_element_11_show_slideshow_banner' => Mage::helper('evolved')->__('Slide Show Banner'),
      				'homepage_element_11_show_diamondrow' => Mage::helper('evolved')->__('Loose Diamonds'),
      				'homepage_element_11_show_textrow' => Mage::helper('evolved')->__('Text Row'),
      				'homepage_element_11_show_image_with_feature_slider' => Mage::helper('evolved')->__('Image with Feature Slider'),
      		),
      		'onchange' => "selectpageelementstyleeleven(this.value)",
      ))
      ->setAfterElementHtml("
      		<script type=\"text/javascript\">
      			function selectpageelementstyleeleven(style)
      			{
      				//alert(style);
      				jQuery('#evolved_homepage_element_eleven .allpageelementmaintable').css('display','none');
      		      	jQuery('#evolved_homepage_element_eleven #' + style).css('display','block');
      			}
      		</script>
      	");
      $fieldset_page_element_eleven->addField('homepage_element_eleven_style_margintop', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Margin Top In Pixels:'),
      		'name'      => 'homepage_element_eleven_style_margintop',
      ));
	  
	  $fieldset_page_element_eleven->addField('homepage_element_eleven_width_after', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Remove Element After Width (px):'),
      		'name'      => 'homepage_element_eleven_width_after',
      		'style' => 'width:50px'
      ));
	  /* $fieldset_page_element_eleven->addField('homepage_element_eleven_width_after_enable', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Page Element Style Enable After Above Width:'),
      		'name'      => 'homepage_element_eleven_width_after_enable',
      		'options'   => array(
      				'1' => Mage::helper('evolved')->__('Yes'),
      				'0' => Mage::helper('evolved')->__('No'),
      		),
      ));*/
	  
      $fieldset_page_element_eleven->addType('elementeleven', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Pageelementstyle_Elementeleven'));
      $fieldset_page_element_eleven->addField('elementeleven', 'elementeleven', array(
      		'name'      => 'elementeleven',
      ));
	  
      /*$fieldset_page_element_one->addField('homepage_element_one_style_title', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Title:'),
      		'name'      => 'homepage_element_one_style_title',
      ));
      
      $fieldset_page_element_one->addField('homepage_element_one_style_link', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Link:'),
      		'name'      => 'homepage_element_one_style_link',
      ));
      
      $fieldset_page_element_one->addField('homepage_element_one_style_image', 'editor', array(
      		'label'     => Mage::helper('evolved')->__('Image:'),
      		'name'      => 'homepage_element_one_style_image',
      		'style' => 'height:50px;',
      		'config'    => $configSettings,
      		'after_element_html' => '<small>Image size must be 1920*480 pixels</small>',
      ));*/
      /*
      /////-------------------------------------Page Element 2----------------------------------------------////
      $fieldset_page_element_two = $form->addFieldset('evolved_homepage_element_two', array('legend'=>Mage::helper('evolved')->__('Page Element 2')));
      $fieldset_page_element_two->addField('homepage_element_two_style', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Page Element Style:'),
      		'name'      => 'homepage_element_two_style',
      		'options'   => array(
      				'narrow_banner_full_width' => Mage::helper('evolved')->__('Narrow Banner_Full-width'),
      				'tall_banner_full_width' => Mage::helper('evolved')->__('Tall Banner_Full-width'),
      				'30_70_boxes_full_width' => Mage::helper('evolved')->__('30-70 Boxes_Full-width'),
      				'70_30_boxes_full_width' => Mage::helper('evolved')->__('70-30 Boxes_Full-width'),
      		),
      ));
      
      
      $fieldset_page_element_two->addField('homepage_element_two_style_title', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Title:'),
      		'name'      => 'homepage_element_two_style_title',
      ));
      
      $fieldset_page_element_two->addField('homepage_element_two_style_link', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Link:'),
      		'name'      => 'homepage_element_two_style_link',
      ));
      
      $fieldset_page_element_two->addField('homepage_element_two_style_image', 'editor', array(
      		'label'     => Mage::helper('evolved')->__('Image:'),
      		'name'      => 'homepage_element_two_style_image',
      		'style' => 'height:50px;',
      		'config'    => $configSettings,
      		'after_element_html' => '<small>Image size must be 1920*800 pixels</small>',
      ));
      
      /////-------------------------------------Page Element 3----------------------------------------------////
      $fieldset_page_element_three = $form->addFieldset('evolved_homepage_element_three', array('legend'=>Mage::helper('evolved')->__('Page Element 3')));
      $fieldset_page_element_three->addType('elementthree', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Elementthree'));
      $fieldset_page_element_three->addField('elementthreestyle', 'elementthree', array(
      		'name'      => 'elementthreestyle',
      ));

      
      /////-------------------------------------Page Element 4----------------------------------------------////
      $fieldset_page_element_four = $form->addFieldset('evolved_homepage_element_four', array('legend'=>Mage::helper('evolved')->__('Page Element 4')));
      $fieldset_page_element_four->addType('elementfour', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Elementfour'));
      $fieldset_page_element_four->addField('elementfourstyle', 'elementfour', array(
      		'name'      => 'elementfourstyle',
      ));
      
      /////-------------------------------------Page Element 5----------------------------------------------////
      $fieldset_page_element_five = $form->addFieldset('evolved_homepage_element_five', array('legend'=>Mage::helper('evolved')->__('Page Element 5')));
      $fieldset_page_element_five->addType('elementfive', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Elementfive'));
      $fieldset_page_element_five->addField('elementfivestyle', 'elementfive', array(
      		'name'      => 'elementfivestyle',
      ));
     
      /////-------------------------------------Page Element 6----------------------------------------------////
      $fieldset_page_element_six = $form->addFieldset('evolved_homepage_element_six', array('legend'=>Mage::helper('evolved')->__('Page Element 6')));
      $fieldset_page_element_six->addType('elementsix', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Elementsix'));
      $fieldset_page_element_six->addField('elementsixstyle', 'elementsix', array(
      		'name'      => 'elementsixstyle',
      ));
      
      /////-------------------------------------Page Element 7----------------------------------------------////
      $fieldset_page_element_seven = $form->addFieldset('evolved_homepage_element_seven', array('legend'=>Mage::helper('evolved')->__('Page Element 7')));
      $fieldset_page_element_seven->addType('elementseven', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Elementseven'));
      $fieldset_page_element_seven->addField('elementsevenstyle', 'elementseven', array(
      		'name'      => 'elementsevenstyle',
      ));
      
      /////-------------------------------------Page Element 8----------------------------------------------////
      $fieldset_page_element_eight = $form->addFieldset('evolved_homepage_element_eight', array('legend'=>Mage::helper('evolved')->__('Page Element 8')));
      $fieldset_page_element_eight->addType('elementeight', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Elementeight'));
      $fieldset_page_element_eight->addField('elementeightstyle', 'elementeight', array(
      		'name'      => 'elementeightstyle',
      ));
      
      /////-------------------------------------Page Element 9----------------------------------------------////
      $fieldset_page_element_nine = $form->addFieldset('evolved_homepage_element_nine', array('legend'=>Mage::helper('evolved')->__('Page Element 9')));
      $fieldset_page_element_nine->addType('elementnine', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Elementnine'));
      $fieldset_page_element_nine->addField('elementninestyle', 'elementnine', array(
      		'name'      => 'elementninestyle',
      ));
      
      /////-------------------------------------Page Element 10----------------------------------------------////
      $fieldset_page_element_ten = $form->addFieldset('evolved_homepage_element_ten', array('legend'=>Mage::helper('evolved')->__('Page Element 10')));
      $fieldset_page_element_ten->addType('elementten', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Elementten'));
      $fieldset_page_element_ten->addField('elementtenstyle', 'elementten', array(
      		'name'      => 'elementtenstyle',
      ));
      
      /////-------------------------------------Page Element 11----------------------------------------------////
      $fieldset_page_element_eleven = $form->addFieldset('evolved_homepage_element_eleven', array('legend'=>Mage::helper('evolved')->__('Page Element 11')));
      $fieldset_page_element_eleven->addType('elementeleven', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Elementeleven'));
      $fieldset_page_element_eleven->addField('elementelevenstyle', 'elementeleven', array(
      		'name'      => 'elementelevenstyle',
      ));
      
      /////-------------------------------------Page Element 12----------------------------------------------////
      $fieldset_page_element_twelve = $form->addFieldset('evolved_homepage_element_twelve', array('legend'=>Mage::helper('evolved')->__('Page Element 12')));
      $fieldset_page_element_twelve->addType('elementtwelve', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Elementtwelve'));
      $fieldset_page_element_twelve->addField('elementtwelvestyle', 'elementtwelve', array(
      		'name'      => 'elementtwelvestyle',
      ));
      
      /////-------------------------------------Page Element 13----------------------------------------------////
      $fieldset_page_element_thirteen = $form->addFieldset('evolved_homepage_element_thirteen', array('legend'=>Mage::helper('evolved')->__('Page Element 13')));
      $fieldset_page_element_thirteen->addType('elementthirteen', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Elementthirteen'));
      $fieldset_page_element_thirteen->addField('elementthirteenstyle', 'elementthirteen', array(
      		'name'      => 'elementthirteenstyle',
      ));
      
      /////-------------------------------------Page Element 14----------------------------------------------////
      $fieldset_page_element_fourteen = $form->addFieldset('evolved_homepage_element_fourteen', array('legend'=>Mage::helper('evolved')->__('Page Element 14')));
      $fieldset_page_element_fourteen->addType('elementfourteen', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Elementfourteen'));
      $fieldset_page_element_fourteen->addField('elementfourteenstyle', 'elementfourteen', array(
      		'name'      => 'elementfourteenstyle',
      ));
      
      /////-------------------------------------Page Element 15----------------------------------------------////
      $fieldset_page_element_fourteen = $form->addFieldset('evolved_homepage_element_fifthteen', array('legend'=>Mage::helper('evolved')->__('Page Element 15')));
      $fieldset_page_element_fourteen->addType('elementfifthteen', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Elementfifthteen'));
      $fieldset_page_element_fourteen->addField('elementfifthteenstyle', 'elementfifthteen', array(
      		'name'      => 'elementfifthteenstyle',
      ));
      */
      Mage::getSingleton('core/session')->setBlockName('evolved_homepage');
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