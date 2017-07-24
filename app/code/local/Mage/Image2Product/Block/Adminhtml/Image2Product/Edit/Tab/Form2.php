<?php
 
class Mage_Image2Product_Block_Adminhtml_Image2Product_Edit_Tab_Form2 extends Mage_Adminhtml_Block_Widget_Form
{
/*  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('Image2Product_form', array('legend'=>Mage::helper('Image2Product')->__('File Uploader')));
     
/*      $fieldset->addField('price_from', 'text', array(
          'label'     => Mage::helper('Image2Product')->__('Price From'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'price_from',
      ));
	  

      $fieldset->addField('price_to', 'text', array(
          'label'     => Mage::helper('Image2Product')->__('Price To'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'price_to',
      ));
	  
      $fieldset->addField('price_increase', 'text', array(
          'label'     => Mage::helper('Image2Product')->__('Price Increse in %'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'price_increase',
      ));
	  
      $fieldset->addField('vendor', 'gallery2', array(
          'label'     => Mage::helper('Image2Product')->__('File Uploader'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'vendor',
      ));	  

/*      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('Image2Product')->__('CSV file of Diamonds'),
          'required'  => true,
		  'class'     => 'required-entry',
          'name'      => 'filename',
	  ));
*//*		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('Image2Product')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('Image2Product')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('Image2Product')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('Image2Product')->__('Content'),
          'title'     => Mage::helper('Image2Product')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
   */  
    /*  if ( Mage::getSingleton('adminhtml/session')->getImage2ProductData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getImage2ProductData());
          Mage::getSingleton('adminhtml/session')->setImage2ProductData(null);
      } elseif ( Mage::registry('Image2Product_data') ) {
          $form->setValues(Mage::registry('Image2Product_data')->getData());
      }
      return parent::_prepareForm();
  }*/
} 
?>