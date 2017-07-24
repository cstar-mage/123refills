<?php

class Ideal_Brandmanager_Block_Adminhtml_Brandmanager_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('brandmanager_form', array('legend'=>Mage::helper('brandmanager')->__('General information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('brandmanager')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));
			
			if (!Mage::app()->isSingleStoreMode()) {
				$fieldset->addField('store_id', 'multiselect', array(
							'name'      => 'stores[]',
							'label'     => Mage::helper('cms')->__('Store View'),
							'title'     => Mage::helper('cms')->__('Store View'),
							'required'  => true,
							'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
					));
			}
			else {
				$fieldset->addField('store_id', 'hidden', array(
						'name'      => 'stores[]',
						'value'     => Mage::app()->getStore(true)->getId()
				));
			}

      $fieldset->addField('filename', 'image', array(
          'label'     => Mage::helper('brandmanager')->__('Image File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
			
	 /* $fieldset->addField('is_home', 'select', array(
          'label'     => Mage::helper('brandmanager')->__('Show in'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'is_home',
		  'values'	=> Mage::helper('brandmanager')->getDisplayOption(),
      ));*/
	  
	   $fieldset->addField('sortno', 'text', array(
          'label'     => Mage::helper('brandmanager')->__('Sort No'),
          'name'      => 'sortno',
      ));
	  
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('brandmanager')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('brandmanager')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('brandmanager')->__('Disabled'),
              ),
          ),
      ));
			
			$fieldset->addField('weblink', 'text', array(
          'label'     => Mage::helper('brandmanager')->__('Web Url'),
          'required'  => false,
          'name'      => 'weblink',
      ));
			
      /*$fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('brandmanager')->__('Content'),
          'title'     => Mage::helper('brandmanager')->__('Content'),
          'style'     => 'width:280px; height:100px;',
          'wysiwyg'   => false,
          'required'  => false,
      ));*/
			
	  $data = array();
      if ( Mage::getSingleton('adminhtml/session')->getBannerSliderData() )
      {
          $data = Mage::getSingleton('adminhtml/session')->getBannerSliderData();
          Mage::getSingleton('adminhtml/session')->setBannerSliderData(null);
      } elseif ( Mage::registry('brandmanager_data') ) {
          $data = Mage::registry('brandmanager_data')->getData();
      }
      
	  $data['store_id'] = explode(',',$data['stores']);
	  $form->setValues($data);
	  
      return parent::_prepareForm();
  }
}