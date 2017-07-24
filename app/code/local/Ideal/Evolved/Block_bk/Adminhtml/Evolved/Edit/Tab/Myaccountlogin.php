<?php

class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Tab_Myaccountlogin extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('evolved_form_login', array('legend'=>Mage::helper('evolved')->__('Login Page')));
      
      $configSettings = Mage::getSingleton('cms/wysiwyg_config')->getConfig(
      		array(
      				'add_images' => true,
      				'add_widgets' => true,
      				'add_variables' => true,
      				'files_browser_window_url'=> Mage::helper("adminhtml")->getUrl("adminhtml/cms_wysiwyg_images/index"),
      		));
      
      $fieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
     
      $fieldset->addField('login_text', 'text', array(
      		'label'     => Mage::helper('logo')->__('Main Title'),
      		'name'      => 'login_text',
      ));
      
      $fieldset->addField('login_left_title', 'text', array(
      		'label'     => Mage::helper('logo')->__('Left Title'),
      		'name'      => 'login_left_title',
      ));
      
      $fieldset->addField('login_right_title', 'text', array(
      		'label'     => Mage::helper('logo')->__('Right Title'),
      		'name'      => 'login_right_title',
      ));
      
      $fieldset->addField('login_left_content', 'editor', array(
      		'label'     => Mage::helper('logo')->__('Left Content'),
      		'name'      => 'login_left_content',
      		'config'    => $configSettings,
      ));
      
      $fieldset->addField('login_right_content', 'editor', array(
      		'label'     => Mage::helper('logo')->__('Right Content'),
      		'name'      => 'login_right_content',
      		'config'    => $configSettings,
      ));
      
      $fieldset->addField('login_background_color', 'colorpicker', array(
          'label'     => Mage::helper('evolved')->__('Color, background:'),
          'name'      => 'login_background_color',
      ));
      
      $fieldset->addField('login_background_image', 'image', array(
      		'label'     => Mage::helper('logo')->__('Image, background (optional)'),
      		'name'      => 'login_background_image',
      ));
      
	   $fieldset1 = $form->addFieldset('evolved_form_login1', array('legend'=>Mage::helper('evolved')->__('Left Sidebar')));
	   $fieldset1->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
	   
	   $fieldset1->addField('myaccount_sidebar_block_title_color', 'colorpicker', array(
	   		'label'     => Mage::helper('evolved')->__('Block ‐ Color, title:'),
	   		'name'      => 'myaccount_sidebar_block_title_color',
	   ));
	   
	   $fieldset1->addField('myaccount_sidebar_block_title_fontsize', 'text', array(
	   		'label'     => Mage::helper('evolved')->__('Block ‐ Color, title, size:'),
	   		'name'      => 'myaccount_sidebar_block_title_fontsize',
	   		'note' => Mage::helper('evolved')->__('Font size in PX'),
	   ));
	   
	   $fieldset1->addField('myaccount_sidebar_block_topborder_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Block ‐ Color, border, top:'),
      		'name'      => 'myaccount_sidebar_block_topborder_color',
      		'note' => Mage::helper('evolved')->__('Leave empty to use main color'),
      ));
	           
      $fieldset1->addField('myaccount_sidebar_block_background_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Block ‐ Color, background:'),
      		'name'      => 'myaccount_sidebar_block_background_color',
      ));  
      
      $fieldset1->addField('myaccount_sidebar_block_linkhover_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Block ‐ Color, background, link, hover:'),
      		'name'      => 'myaccount_sidebar_block_linkhover_background',
      ));
          
      $fieldset1->addField('myaccount_sidebar_block_link_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Block ‐ Color, link:'),
      		'name'      => 'myaccount_sidebar_block_link_color',
      ));
      
      $fieldset1->addField('myaccount_sidebar_block_linkhover_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Block ‐ Color, link, hover:'),
      		'name'      => 'myaccount_sidebar_block_linkhover_color',
      ));
      
	  $fieldset1->addField('myaccount_sidebar_block_activelink_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Block ‐ Color, link, active:'),
      		'name'      => 'myaccount_sidebar_block_activelink_color',
      ));
            
      /*$fieldset1->addField('myaccount_sidebar_button_textcolor', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button text color:'),
      		'name'      => 'myaccount_sidebar_button_textcolor',
      ));
      
      $fieldset1->addField('myaccount_sidebar_button_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button background color:'),
      		'name'      => 'myaccount_sidebar_button_background',
      		'note' => Mage::helper('evolved')->__('Leave empty to use main color'),
      ));
      
      $fieldset1->addField('myaccount_sidebar_button_text_hovercolor', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button text hover color:'),
      		'name'      => 'myaccount_sidebar_button_text_hovercolor',
      ));
      
      $fieldset1->addField('myaccount_sidebar_button_background_hovercolor', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button background hover color:'),
      		'name'      => 'myaccount_sidebar_button_background_hovercolor',
      ));*/
      
	  $fieldset2 = $form->addFieldset('evolved_form_login2', array('legend'=>Mage::helper('evolved')->__('Right Sidebar')));
	  $fieldset2->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));

	  $fieldset2->addField('myaccount_rightsidebar_text_color', 'colorpicker', array(
	  		'label'     => Mage::helper('evolved')->__('Color, text:'),
	  		'name'      => 'myaccount_rightsidebar_text_color',
	  ));
	  
	  $fieldset2->addField('myaccount_rightsidebar_link_color', 'colorpicker', array(
	  		'label'     => Mage::helper('evolved')->__('Color, link:'),
	  		'name'      => 'myaccount_rightsidebar_link_color',
	  ));
	  
	  $fieldset2->addField('myaccount_rightsidebar_title_color', 'colorpicker', array(
	  		'label'     => Mage::helper('evolved')->__('Color, title:'),
	  		'name'      => 'myaccount_rightsidebar_title_color',
	  ));
	  
	  $fieldset2->addField('myaccount_rightsidebar_subtitle_color', 'colorpicker', array(
	  		'label'     => Mage::helper('evolved')->__('Color, sub‐title:'),
	  		'name'      => 'myaccount_rightsidebar_subtitle_color',
	  ));
	   
	  /*$fieldset2->addField('myaccount_rightsidebar_button_background_color', 'colorpicker', array(
	  		'label'     => Mage::helper('evolved')->__('Button background color:'),
	  		'name'      => 'myaccount_rightsidebar_button_background_color',
	  ));
	  
	  $fieldset2->addField('myaccount_rightsidebar_button_text_color', 'colorpicker', array(
	  		'label'     => Mage::helper('evolved')->__('Button text color:'),
	  		'name'      => 'myaccount_rightsidebar_button_text_color',
	  ));*/
	  Mage::getSingleton('core/session')->setBlockName('evolved_myaccountlogin');
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