<?php
class Ideal_Taskproduction_Block_Adminhtml_Taskproduction_Edit_Tab_Leftreplysubmit extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('taskproduction_form_leftreplyform', array('legend'=>Mage::helper('taskproduction')->__('Reply')));

      $fieldset->addType('leftreplyform', Mage::getConfig()->getBlockClassName('Ideal_Taskproduction_Block_Adminhtml_Taskproduction_Edit_Tab_Renderer_Leftreplyform'));
      $fieldset->addField('leftreplyform', 'leftreplyform', array(
      		'name'      => 'leftreplyform',
      ));
            
      if ( Mage::getSingleton('adminhtml/session')->getTaskproductionData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getTaskproductionData());
          Mage::getSingleton('adminhtml/session')->setTaskproductionData(null);
      } elseif ( Mage::registry('taskproduction_data') ) {
          $form->setValues(Mage::registry('taskproduction_data')->getData());
      }

      return parent::_prepareForm();
  }
}