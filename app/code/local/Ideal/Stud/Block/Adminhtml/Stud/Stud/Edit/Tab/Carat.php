<?php

class Ideal_stud_Block_Adminhtml_Stud_Stud_Edit_Tab_Carat extends Mage_Adminhtml_Block_Widget_Form 
{
 


  protected function _prepareForm()
  {


 	     $form = new Varien_Data_Form();

      $this->setForm($form);

      $fieldset = $form->addFieldset('stud_form1', array('legend'=>Mage::helper('stud')->__('Item information')));




      $fieldset->addField('caratweight', 'text', array(

                'name'=>'caratweight',

		        		'label' => Mage::helper('stud')->__('Carat Weight'),

                'class'=>'requried-entry',

       ));

      


	 	$form->getElement('caratweight')->setRenderer( 

            $this->getLayout()->createBlock('stud/adminhtml_stud_stud_edit_tab_carat_carat')


    ); 

     
      return parent::_prepareForm();
    

  } 

}