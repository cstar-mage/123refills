<?php 
class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Tab_Termsandcondition extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
     
      $fieldset_termsandconditions = $form->addFieldset('evolved_homepage_termsandcondition', array('legend'=>Mage::helper('evolved')->__('Custom Option')));
      $fieldset_termsandconditions->addType('termsandcondition', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Termsandcondition'));
      $fieldset_termsandconditions->addField('termsandcondition', 'termsandcondition', array(
      		'name'      => 'termsandcondition',
      ));
      Mage::getSingleton('core/session')->setBlockName('evolved_termsandconditions');
      if ( Mage::getSingleton('adminhtml/session')->getEvolvedData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getEvolvedData());
          Mage::getSingleton('adminhtml/session')->setEvolvedData(null);
      } elseif ( Mage::registry('evolved_data') ) {
          $form->setValues(Mage::registry('evolved_data'));
      }
      return parent::_prepareForm();
  }
}