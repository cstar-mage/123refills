<?php

class Ideal_Diamondrequest_Block_Adminhtml_Diamondrequest_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('Diamondrequest_form', array('legend'=>Mage::helper('Diamondrequest')->__('Item information')));
     
      $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('Diamondrequest')->__('Name'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'name'
      ));
      $fieldset->addField('email', 'text', array(
          'label'     => Mage::helper('Diamondrequest')->__('Email'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'email'
	  ));
      
      $fieldset->addField('phone', 'text', array(
      		'label'     => Mage::helper('Diamondrequest')->__('Phone'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'phone'
      ));
      $fieldset->addField('zipcode', 'text', array(
      		'label'     => Mage::helper('Diamondrequest')->__('Zip Code'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'zipcode'
      ));
      
      /* $fieldset->addField('phone', 'text', array(
      		'label'     => Mage::helper('Diamondrequest')->__('Phone'),
      		'name'      => 'phone',
      )); */
	  $fieldset->addField('producturl', 'text', array(
      		'label'     => Mage::helper('Diamondrequest')->__('Product Url'),
      		'name'      => 'producturl'
      ));
	  $fieldset->addField('producttype', 'text', array(
      		'label'     => Mage::helper('Diamondrequest')->__('Looking for Product'),
      		'name'      => 'producttype'
      ));
	  
	  /* $fieldset->addField('rings', 'text', array(
	  		'label'     => Mage::helper('Diamondrequest')->__('Iterested Rings'),
	  		'name'      => 'rings',
	  ));*/
	  
	   $fieldset->addField('stonetype', 'text', array(
      		'label'     => Mage::helper('Diamondrequest')->__('Stone Type'),
      		'name'      => 'stonetype'
      ));	   
	   
	   $fieldset->addField('caratsizefrom', 'text', array(
	   		'label'     => Mage::helper('Diamondrequest')->__('Carat Size From'),
	   		'name'      => 'caratsizefrom'
	   ));	  
	  $fieldset->addField('caratsizeto', 'text', array(
      		'label'     => Mage::helper('Diamondrequest')->__('Carat Size To'),
      		'name'      => 'caratsizeto'
      )); 
	   
	  
	  $fieldset->addField('colorfrom', 'text', array(
	   		'label'     => Mage::helper('Diamondrequest')->__('Color From'),
	   		'name'      => 'colorfrom'
	   ));	  
	  $fieldset->addField('colorto', 'text', array(
      		'label'     => Mage::helper('Diamondrequest')->__('Color To'),
      		'name'      => 'colorto'
      ));
	  
	  $fieldset->addField('clarityfrom', 'text', array(
	  		'label'     => Mage::helper('Diamondrequest')->__('Clarity From'),
	  		'name'      => 'clarityfrom'
	  ));
	  $fieldset->addField('clarityto', 'text', array(
	  		'label'     => Mage::helper('Diamondrequest')->__('Clarity To'),
	  		'name'      => 'clarityto'
	  ));
	  
	  $fieldset->addField('pricerangefrom', 'text', array(
	  		'label'     => Mage::helper('Diamondrequest')->__('Price Range From'),
	  		'name'      => 'pricerangefrom'
	  ));
	  $fieldset->addField('pricerangeto', 'text', array(
	  		'label'     => Mage::helper('Diamondrequest')->__('Price Range To'),
	  		'name'      => 'pricerangeto'
	  ));
	  
	  $fieldset->addField('lab', 'text', array(
	  		'label'     => Mage::helper('Diamondrequest')->__('Lab'),
	  		'name'      => 'lab'
	  ));
     
	   /* 
	  $fieldset->addField('comment', 'textarea', array(
      		'label'     => Mage::helper('Diamondrequest')->__('Comment'),
      		'name'      => 'comment',
      ));
       
	  $fieldset->addField('image1', 'text',array(
			'label'     => Mage::helper('Diamondrequest')->__('Image1'),
			'name'      => 'image1',
	  ));
	   $fieldset->addField('image2', 'text',array(
			'label'     => Mage::helper('Diamondrequest')->__('Image2'),
			'name'      => 'image2',
	  ));
	   $fieldset->addField('image3', 'text',array(
			'label'     => Mage::helper('Diamondrequest')->__('Image3'),
			'name'      => 'image3',
	  ));
	   $fieldset->addField('image4', 'text',array(
			'label'     => Mage::helper('Diamondrequest')->__('Image4'),
			'name'      => 'image4',
	  ));
	   $fieldset->addField('image5', 'text',array(
			'label'     => Mage::helper('Diamondrequest')->__('Image5'),
			'name'      => 'image5',
	  ));
	   $fieldset->addField('image6', 'text',array(
			'label'     => Mage::helper('Diamondrequest')->__('Image6'),
			'name'      => 'image6',
	  )); */
		
    /*  $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('Diamondrequest')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('Diamondrequest')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('Diamondrequest')->__('Disabled'),
              ),
          ),
      ));*/
     
      if ( Mage::getSingleton('adminhtml/session')->getDiamondrequestData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getDiamondrequestData());
          Mage::getSingleton('adminhtml/session')->setDiamondrequestData(null);
      } elseif ( Mage::registry('Diamondrequest_data') ) {
          $form->setValues(Mage::registry('Diamondrequest_data')->getData());
      }
      return parent::_prepareForm();
  }
}