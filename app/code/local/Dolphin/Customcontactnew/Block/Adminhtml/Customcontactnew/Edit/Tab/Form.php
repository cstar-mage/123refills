<?php

class Dolphin_Customcontactnew_Block_Adminhtml_Customcontactnew_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('customcontactnew_form', array('legend'=>Mage::helper('customcontactnew')->__('Item information')));
     
      $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('customcontactnew')->__('Name'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'name',
      ));
      
      /* $fieldset->addField('lname', 'text', array(
      		'label'     => Mage::helper('customcontactnew')->__('Last Name'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'lname',
      )); */

      $fieldset->addField('email', 'text', array(
          'label'     => Mage::helper('customcontactnew')->__('Email'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'email',
	  ));
      
      /* $fieldset->addField('phone', 'text', array(
      		'label'     => Mage::helper('customcontactnew')->__('Phone'),
      		'name'      => 'phone',
      )); */
	  $fieldset->addField('producturl', 'text', array(
      		'label'     => Mage::helper('customcontactnew')->__('Product Url '),
      		'name'      => 'producturl',
      ));
	  $fieldset->addField('producttype', 'text', array(
      		'label'     => Mage::helper('customcontactnew')->__('Looking for Product'),
      		'name'      => 'producttype',
      ));
	  
	  /* $fieldset->addField('moreimportant', 'text', array(
      		'label'     => Mage::helper('customcontactnew')->__('More Important'),
      		'name'      => 'moreimportant',
      )); */
	 /*  $fieldset->addField('rings', 'text', array(
	  		'label'     => Mage::helper('customcontactnew')->__('Iterested Rings'),
	  		'name'      => 'rings',
	  ));
	  
	   $fieldset->addField('stonetype', 'text', array(
      		'label'     => Mage::helper('customcontactnew')->__('Stone Type'),
      		'name'      => 'stonetype',
      ));
	   
	   $fieldset->addField('metalcolors', 'text', array(
	   		'label'     => Mage::helper('customcontactnew')->__('Metal Colors'),
	   		'name'      => 'metalcolors',
	   ));
	   */
	  /*  $fieldset->addField('pricerange', 'text', array(
      		'label'     => Mage::helper('customcontactnew')->__('Price Range'),
      		'name'      => 'pricerange',
      )); 
	   
	  
	   $fieldset->addField('month', 'text', array(
      		'label'     => Mage::helper('customcontactnew')->__('Finished Month'),
      		'name'      => 'month',
      ));
	  
	   $fieldset->addField('day', 'text', array(
      		'label'     => Mage::helper('customcontactnew')->__('Finished Date'),
      		'name'      => 'day',
      ));
	  
	  $fieldset->addField('year', 'text', array(
      		'label'     => Mage::helper('customcontactnew')->__('Finished year'),
      		'name'      => 'year',
      ));
     
	  
	  $fieldset->addField('comment', 'textarea', array(
      		'label'     => Mage::helper('customcontactnew')->__('Comment'),
      		'name'      => 'comment',
      ));
       */
	  /* $fieldset->addField('image1', 'text',array(
			'label'     => Mage::helper('customcontactnew')->__('Image1'),
			'name'      => 'image1',
	  ));
	   $fieldset->addField('image2', 'text',array(
			'label'     => Mage::helper('customcontactnew')->__('Image2'),
			'name'      => 'image2',
	  ));
	   $fieldset->addField('image3', 'text',array(
			'label'     => Mage::helper('customcontactnew')->__('Image3'),
			'name'      => 'image3',
	  )); */
	   /* $fieldset->addField('image4', 'text',array(
			'label'     => Mage::helper('customcontactnew')->__('Image4'),
			'name'      => 'image4',
	  ));
	   $fieldset->addField('image5', 'text',array(
			'label'     => Mage::helper('customcontactnew')->__('Image5'),
			'name'      => 'image5',
	  ));
	   $fieldset->addField('image6', 'text',array(
			'label'     => Mage::helper('customcontactnew')->__('Image6'),
			'name'      => 'image6',
	  )); */
		
    /*  $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('customcontactnew')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('customcontactnew')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('customcontactnew')->__('Disabled'),
              ),
          ),
      ));*/
     
      if ( Mage::getSingleton('adminhtml/session')->getCustomcontactnewData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getCustomcontactnewData());
          Mage::getSingleton('adminhtml/session')->setCustomcontactnewData(null);
      } elseif ( Mage::registry('customcontactnew_data') ) {
          $form->setValues(Mage::registry('customcontactnew_data')->getData());
      }
      return parent::_prepareForm();
  }
}