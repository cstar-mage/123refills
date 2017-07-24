<?php

class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Tab_livechat extends Mage_Adminhtml_Block_Widget_Form
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
      
      $fieldset = $form->addFieldset('evolved_form_livechat', array('legend'=>Mage::helper('evolved')->__('Live Chat')));
      
   //  $fieldset->addType('select_fonts', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Font'));
     // $fieldset->addType('heading', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Heading'));
      
      $fieldset->addField('livechat_enable', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Enable Live Chat:'),
      		'name'      => 'evolved_form_livechat[livechat_enable]',
      		'options'   => array(
      				0 => Mage::helper('evolved')->__('No'),
      				1 => Mage::helper('evolved')->__('Yes'),
      		),
      ));
      
      $fieldset->addField('livechat_script', 'textarea', array(
      		'label'     => Mage::helper('evolved')->__('Live Chat script:'),
      		'name'      => 'evolved_form_livechat[livechat_script]',
      		'config'    => $configSettings,
      ));
      Mage::getSingleton('core/session')->setBlockName('evolved_livechat');
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