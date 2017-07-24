<?php
 
class Mage_Eternity_Block_Adminhtml_Eternity_Edit_Tab_Form2 extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('eternity_form', array('legend'=>Mage::helper('eternity')->__('Manage Vendors')));
     
/*      $fieldset->addField('price_from', 'text', array(
          'label'     => Mage::helper('eternity')->__('Price From'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'price_from',
      ));
	  

      $fieldset->addField('price_to', 'text', array(
          'label'     => Mage::helper('eternity')->__('Price To'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'price_to',
      ));
	  
      $fieldset->addField('price_increase', 'text', array(
          'label'     => Mage::helper('eternity')->__('Price Increse in %'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'price_increase',
      ));
	  
*/      $fieldset->addField('vendor', 'gallery2', array(
          'label'     => Mage::helper('eternity')->__('Vendors'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'vendor',
      ));	  

/*      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('eternity')->__('CSV file of Diamonds'),
          'required'  => true,
		  'class'     => 'required-entry',
          'name'      => 'filename',
	  ));
*//*		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('eternity')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('eternity')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('eternity')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('eternity')->__('Content'),
          'title'     => Mage::helper('eternity')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
   */  
      if ( Mage::getSingleton('adminhtml/session')->getEternityData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getEternityData());
          Mage::getSingleton('adminhtml/session')->setEternityData(null);
      } elseif ( Mage::registry('eternity_data') ) {
          $form->setValues(Mage::registry('eternity_data')->getData());
      }
      return parent::_prepareForm();
  }
}