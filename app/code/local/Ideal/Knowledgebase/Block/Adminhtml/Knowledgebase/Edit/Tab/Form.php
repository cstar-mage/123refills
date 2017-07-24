<?php

class Ideal_Knowledgebase_Block_Adminhtml_Knowledgebase_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('knowledgebase_form', array('legend'=>Mage::helper('knowledgebase')->__('Knowledgebase information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('knowledgebase')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'image', array(
          'label'     => Mage::helper('knowledgebase')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
	  
		$fieldset->addField('start_date', 'date', array(
			'name'               => 'start_date',
			'label'              => Mage::helper('knowledgebase')->__('Knowledgebase Start Date'),
			'tabindex'           => 1,
			'image'              => $this->getSkinUrl('images/grid-cal.gif'),
			'format'             => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT) ,
			'value'              => date( Mage::app()->getLocale()->getDateStrFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT), strtotime('next weekday') )
		));


		$fieldset->addField('end_date', 'date', array(
					'name'               => 'end_date',
					'label'              => Mage::helper('knowledgebase')->__('Knowledgebase End Date'),
					'tabindex'           => 1,
					'image'              => $this->getSkinUrl('images/grid-cal.gif'),
					'format'             => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT) ,
					'value'              => date( Mage::app()->getLocale()->getDateStrFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT), strtotime('next weekday') )
				));
		
		/*$fieldset->addField('start_time', 'text', array(
          'label'     => Mage::helper('knowledgebase')->__('Start Time'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'start_time',
      	));
	  
	   $fieldset->addField('end_time', 'text', array(
		  'label'     => Mage::helper('knowledgebase')->__('End Time'),
		  'class'     => 'required-entry',
		  'required'  => true,
		  'name'      => 'end_time',
	  	));
			*/
      /*$fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('knowledgebase')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('knowledgebase')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('knowledgebase')->__('Disabled'),
              ),
          ),
      ));*/
		
		$fieldset->addField('place', 'text', array(
				'label'     => Mage::helper('knowledgebase')->__('Place'),
				'required'  => false,
				'name'      => 'place',
		));
     
     /* $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('knowledgebase')->__('Content'),
          'title'     => Mage::helper('knowledgebase')->__('Content'),
          'style'     => 'width:700px; height:100px;',
		  'config'    => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
          'wysiwyg'   => true,
          'required'  => true,
      )); */
     
      if ( Mage::getSingleton('adminhtml/session')->getKnowledgebaseData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getKnowledgebaseData());
          Mage::getSingleton('adminhtml/session')->setKnowledgebaseData(null);
      } elseif ( Mage::registry('knowledgebase_data') ) {
          $form->setValues(Mage::registry('knowledgebase_data')->getData());
      }
      return parent::_prepareForm();
  }
}