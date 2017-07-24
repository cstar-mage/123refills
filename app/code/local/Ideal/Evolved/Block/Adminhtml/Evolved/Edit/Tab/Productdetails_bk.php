<?php

class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Tab_Productdetails extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('evolved_form_productdetails', array('legend'=>Mage::helper('evolved')->__('Product Details')));
     
      $fieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
      
      $fieldset->addField('productdetails_title_color', 'colorpicker', array(
          'label'     => Mage::helper('evolved')->__('Title color:'),
          'name'      => 'productdetails_title_color',
      ));
      
      $fieldset->addField('productdetails_text_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Text color:'),
      		'name'      => 'productdetails_text_color',
      ));
      
      $fieldset->addField('productdetails_link_background_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Link background color:'),
      		'name'      => 'productdetails_link_background_color',
      ));
      
      $fieldset->addField('productdetails_link_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Link color:'),
      		'name'      => 'productdetails_link_color',
      ));
      
      $fieldset->addField('productdetails_linkhover_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Link hover background color:'),
      		'name'      => 'productdetails_linkhover_background',
      ));
      
      $fieldset->addField('productdetails_linkhover_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Link hover color:'),
      		'name'      => 'productdetails_linkhover_color',
      ));
      
      /* Price */
      
      $fieldset->addField('productdetails_price_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Price color:'),
      		'name'      => 'productdetails_price_color',
      ));
      
      $fieldset->addField('productdetails_oldprice_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Old Price color:'),
      		'name'      => 'productdetails_oldprice_color',
      ));
      
      $fieldset->addField('productdetails_price_textcolor', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Price Text color:'),
      		'name'      => 'productdetails_price_textcolor',
      		'note' => Mage::helper('evolved')->__('Text in price block ( As low, From, To )'),
      ));
      
      $fieldset->addField('productdetails_attribute_odd_background_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Attribute odd background color:'),
      		'name'      => 'productdetails_attribute_odd_background_color',
      ));
      
      $fieldset->addField('productdetails_attribute_odd_text_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Attribute odd text color:'),
      		'name'      => 'productdetails_attribute_odd_text_color',
      ));
      
      $fieldset->addField('productdetails_attribute_even_background_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Attribute even background color:'),
      		'name'      => 'productdetails_attribute_even_background_color',
      ));
      
      $fieldset->addField('productdetails_attribute_even_text_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Attribute even text color:'),
      		'name'      => 'productdetails_attribute_even_text_color',
      ));
      
      $fieldset->addField('productdetails_attribute_border_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Attribute border color:'),
      		'name'      => 'productdetails_attribute_border_color',
      ));
      
      $fieldset->addField('productdetails_attribute_fontsize', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Attribute font size:'),
      		'name'      => 'productdetails_attribute_fontsize',
      ));
      
      /*  Tab Heading */
      $fieldset->addField('productdetails_tabhead_textcolor', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Tab text color:'),
      		'name'      => 'productdetails_tabhead_textcolor',
      ));
      
      $fieldset->addField('productdetails_tabhead_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Tab background color:'),
      		'name'      => 'productdetails_tabhead_background',
      ));
      
      $fieldset->addField('productdetails_tabhead_border_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Tab border color:'),
      		'name'      => 'productdetails_tabhead_border_color',
      ));
      
      $fieldset->addField('productdetails_tabhead_texthover_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Tab text hover color:'),
      		'name'      => 'productdetails_tabhead_texthover_color',
      ));
      
      $fieldset->addField('productdetails_tabhead_hover_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Tab background hover color:'),
      		'name'      => 'productdetails_tabhead_hover_background',
      ));
      
      $fieldset->addField('productdetails_active_tabhead_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Active Tab background color:'),
      		'name'      => 'productdetails_active_tabhead_background',
      ));
      
      $fieldset->addField('productdetails_active_tabhead_hover_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Active Tab hover background color:'),
      		'name'      => 'productdetails_active_tabhead_hover_background',
      ));
      
      $fieldset->addField('productdetails_active_tabhead_text_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Active Tab text color:'),
      		'name'      => 'productdetails_active_tabhead_text_color',
      ));
      
      $fieldset->addField('productdetails_active_tabhead_hover_text_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Active Tab text hover color:'),
      		'name'      => 'productdetails_active_tabhead_hover_text_color',
      ));
      /* Tab Content */
      
      $fieldset->addField('productdetails_tab_enable', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Product tab enable option:'),
      		'name'      => 'productdetails_tab_enable',
      		'options'   => array(
      				'yes' => Mage::helper('evolved')->__('Yes'),
      				'no' => Mage::helper('evolved')->__('No'),
      		),
      ));
      
      $fieldset->addField('productdetails_tabcontent_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Background color:'),
      		'name'      => 'productdetails_tabcontent_background',
      ));
      
      $fieldset->addField('productdetails_tabcontent_border_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Tab border color:'),
      		'name'      => 'productdetails_tabcontent_border_color',
      ));
      
      $fieldset->addField('productdetails_tabcontent_textcolor', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Text color:'),
      		'name'      => 'productdetails_tabcontent_textcolor',
      ));
      
      $fieldset->addField('productdetails_tabcontent_link_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Link background color:'),
      		'name'      => 'productdetails_tabcontent_link_background',
      ));
      
      $fieldset->addField('productdetails_tabcontent_link_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Link color:'),
      		'name'      => 'productdetails_tabcontent_link_color',
      ));
      
      $fieldset->addField('productdetails_tabcontent_linkhover_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Link hover background color:'),
      		'name'      => 'productdetails_tabcontent_linkhover_background',
      ));
      
      $fieldset->addField('productdetails_tabcontent_linkhover_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Link hover color:'),
      		'name'      => 'productdetails_tabcontent_linkhover_color',
      ));
      
      $fieldset->addField('productdetails_attribute_table_heading_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Attribute table heading background:'),
      		'name'      => 'productdetails_attribute_table_heading_background',
      ));
      
      $fieldset->addField('productdetails_tab_attribute_option', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Product attribute tab option:'),
      		'name'      => 'productdetails_tab_attribute_option',
      		'options'   => array(
      				'inside' => Mage::helper('evolved')->__('Inside'),
      				'outside' => Mage::helper('evolved')->__('Outside'),
      		),
      ));
      
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
      		'label'     => Mage::helper('evolved')->__('Disable Zoom:'),
      		'name'      => 'productdetails_zoom_disabled',
      		'options'   => array(
      				'false' => Mage::helper('evolved')->__('No'),
      				'true' => Mage::helper('evolved')->__('Yes'),
      		),
      ));
      
      $fieldsetZoom->addField('productdetails_zoom_expand_disabled', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Disable Expand (Popup):'),
      		'name'      => 'productdetails_zoom_expand_disabled',
      		'options'   => array(
      				'false' => Mage::helper('evolved')->__('No'),
      				'true' => Mage::helper('evolved')->__('Yes'),
      		),
      ));
      
      $fieldsetZoom->addField('productdetails_zoom_width', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Zoom width in pixels:'),
      		'name'      => 'productdetails_zoom_width',
      ));
      
      $fieldsetZoom->addField('productdetails_zoom_height', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Zoom height in pixels:'),
      		'name'      => 'productdetails_zoom_height',
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
      
      $fieldsetZoom->addField('productdetails_zoom_align', 'select', array(
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