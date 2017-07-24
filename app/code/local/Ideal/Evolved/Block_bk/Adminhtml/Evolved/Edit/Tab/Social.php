<?php $theme = Mage::helper('evolved')->getThemeConfig(); 
//echo $theme['social_icons_size']; exit;
if($theme['social_color_deg']=="")
{
	$theme['social_color_deg'] = 0;
}
if($theme['social_color_saturate_deg']=="")
{
	$theme['social_color_saturate_deg'] = 1;
}
if($theme['social_color_brightness_deg']=="")
{
	$theme['social_color_brightness_deg'] = 1;
}
?>
<script>
var jq = jQuery.noConflict();
jq(window).load(function(){
	  var socialdefault = 1;
	  jq( "#evolved_form_social #slider" ).slider({			
          value: (<?php echo json_encode($theme['social_color_deg']); ?>*10)/36,
		  slide: function( event, ui ) { 
			  jq("#social_icons_theme_image").css("-webkit-filter","hue-rotate("+(3.6 * ui.value)+"deg) saturate("+jq("#social_color_saturate_deg").val()+")");
			  jq("#social_icons_theme_image").css("filter","hue-rotate("+(3.6 * ui.value)+"deg) saturate("+jq("#social_color_saturate_deg").val()+")");
			  jq("#social_color_deg").val((3.6 * ui.value));
			  }
	  });

	  jq( "#evolved_form_social #social_color_saturate_slider" ).slider({			
          value: (<?php echo json_encode($theme['social_color_saturate_deg']); ?>)*100,
		  slide: function( event, ui ) { 
			  jq("#social_icons_theme_image").css("-webkit-filter","saturate("+((ui.value)/100)+") hue-rotate("+ jq("#social_color_deg").val() +"deg)");
			  jq("#social_icons_theme_image").css("filter","saturate("+((ui.value)/100)+") hue-rotate("+ jq("#social_color_deg").val() +"deg)");
			  jq("#social_color_saturate_deg").val((ui.value)/100);
			  }
	  });

	  jq( "#evolved_form_social #social_color_brightness_slider" ).slider({			
          value: (<?php echo json_encode($theme['social_color_brightness_deg']); ?>)*100,
		  slide: function( event, ui ) { 
			  jq("#social_icons_theme_image").css("-webkit-filter","brightness("+((ui.value)/100)+") hue-rotate("+ jq("#social_color_deg").val() +"deg) saturate("+jq("#social_color_saturate_deg").val()+")");
			  jq("#social_icons_theme_image").css("filter","brightness("+((ui.value)/100)+") hue-rotate("+ jq("#social_color_deg").val() +"deg) saturate("+jq("#social_color_saturate_deg").val()+")");
			  jq("#social_color_brightness_deg").val((ui.value)/100);
			  }
	  });

	  jq('#social_icons_theme').change(function(){
    	  var socialtheme = jq("#social_icons_theme option[value='"+jq(this).val()+"']").text();
    	  if((socialtheme == "Theme 1") || (socialtheme == "Theme 2") || (socialtheme == "Theme 3") || (socialtheme == "Theme 8") || (socialtheme == "Theme 9") || (socialtheme == "Theme 10"))
    	  { 
    		  jq(".socialcolorrow.huerotateslider").css("display","none");
    		  jq( "#evolved_form_social #social_color_saturate_slider" ).slider({			
		          value: 100,
			  });
			  jq( "#evolved_form_social #social_color_brightness_slider" ).slider({			
		          value: 100,
			  });
    		  jq("#social_color_deg").val(0);
    		  jq("#social_color_saturate_deg").val(1);
    		  jq("#social_color_brightness_deg").val(1);
    		  jq("#social_icons_theme_image").css("-webkit-filter","hue-rotate(0deg) saturate(1) brightness(1)");
    		  jq("#social_icons_theme_image").css("filter","hue-rotate(0deg) saturate(1) brightness(1)");
    	  }
    	  else
    	  { 

        	  jq(".socialcolorrow").css("display","table-row"); 
    		  if(socialdefault==0)
    		  { 
    			  jq( "#evolved_form_social #slider" ).slider({			
    		          value: 0,
    			  });
    			  jq( "#evolved_form_social #social_color_saturate_slider" ).slider({			
    		          value: 100,
    			  });
    			  jq( "#evolved_form_social #social_color_brightness_slider" ).slider({			
    		          value: 100,
    			  });
        		  jq("#social_icons_theme_image").css("-webkit-filter","hue-rotate(0deg) saturate(1) brightness(1)");
        		  jq("#social_icons_theme_image").css("filter","hue-rotate(0deg) saturate(1) brightness(1)");
    			  jq("#social_color_deg").val(0);
    			  jq("#social_color_saturate_deg").val(1);
    			  jq("#social_color_brightness_deg").val(1);
    		  }
    	  }
		  if(this.value != "")
		  {
				jq("#social_icons_theme_image").css("display","block");
		  }
		  socialdefault = 0;
      });
      
	  jq('#evolved_form_social input[name="social_icons_size"]').click(function() {
				jq("#social_icons_theme").html('<option value="">Please Select</option>');
			for(var i=1; i<=13; i++)
			{
				jq("#social_icons_theme").append('<option value="'+this.value+'/theme'+i+'_'+this.value+'.png">Theme '+i+'</option>');
			}
		});

		if(!jq('#evolved_form_social input[name="social_icons_size"]').is(':checked')) 
		{ jq('input[name="social_icons_size"]#social_icons_size16').click(); }
		else
		{
			var selecttheme = <?php echo json_encode($theme['social_icons_theme']); ?>;
			jq("#social_icons_theme").html('<option value="">Please Select</option>');
			for(var i=1; i<=13; i++)
			{
				var optionvalue = <?php echo json_encode($theme['social_icons_size']); ?>+'/theme'+i+'_'+<?php echo json_encode($theme['social_icons_size']); ?>+'.png';
				//alert(optionvalue);
				if(selecttheme == optionvalue)
				{
					jq("#social_icons_theme").append('<option value="'+optionvalue+'" selected>Theme '+i+'</option>');
				}
				else
				{
					jq("#social_icons_theme").append('<option value="'+optionvalue+'">Theme '+i+'</option>');
				}
			}
		}

			if(<?php echo json_encode($theme['social_color_deg']); ?> == null)
			{
				jq("#social_icons_theme_image").css("display","none");
			}
		  jq('#social_icons_theme').change();
		  jq("#social_icons_theme_image").css("-webkit-filter","hue-rotate("+(<?php echo json_encode($theme['social_color_deg']); ?>)+"deg) saturate("+(<?php echo json_encode($theme['social_color_saturate_deg']); ?>)+") brightness("+(<?php echo json_encode($theme['social_color_brightness_deg']); ?>)+")");
		  jq("#social_icons_theme_image").css("filter","hue-rotate("+(<?php echo json_encode($theme['social_color_deg']); ?>)+"deg) saturate("+(<?php echo json_encode($theme['social_color_saturate_deg']); ?>)+") brightness("+(<?php echo json_encode($theme['social_color_brightness_deg']); ?>)+")");
});
</script>
<?php
class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Tab_Social extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('evolved_form_social', array('legend'=>Mage::helper('evolved')->__('Social')));
     
      $theme = Mage::helper('evolved')->getThemeConfig();
      $social_icons_theme_path = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . "evolved" . DS . "social" . DS; 
      $social_icons_theme =  $social_icons_theme_path. $theme['social_icons_theme'];
      
      $fieldset->addField('social_icons_size', 'radios', array(
      		'label'     => Mage::helper('evolved')->__('Icon size'),
      		'name'      => 'social_icons_size',
      		'values' => array(
      				array('value'=>'16','label'=>'16px'),
      				array('value'=>'24','label'=>'24px'),
      				array('value'=>'32','label'=>'32px'),
      				array('value'=>'48','label'=>'48px'),
      		),
      		'disabled' => false,
      		'readonly' => false,
      		'tabindex' => 1,
      ));
      
      $fieldset->addField('social_icons_theme', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Social Icons Theme:'),
      		'name'      => 'social_icons_theme',
      		'onchange'      => 'showTheme(this)',
      		'options'   => array(
      				$themearr
      		),
      		'value'   => $theme['social_icons_theme'],
      		'after_element_html' => '<img id="social_icons_theme_image" src="'.$social_icons_theme.'" height="auto" width="auto" style="margin-top: 5px;" />
      									<script>function showTheme(element) { 
      												$("social_icons_theme_image").src = "'.$social_icons_theme_path.'" + element.value; 
 												}
      									</script>',
      ));
      
      $fieldset->addType('socialcolor', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Socialcolor'));
      $fieldset->addField('social_color_scroll', 'socialcolor', array(
      		'name'      => 'social_color_scroll',
      ));
      
      $fieldset->addField('social_facebook_url', 'text', array(
          'label'     => Mage::helper('evolved')->__('Facebook URL'),
          'name'      => 'social_facebook_url',
      ));
      
      $fieldset->addField('social_twitter_url', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Twitter URL'),
      		'name'      => 'social_twitter_url',
      ));
      
      $fieldset->addField('social_pinterest_url', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Pinterest URL'),
      		'name'      => 'social_pinterest_url',
      ));
      
      $fieldset->addField('social_instagram_url', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Instagram URL'),
      		'name'      => 'social_instagram_url',
      ));
      
      $fieldset->addField('social_foursquare_url', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Foursquare URL'),
      		'name'      => 'social_foursquare_url',
      ));
      
      $fieldset->addField('social_fancy_url', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Fancy URL'),
      		'name'      => 'social_fancy_url',
      ));
      
      $fieldset->addField('social_polyvore_url', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Polyvore URL'),
      		'name'      => 'social_polyvore_url',
      ));
      
      $fieldset->addField('social_yelp_url', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Yelp URL'),
      		'name'      => 'social_yelp_url',
      ));
      
      $fieldset->addField('social_youtube_url', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Youtube URL'),
      		'name'      => 'social_youtube_url',
      ));
      
      $fieldset->addField('social_gplus_url', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Google Plus URL'),
      		'name'      => 'social_gplus_url',
      ));
      
      $fieldset->addField('social_linkedin_url', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Linked In URL'),
      		'name'      => 'social_linkedin_url',
      ));
      
      $fieldset->addField('social_tumbler_url', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Tumbler URL'),
      		'name'      => 'social_tumbler_url',
      ));

      Mage::getSingleton('core/session')->setBlockName('evolved_social');
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