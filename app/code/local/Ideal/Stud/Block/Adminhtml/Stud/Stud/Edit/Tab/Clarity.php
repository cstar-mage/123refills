<?php

class Ideal_stud_Block_Adminhtml_Stud_Stud_Edit_Tab_Clarity extends Mage_Adminhtml_Block_Widget_Form 
{
 


  protected function _prepareForm()
  {


 	     $form = new Varien_Data_Form();

      $this->setForm($form);

      $fieldset = $form->addFieldset('stud_form', array('legend'=>Mage::helper('stud')->__('Item information')));




      $fieldset->addField('clarity_setting', 'text', array(

                'name'=>'clarity_setting',

		        		'label' => Mage::helper('stud')->__('Clarity Setting'),

                'class'=>'requried-entry',

       ));

      


	 	$form->getElement('clarity_setting')->setRenderer( 

            $this->getLayout()->createBlock('stud/adminhtml_stud_stud_edit_tab_clarity_clarity')


    ); 

     
      return parent::_prepareForm();
    

  } 

}