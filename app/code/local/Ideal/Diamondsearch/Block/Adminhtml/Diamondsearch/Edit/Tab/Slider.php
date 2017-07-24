<?php

class Ideal_Diamondsearch_Block_Adminhtml_Diamondsearch_Edit_Tab_Slider extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
	  $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('diamondsearch_form', array('legend'=>Mage::helper('diamondsearch')->__('Item information')));
     
	  $fieldset->addField('color_slider', 'text', array(
                'name'=>'color_slider',
				'label'     => Mage::helper('diamondsearch')->__('Color Slider'),
                'class'=>'requried-entry',
               //'value'=>$product->getData('tier_price')
        ));
	  $fieldset->addField('fancycolor_slider', 'text', array(
                'name'=>'fancycolor_slider',
				'label'     => Mage::helper('diamondsearch')->__('FancyColor Slider'),
                'class'=>'requried-entry',
        ));

	  $fieldset->addField('clarity_slider', 'text', array(
                'name'=>'clarity_slider',
				'label'     => Mage::helper('diamondsearch')->__('Clarity Slider'),
                'class'=>'requried-entry',
        ));
	  $fieldset->addField('cut_slider', 'text', array(
                'name'=>'cut_slider',
				'label'     => Mage::helper('diamondsearch')->__('Cut Slider'),
                'class'=>'requried-entry',
        ));
	  $fieldset->addField('fluorescence_slider', 'text', array(
                'name'=>'fluorescence_slider',
				'label'     => Mage::helper('diamondsearch')->__('Fluorescence Slider'),
                'class'=>'requried-entry',
        ));
	  $fieldset->addField('certificate_slider', 'text', array(
                'name'=>'certificate_slider',
				'label'     => Mage::helper('diamondsearch')->__('Certificates'),
                'class'=>'requried-entry',
        ));

		$form->getElement('color_slider')->setRenderer(
            $this->getLayout()->createBlock('diamondsearch/adminhtml_diamondsearch_edit_tab_slider_color')
        );
			$form->getElement('fancycolor_slider')->setRenderer(
					$this->getLayout()->createBlock('diamondsearch/adminhtml_diamondsearch_edit_tab_slider_fancycolor')
			);
		$form->getElement('clarity_slider')->setRenderer(
            $this->getLayout()->createBlock('diamondsearch/adminhtml_diamondsearch_edit_tab_slider_clarity')
        );
		$form->getElement('cut_slider')->setRenderer(
            $this->getLayout()->createBlock('diamondsearch/adminhtml_diamondsearch_edit_tab_slider_cut')
        );
		$form->getElement('fluorescence_slider')->setRenderer(
            $this->getLayout()->createBlock('diamondsearch/adminhtml_diamondsearch_edit_tab_slider_fluorescence')
        );
		$form->getElement('certificate_slider')->setRenderer(
            $this->getLayout()->createBlock('diamondsearch/adminhtml_diamondsearch_edit_tab_slider_certificate')
        );


      /*if ( Mage::getSingleton('adminhtml/session')->getDiamondsearchData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getDiamondsearchData());
          Mage::getSingleton('adminhtml/session')->setDiamondsearchData(null);
      } elseif ( Mage::registry('diamondsearch_data') ) {
          $form->setValues(Mage::registry('diamondsearch_data')->getData());
      }*/
      return parent::_prepareForm();
  }
}
