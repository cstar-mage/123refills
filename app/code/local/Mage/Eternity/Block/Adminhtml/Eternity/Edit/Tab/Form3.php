<?php
 
class Mage_Eternity_Block_Adminhtml_Eternity_Edit_Tab_Form3 extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('eternity_form', array('legend'=>Mage::helper('eternity')->__('Manage Dia Price')));
     
      $fieldset->addField('dia_price', 'gallery56', array(
          'label'     => Mage::helper('eternity')->__('Shape'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'dia_price',
      ));	
      
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