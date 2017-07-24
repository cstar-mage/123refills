<?php

class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Tab_Diamondeducation extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('evolved_form_diamondeducation', array('legend'=>Mage::helper('evolved')->__('Diamond Education')));
     
      $fieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
      
      $fieldset->addField('de_tab_bg_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Tab Background Color:'),
      		'name'      => 'evolved_form_diamondeducation[de_tab_bg_color]',
      ));
      
      $fieldset->addField('de_tab_border_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Tab Border Color:'),
      		'name'      => 'evolved_form_diamondeducation[de_tab_border_color]',
      ));
      
      $fieldset->addField('de_tab_title_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Tab Title Color:'),
      		'name'      => 'evolved_form_diamondeducation[de_tab_title_color]',
      ));
      
     /* $fieldset->addField('de_tab_title_size', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Tab Font Size (pixels):'),
      		'name'      => 'de_tab_title_size',
      ));
      
      $fieldset->addField('de_tab_title_texttransform', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Tab Title Transform'),
      		'name'      => 'de_tab_title_texttransform',
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
      
      $fieldset->addField('de_tab_title_style', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Tab Title Style'),
      		'name'      => 'de_tab_title_style',
      		'values'    => array(
      				array('value'=>'','label'=>'Please Select'),
      				array('value'=>'normal','label'=>'normal'),
      				array('value'=>'italic','label'=>'italic'),
      				array('value'=>'oblique','label'=>'oblique'),
      				array('value'=>'initial','label'=>'initial'),
      				array('value'=>'inherit','label'=>'inherit'),
      		),
      ));
      
      $fieldset->addField('de_tab_title_weight', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Tab Title Weight'),
      		'name'      => 'de_tab_title_weight',
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
      ));*/
      
      $fieldset->addField('de_tab_content_title_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Tab Content Title Color:'),
      		'name'      => 'evolved_form_diamondeducation[de_tab_content_title_color]',
      ));
      
      $fieldset->addField('de_tab_content_color', 'colorpicker', array(
      		'label'     => Mage::helper('evolved')->__('Tab Content Color:'),
      		'name'      => 'evolved_form_diamondeducation[de_tab_content_color]',
      ));
      
      /*$fieldset->addField('navigation_top_font_size', 'text', array(
      		'label'     => Mage::helper('evolved')->__('Top level Navigation font size:'),
      		'name'      => 'navigation_top_font_size',
      		'note'  => Mage::helper('evolved')->__('Top level ONLY Font size in PX'),
      ));
      */
      Mage::getSingleton('core/session')->setBlockName('evolved_diamondeducation');
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