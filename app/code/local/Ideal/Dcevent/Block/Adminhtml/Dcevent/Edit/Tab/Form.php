<?php

class Ideal_Dcevent_Block_Adminhtml_Dcevent_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('dcevent_form', array('legend'=>Mage::helper('dcevent')->__('Event information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('dcevent')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'image', array(
          'label'     => Mage::helper('dcevent')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
	  
		$fieldset->addField('start_date', 'date', array(
			'name'               => 'start_date',
			'label'              => Mage::helper('dcevent')->__('Event Start Date'),
			'tabindex'           => 1,
			'image'              => $this->getSkinUrl('images/grid-cal.gif'),
			'format'             => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT) ,
			'value'              => date( Mage::app()->getLocale()->getDateStrFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT), strtotime('next weekday') )
		));


		$fieldset->addField('end_date', 'date', array(
					'name'               => 'end_date',
					'label'              => Mage::helper('dcevent')->__('Event End Date'),
					'tabindex'           => 1,
					'image'              => $this->getSkinUrl('images/grid-cal.gif'),
					'format'             => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT) ,
					'value'              => date( Mage::app()->getLocale()->getDateStrFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT), strtotime('next weekday') )
				));
		
		/*$fieldset->addField('start_time', 'text', array(
          'label'     => Mage::helper('dcevent')->__('Start Time'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'start_time',
      	));
	  
	   $fieldset->addField('end_time', 'text', array(
		  'label'     => Mage::helper('dcevent')->__('End Time'),
		  'class'     => 'required-entry',
		  'required'  => true,
		  'name'      => 'end_time',
	  	));
			*/
      /*$fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('dcevent')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('dcevent')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('dcevent')->__('Disabled'),
              ),
          ),
      ));*/
		
		$fieldset->addField('place', 'text', array(
				'label'     => Mage::helper('dcevent')->__('Place'),
				'required'  => false,
				'name'      => 'place',
		));
     
     /* $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('dcevent')->__('Content'),
          'title'     => Mage::helper('dcevent')->__('Content'),
          'style'     => 'width:700px; height:100px;',
		  'config'    => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
          'wysiwyg'   => true,
          'required'  => true,
      )); */
     
      if ( Mage::getSingleton('adminhtml/session')->getDceventData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getDceventData());
          Mage::getSingleton('adminhtml/session')->setDceventData(null);
      } elseif ( Mage::registry('dcevent_data') ) {
          $form->setValues(Mage::registry('dcevent_data')->getData());
      }
      return parent::_prepareForm();
  }
}