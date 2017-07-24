<?php
 
class Ideal_stud_Block_Adminhtml_Stud_Edit_Tab_Form19 extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('stud_form', array('legend'=>Mage::helper('stud')->__('Manage Fancy Price')));
     
/*      $fieldset->addField('price_from', 'text', array(
          'label'     => Mage::helper('stud')->__('Price From'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'price_from',
      ));
	  

      $fieldset->addField('price_to', 'text', array(
          'label'     => Mage::helper('stud')->__('Price To'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'price_to',
      ));
	  
      $fieldset->addField('price_increase', 'text', array(
          'label'     => Mage::helper('stud')->__('Price Increse in %'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'price_increase',
      ));
	  
*/      $fieldset->addField('carat', 'gallery29', array(
          'label'     => Mage::helper('stud')->__('Add Shape Information'),
          'class'     => '',
          'required'  => false,
          'name'      => 'carat',
      ));	  

/*      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('stud')->__('CSV file of Diamonds'),
          'required'  => true,
		  'class'     => 'required-entry',
          'name'      => 'filename',
	  ));
*//*		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('stud')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('stud')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('stud')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('stud')->__('Content'),
          'title'     => Mage::helper('stud')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
   */  
      if ( Mage::getSingleton('adminhtml/session')->getstudData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getstudData());
          Mage::getSingleton('adminhtml/session')->setstudData(null);
      } elseif ( Mage::registry('stud_data') ) {
          $form->setValues(Mage::registry('stud_data')->getData());
      }
      return parent::_prepareForm();
  }
}