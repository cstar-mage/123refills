<?php

class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Tab_Sidebar extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('evolved_form_sidebar', array('legend'=>Mage::helper('evolved')->__('Sidebar')));
      
      $fieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
     
      $fieldset->addField('sidebar_block_topborder_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Block top border color:'),
      		'name'      => 'sidebar_block_topborder_color',
      		'note' => Mage::helper('evolved')->__('Leave empty to use main color'),
      ));
      
      $fieldset->addField('sidebar_block_itemsborder_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Block items border color:'),
      		'name'      => 'sidebar_block_itemsborder_color',
      		'note' => Mage::helper('evolved')->__('Items divider ( wishlist, checkout progress etc )'),
      ));
      
      $fieldset->addField('sidebar_block_background_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Block background color:'),
      		'name'      => 'sidebar_block_background_color',
      ));
      
      
      $fieldset->addField('sidebar_block_title_fontsize', 'text', array(
          'label'     => Mage::helper('evolved')->__('Block title font size:'),
          'name'      => 'sidebar_block_title_fontsize',
      	  'note' => Mage::helper('evolved')->__('Font size in PX'),
      ));
      
      $fieldset->addField('sidebar_block_title_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Block title color:'),
      		'name'      => 'sidebar_block_title_color',
      ));
      
      $fieldset->addField('sidebar_block_text_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Block text color:'),
      		'name'      => 'sidebar_block_text_color',
      ));
      
      $fieldset->addField('sidebar_block_link_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Block link color:'),
      		'name'      => 'sidebar_block_link_color',
      ));
      
      $fieldset->addField('sidebar_block_linkhover_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Block link hover color:'),
      		'name'      => 'sidebar_block_linkhover_color',
      ));
      
      $fieldset->addField('sidebar_block_linkhover_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Block link hover background color:'),
      		'name'      => 'sidebar_block_linkhover_background',
      ));
      
      $fieldset->addField('sidebar_block_link_icon_color', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Block link icon color:'),
      		'name'      => 'sidebar_block_link_icon_color',
      		'options'   => array(
      				'black' => Mage::helper('evolved')->__('Black'),
      				'white' => Mage::helper('evolved')->__('White'),
      		),
      ));
      
      $fieldset->addField('sidebar_button_textcolor', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button text color:'),
      		'name'      => 'sidebar_button_textcolor',
      ));
      
      $fieldset->addField('sidebar_button_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button background color:'),
      		'name'      => 'sidebar_button_background',
      		'note' => Mage::helper('evolved')->__('Leave empty to use main color'),
      ));
      
      $fieldset->addField('sidebar_button_text_hovercolor', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button text hover color:'),
      		'name'      => 'sidebar_button_text_hovercolor',
      ));
      
      $fieldset->addField('sidebar_button_background_hovercolor', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Button background hover color:'),
      		'name'      => 'sidebar_button_background_hovercolor',
      ));
      
      /*  Poll block */
      $fieldset->addField('sidebar_poll_question_background', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Poll question background color:'),
      		'name'      => 'sidebar_poll_question_background',
      ));
      
      $fieldset->addField('sidebar_poll_question_textcolor', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Poll question text color:'),
      		'name'      => 'sidebar_poll_question_textcolor',
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