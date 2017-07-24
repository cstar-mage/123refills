<?php

class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Tab_Newsletter extends Mage_Adminhtml_Block_Widget_Form
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
      $fieldsetnewsletter = $form->addFieldset('evolved_form_newsletter', array('legend'=>Mage::helper('evolved')->__('Newsletter')));
     $fieldsetnewsletter->addField('newsletter_popup_enable', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Popup enable:'),
      		'name'      => 'newsletter_popup_enable',
      		'options'   => array(
      				'on' => Mage::helper('evolved')->__('On'),
      				'off' => Mage::helper('evolved')->__('Off'),
      		),
      ));
     
     $fieldsetnewsletter->addField('newsletter_subscribe_theme_enable', 'select', array(
     		'label'     => Mage::helper('evolved')->__('Subscribe enable:'),
     		'name'      => 'newsletter_subscribe_theme_enable',
     		'options'   => array(
     				'' => Mage::helper('evolved')->__('Please Select'),
     				'desktop' => Mage::helper('evolved')->__('Desktop'),
     				'mobile' => Mage::helper('evolved')->__('Mobile'),
     				'both' => Mage::helper('evolved')->__('Both'),
     		),
     ));
     
     $fieldsetnewsletter->addField('newsletter_popup_theme', 'select', array(
     		'label'     => Mage::helper('evolved')->__('Popup Theme enable:'),
     		'name'      => 'newsletter_popup_theme',
     		'options'   => array(
     				'' => Mage::helper('evolved')->__('Please Select'),
     				'newsletterlighttheme' => Mage::helper('evolved')->__('Light'),
     				'newsletterdarktheme' => Mage::helper('evolved')->__('Dark'),
     		),
     ));
     
     $fieldsetnewsletter->addField('newsletter_popup_title', 'text', array(
     		'label'     => Mage::helper('evolved')->__('Title:'),
     		'name'      => 'newsletter_popup_title',
     ));
     
     $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config');
     $fieldsetnewsletter->addField('newsletter_popup_description', 'editor', array(
     		'label'     => Mage::helper('evolved')->__('Description:'),
     		'name'      => 'newsletter_popup_description',
     		'config'    => $configSettings,
     ));
     /*$fieldsetnewsletter->addField('couponid', 'hidden', array(
     		'label'     => Mage::helper('evolved')->__('Coupon Id:'),
     		'name'      => 'couponid',
     ));
     
     $fieldsetnewsletter->addField('newsletter_coupon_name', 'text', array(
     		'label'     => Mage::helper('evolved')->__('Coupon Name:'),
     		'name'      => 'newsletter_coupon_name',
     ));
     
     $fieldsetnewsletter->addField('newsletter_coupon_description', 'textarea', array(
     		'label'     => Mage::helper('evolved')->__('Coupon Description:'),
     		'name'      => 'newsletter_coupon_description',
     ));*/
      
      $fieldsetnewsletter->addField('newsletter_coupon_code', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Coupon Code:'),
      		'name'      => 'newsletter_coupon_code',
      ));
      /*
      $fieldsetnewsletter->addField('newsletter_coupon_code_uses_per_coupon', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Uses per Coupon:'),
      		'name'      => 'newsletter_coupon_code_uses_per_coupon',
      ));
      
      $fieldsetnewsletter->addField('newsletter_coupon_code_uses_per_customer', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Uses per Customer:'),
      		'name'      => 'newsletter_coupon_code_uses_per_customer',
      ));
      
      $fieldsetnewsletter->addField('newsletter_coupon_code_enable', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Coupon code active:'),
      		'name'      => 'newsletter_coupon_code_enable',
      		'options'   => array(
      				'1' => Mage::helper('evolved')->__('Active'),
      				'0' => Mage::helper('evolved')->__('Inactive'),
      		),
      ));
     */
      $fieldsetnewsletter->addField('newsletter_coupon_date_from', 'date', array(
      		'name'               => 'newsletter_coupon_date_from',
      		'label'              => Mage::helper('evolved')->__('Start Date:'),
      		//'after_element_html' => '<small>Comments</small>',
      		'tabindex'           => 1,
      		'image'              => $this->getSkinUrl('images/grid-cal.gif'),
      		'format'             => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT) ,
      		'value'              => date( Mage::app()->getLocale()->getDateStrFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),strtotime('next weekday') )
      ));
      
      $fieldsetnewsletter->addField('newsletter_coupon_date_to', 'date', array(
      		'name'               => 'newsletter_coupon_date_to',
      		'label'              => Mage::helper('evolved')->__('End Date:'),
      		//'after_element_html' => '<small>Comments</small>',
      		'tabindex'           => 1,
      		'image'              => $this->getSkinUrl('images/grid-cal.gif'),
      		'format'             => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT) ,
      		'value'              => date( Mage::app()->getLocale()->getDateStrFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),strtotime('next weekday') )
      ));
      /*
      $fieldsetnewsletter->addField('coupon_discount_amount', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Coupon discount amount:'),
      		'name'      => 'coupon_discount_amount',
      ));
      
      $fieldsetnewsletter->addField('coupon_discount_on_subtotal', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Condition on subtotal above:'),
      		'name'      => 'coupon_discount_on_subtotal',
      ));
      */
      
      $fieldsetnewsletter->addField('newsletter_background_image_desktop', 'image', array(
      		'label'     => Mage::helper('evolved')->__('Background image, desktop version:'),
      		'name'      => 'newsletter_background_image_desktop',
      		'after_element_html' => '<br /> <small><b> Pixel Size (830px * 390px)</b></small>',
      ));
      
      $fieldsetnewsletter->addField('newsletter_background_image_mobile', 'image', array(
      		'label'     => Mage::helper('evolved')->__('Background image, mobile:'),
      		'name'      => 'newsletter_background_image_mobile',
      		'after_element_html' => '<br /> <small><b> Pixel Size (490px * 330px)</b></small>',
      ));
      
      Mage::getSingleton('core/session')->setBlockName('evolved_newsletter');
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