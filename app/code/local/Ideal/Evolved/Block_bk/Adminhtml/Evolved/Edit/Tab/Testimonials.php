<?php 
class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Tab_Testimonials extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
     
      $fieldset_testimonials = $form->addFieldset('evolved_homepage_testimonials', array('legend'=>Mage::helper('evolved')->__('Testimonials Page')));
//      $fieldset_testimonials->addType('testimonials', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Testimonials'));
      $fieldset_testimonials->addType('testimonialscurrentimage', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Testimonialscurrentimage'));
      $fieldset_testimonials->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
      
      $fieldset_testimonials->addField('testimonials_element_style', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Page Style:'),
      		'name'      => 'testimonials_element_style',
      		'options'   => array(
      				'' => Mage::helper('evolved')->__('Select Page Element Style'),
      				'testimonials_element_style_one_one_column' => Mage::helper('evolved')->__('1-column'),
      				'testimonials_element_style_two_two_column_with_50_by_50' => Mage::helper('evolved')->__('2-column'),
      		),
      		//'onchange' => "selecttestimonialselementstyle(this.value)",
      ))
      ->setAfterElementHtml("<div class='tooltip_element_main'></div>
      		<script type=\"text/javascript\">
	      		function selecttestimonialselementstyle(style)
      			{
      				//alert(style);
      				jQuery('#evolved_homepage_testimonials .testimonialsmaintable').css('display','none');
      		      	jQuery('#evolved_homepage_testimonials #' + style).css('display','block');
					 whatspopup(style);
      			}
      		</script>
      	");
      
      $fieldset_testimonials->addField('testimonials_page_title', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Page Title:'),
      		'name'      => 'testimonials_page_title',
      ));
      
      $fieldset_testimonials->addField('testimonials_page_sub_title', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Page Sub-Title:'),
      		'name'      => 'testimonials_page_sub_title',
      ));
      
      $fieldset_testimonials->addField('testimonials_page_upload_banner', 'image', array(
      		'label'     => Mage::helper('evolved')->__('Upload Banner:'),
      		'name'      => 'testimonials_page_upload_banner',
      ));

      /*$fieldset_testimonials->addField('testimonials', 'testimonials', array(
      		'name'      => 'testimonials',
      ));*/
      
      $fieldset_testimonials->addField('testimonialscurrentimage', 'testimonialscurrentimage', array(
      		'name'      => 'testimonialscurrentimage',
      ));
      
      $fieldset_testimonials->addField('testimonials_review_border_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, border:'),
      		'name'      => 'testimonials_review_border_color',
      ));
      
      $fieldset_testimonials->addField('testimonials_namelocation_reviewer_text_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Color, text, name/location of reviewer:'),
      		'name'      => 'testimonials_namelocation_reviewer_text_color',
      ));
      
	
      Mage::getSingleton('core/session')->setBlockName('evolved_testimonials');
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