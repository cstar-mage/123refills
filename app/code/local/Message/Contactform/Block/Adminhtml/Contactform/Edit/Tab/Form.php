<?php
/**
 * Custom
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Custom
 * @package    Message_Contactform
 * @author     Custom Development Team
 * @copyright  Copyright (c) 2013 Custom. (http://www.magerevol.com)
 * @license    http://opensource.org/licenses/osl-3.0.php
 */
class Message_Contactform_Block_Adminhtml_Contactform_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('contactform_form', array('legend'=>Mage::helper('contactform')->__('Message detail')));
     
      $fieldset->addField('cname', 'label', array(
          'label'     => Mage::helper('contactform')->__('Name'),
          'name'      => 'cname',
      ));

      $fieldset->addField('email', 'label', array(
          'label'     => Mage::helper('contactform')->__('Email'),
          'name'      => 'email',
      ));
      
      $fieldset->addField('telephone', 'label', array(
          'label'     => Mage::helper('contactform')->__('Telephone'),
          'name'      => 'telephone',
      ));
      
      //$fieldset->addField('subject', 'label', array(
//          'label'     => Mage::helper('contactform')->__('Subject'),
//          'name'      => 'subject',
//      ));
      
    $fieldset->addField('comment', 'label', array(
          'label'     => Mage::helper('contactform')->__('Comment'),
         'name'      => 'comment',
      ));
		

     
     // $fieldset->addField('message', 'editor', array(
//          'name'      => 'message',
//          'label'     => Mage::helper('contactform')->__('Message'),
//          'title'     => Mage::helper('contactform')->__('Message'),
//          'style'     => 'width:500px; height:350px',
//          'wysiwyg'   => false,
//          'required'  => true,
//      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getContactformData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getContactformData());
          Mage::getSingleton('adminhtml/session')->setContactformData(null);
      } elseif ( Mage::registry('contactform_data') ) {
          $form->setValues(Mage::registry('contactform_data')->getData());
      }
      return parent::_prepareForm();
  }
}