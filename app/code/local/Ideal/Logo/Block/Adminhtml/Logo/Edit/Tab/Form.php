<?php

class Ideal_Logo_Block_Adminhtml_Logo_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('logo_form', array('legend'=>Mage::helper('logo')->__('Insert Logo')));
     
      $fieldset->addField('design_header_logo_alt', 'text', array(
          'label'     => Mage::helper('logo')->__('Logo Image Alt'),
          'name'      => 'design_header_logo_alt',
      	  'value'     => Mage::getStoreConfig('design/header/logo_alt')
      ));

      $fieldset->addField('design_header_logo_src', 'file', array(
          'label'     => Mage::helper('logo')->__('Logo Image File'),
          'required'  => false,
          'name'      => 'design_header_logo_src',
	  ));
	

      $logoImg = Mage::getStoreConfig('design/header/logo_src'); 
      $filename = Mage::getDesign()->getSkinUrl($logoImg,array('_area'=>'frontend','_package'=>'evolved','_theme'=>'default'));      
      
      if($logoImg) {
      	$fieldset->addField('img', 'note', array(
      			'label'	=> 'Current Logo',
      			'required' => false,
      			'text' => '<img src="'.$filename.'"/>'
      	));
      }
      
      $fieldset->addField('design_header_logo_src_small', 'file', array(
      		'label'     => Mage::helper('logo')->__('Small Logo Image File'),
      		'required'  => false,
      		'name'      => 'design_header_logo_src_small',
      ));
      
      
      $slogoImg = Mage::getStoreConfig('design/header/logo_src_small');
      $sfilename = Mage::getDesign()->getSkinUrl($slogoImg,array('_area'=>'frontend','_package'=>'evolved','_theme'=>'default'));
      
      if($slogoImg) {
      	$fieldset->addField('small_img', 'note', array(
      			'label'	=> 'Current Small Logo',
      			'required' => false,
      			'text' => '<img src="'.$sfilename.'"/>'
      	));
      }
      
      $fieldset->addField('design_head_shortcut_icon', 'image', array(
      		'label'     => Mage::helper('logo')->__('Favicon Icon'),
      		'required'  => false,
      		'name'      => 'design_head_shortcut_icon',
      		'value'      => "favicon/".Mage::getStoreConfig('design/head/shortcut_icon')
      ));
      
      $fieldset1 = $form->addFieldset('emaillogo_form', array('legend'=>Mage::helper('logo')->__('Insert Email Logo')));

      $fieldset1->addField('email_logo_alt', 'text', array(
      		'label'     => Mage::helper('logo')->__('Email Logo Image Alt'),
      		'name'      => 'email_logo_alt',
      		'value'     => Mage::getStoreConfig('design/email/logo_alt')
      ));
      
      $fieldset1->addField('email_logo_src', 'file', array(
      		'label'     => Mage::helper('logo')->__('Email Logo Image File'),
      		'required'  => false,
      		'name'      => 'email_logo_src',
      ));
      
      $Email_logoImg = Mage::getStoreConfig('design/email/logo');
      $Emailfilename = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'/email/logo/'.$Email_logoImg;
      
     if($Email_logoImg) {
      	$fieldset1->addField('img1', 'note', array(
      			'label'	=> 'Current Email Logo',
      			'required' => false,
      			'text' => '<img src="'.$Emailfilename.'" width="100"/>'
      	));
      }
      
      $fieldset2 = $form->addFieldset('palceholderlogo_form', array('legend'=>Mage::helper('logo')->__('Insert Product Image Placeholders')));
      
      $fieldset2->addField('baseimg_placeholder_src', 'file', array(
      		'label'     => Mage::helper('logo')->__('Base Image'),
      		'required'  => false,
      		'name'      => 'baseimg_placeholder_src',
      ));
      
      $bimg_logoImg = Mage::getStoreConfig('catalog/placeholder/image_placeholder');
      $bimgfilename = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'/catalog/product/placeholder/'.$bimg_logoImg;
      
      if($bimg_logoImg) {
      	$fieldset2->addField('img2', 'note', array(
      			'label'	=> 'Current Base Image',
      			'required' => false,
      			'text' => '<img src="'.$bimgfilename.'" width="50" height="50"/>'
      	));
      }
      
      
      $fieldset2->addField('smallimage_placeholder_src', 'file', array(
      		'label'     => Mage::helper('logo')->__('Small Image Image'),
      		'required'  => false,
      		'name'      => 'smallimage_placeholder_src',
      ));
      
      $simg_logoImg = Mage::getStoreConfig('catalog/placeholder/small_image_placeholder');
      $simgfilename = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'/catalog/product/placeholder/'.$simg_logoImg;
      
      if($simg_logoImg) {
      	$fieldset2->addField('img3', 'note', array(
      			'label'	=> 'Current Small Image',
      			'required' => false,
      			'text' => '<img src="'.$simgfilename.'" width="50" height="50"/>'
      	));
      }
      
      $fieldset2->addField('thumbnail_placeholder_src', 'file', array(
      		'label'     => Mage::helper('logo')->__('Thumbnail'),
      		'required'  => false,
      		'name'      => 'thumbnail_placeholder_src',
      ));
      
      $timg_logoImg = Mage::getStoreConfig('catalog/placeholder/thumbnail_placeholder');
      $timgfilename = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'/catalog/product/placeholder/'.$timg_logoImg;
      
      if($timg_logoImg) {
      	$fieldset2->addField('img4', 'note', array(
      			'label'	=> 'Current Thumbnail Image',
      			'required' => false,
      			'text' => '<img src="'.$timgfilename.'" width="50" height="50"/>'
      	));
      }
      
      
      return parent::_prepareForm();
  }
}
