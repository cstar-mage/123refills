<?php 
class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Tab_Contacts extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('evolved_form_contacts', array('legend'=>Mage::helper('evolved')->__('Contact Us')));     
      $fieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
      $fieldset->addType('select_fonts', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Font'));
      
      $fieldset->addType('contactdefaultconfig', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Contacts'));
      $fieldset->addField('contactdefaultconfig', 'contactdefaultconfig', array(
      		'name'      => 'contactdefaultconfig',
      ));
      
      /*$fieldset->addField('contacts_title', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Page Meta Title:'),
      		'name'      => 'contacts_title',
      ));*/
      
      /*$fieldset->addField('contacts_meta_description', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Page Meta Description:'),
      		'name'      => 'contacts_meta_description',
      ));*/
      
      /*$fieldset->addField('contacts_content_address', 'textarea', array(
      		'label'     => Mage::helper('evolved')->__('Contact Addresses:'),
      		'name'      => 'contacts_content_address',
      ));*/
      
      /*$fieldset->addField('contacts_content_address_map', 'textarea', array(
      		'label'     => Mage::helper('evolved')->__('Contact Map (iFrame):'),
      		'name'      => 'contacts_content_address_map',
      ));*/
      
      $fieldset->addField('contacts_custom_captcha', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Captcha Enable:'),
      		'name'      => 'evolved_form_contacts[contacts_custom_captcha]',
      		'options'   => array(
      				'' => Mage::helper('evolved')->__('Please Select'),
      				'1' => Mage::helper('evolved')->__('Yes'),
      				'2' => Mage::helper('evolved')->__('No'),
      		),
      ));
            
	  $fieldset_appointment = $form->addFieldset('evolved_form_contacts_schedule_an_appointment', array('legend'=>Mage::helper('evolved')->__('Schedule An Appointment'))); 
      $fieldset_appointment->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));

      $fieldset_appointment->addField('schedule_an_appointment_enable', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Schedule Appointment Enable:'),
      		'name'      => 'evolved_form_contacts_schedule_an_appointment[schedule_an_appointment_enable]',
      		'options'   => array(
      				'1' => Mage::helper('evolved')->__('Yes'),
      				'0' => Mage::helper('evolved')->__('No'),
      		),
      ));     

	 $fieldset_appointment->addField('appointment_theme_setting', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Theme Setting:'),
      		'name'      => 'evolved_form_contacts_schedule_an_appointment[appointment_theme_setting]',
      		'options'   => array(
      				'lighttheme' => Mage::helper('evolved')->__('Light'),
      				'darktheme' => Mage::helper('evolved')->__('Dark'),
      		),
      ));
	  /*
	  $fieldset_appointment->addField('appointment_loose_diamonds', 'radios', array(
      		'label'     => $this->__('Loose Diamonds'),
      		'name'      => 'appointment_loose_diamonds',
      		'values'    => array(
      				array('value'=>'1','label'=>'Enable'),
      				array('value'=>'0','label'=>'Disable'),
      		),
      ));
      
      $fieldset_appointment->addField('appointment_engagement_rings', 'radios', array(
      		'label'     => $this->__('Engagement Rings'),
      		'name'      => 'appointment_engagement_rings',
      		'values'    => array(
      				array('value'=>'1','label'=>'Enable'),
      				array('value'=>'0','label'=>'Disable'),
      		),
      ));

      $fieldset_appointment->addField('appointment_wedding_bands', 'radios', array(
      		'label'     => $this->__('Wedding Bands'),
      		'name'      => 'appointment_wedding_bands',
      		'values'    => array(
      				array('value'=>'1','label'=>'Enable'),
      				array('value'=>'0','label'=>'Disable'),
      		),
      ));
      
      $fieldset_appointment->addField('appointment_custom_fine_jewelry', 'radios', array(
      		'label'     => $this->__('Custom Fine Jewelry'),
      		'name'      => 'appointment_custom_fine_jewelry',
      		'values'    => array(
      				array('value'=>'1','label'=>'Enable'),
      				array('value'=>'0','label'=>'Disable'),
      		),
      ));
      
      $fieldset_appointment->addField('appointment_other', 'radios', array(
      		'label'     => $this->__('Other'),
      		'name'      => 'appointment_other',
      		'values'    => array(
      				array('value'=>'1','label'=>'Enable'),
      				array('value'=>'0','label'=>'Disable'),
      		),
      ));
      */
      $fieldset_appointment->addField('appointment_category', 'multiselect', array(
      		'name' => 'evolved_form_contacts_schedule_an_appointment[appointment_category]',
      		'label' => Mage::helper('evolved')->__('Appointment Types:'),
      		'values' => Mage::getModel('evolved/category')->toCategoryOptionArray(),
      ));
      
      $fieldset_appointment->addField('appointment_contact_no', 'text', array(
      		'label'     => $this->__('Appointment Contact Number'),
      		'name'      => 'evolved_form_contacts_schedule_an_appointment[appointment_contact_no]',
      ));
      
      $advancedfieldset = $form->addFieldset('evolved_form_contacts_advancedsetting', array('legend'=>Mage::helper('evolved')->__('Advanced Setting')));
      $advancedfieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
      $advancedfieldset->addType('select_fonts', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Font'));
      
      $advancedfieldset->addField('contacts_title_font', 'select_fonts', array(
      		'label'     => Mage::helper('evolved')->__('Title - Font:'),
      		'name'      => 'evolved_form_contacts_advancedsetting[contacts_title_font]',
      		'values' => Mage::getModel('evolved/Font')->toOptionArray(),
      ));
      
      $advancedfieldset->addField('contacts_title_fontcolor', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Title - Color:'),
      		'name'      => 'evolved_form_contacts_advancedsetting[contacts_title_fontcolor]',
      ));
      
      $advancedfieldset->addField('contacts_title_size', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Title - Size:'),
      		'name'      => 'evolved_form_contacts_advancedsetting[contacts_title_size]',
      ));
      
      $advancedfieldset->addField('contacts_title_texttransform', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Title - Transform'),
      		'name'      => 'evolved_form_contacts_advancedsetting[contacts_title_texttransform]',
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
      
      $advancedfieldset->addField('contacts_title_style', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Title - Style'),
      		'name'      => 'evolved_form_contacts_advancedsetting[contacts_title_style]',
      		'values'    => array(
      				array('value'=>'','label'=>'Please Select'),
      				array('value'=>'normal','label'=>'normal'),
      				array('value'=>'italic','label'=>'italic'),
      				array('value'=>'oblique','label'=>'oblique'),
      				array('value'=>'initial','label'=>'initial'),
      				array('value'=>'inherit','label'=>'inherit'),
      		),
      ));
      
      $advancedfieldset->addField('contacts_title_weight', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Title - Weight'),
      		'name'      => 'evolved_form_contacts_advancedsetting[contacts_title_weight]',
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
      
      $advancedfieldset->addField('contacts_content_font', 'select_fonts', array(
      		'label'     => Mage::helper('evolved')->__('Content - Font:'),
      		'name'      => 'evolved_form_contacts_advancedsetting[contacts_content_font]',
      		'values' => Mage::getModel('evolved/Font')->toOptionArray(),
      ));
      
      $advancedfieldset->addField('contacts_content_fontcolor', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Content - Color:'),
      		'name'      => 'evolved_form_contacts_advancedsetting[contacts_content_fontcolor]',
      ));
      
     /* $advancedfieldset->addField('contacts_appointment_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Appointment Button Background:'),
      		'name'      => 'contacts_appointment_background',
      ));
      
      $advancedfieldset->addField('contacts_appointment_font', 'select_fonts', array(
      		'label'     => Mage::helper('evolved')->__('Appointment Button Font Family:'),
      		'name'      => 'contacts_appointment_font',
      		'values' => Mage::getModel('evolved/Font')->toOptionArray(),
      ));
      
      $advancedfieldset->addField('contacts_appointment_fontcolor', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Appointment Button Font Color:'),
      		'name'      => 'contacts_appointment_fontcolor',
      ));*/
      Mage::getSingleton('core/session')->setBlockName('evolved_contacts');
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