<?php
class Ideal_Diamondsearch_Block_Adminhtml_Diamondsearch_Edit_Tab_Attribute extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm(){
		
	  $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('diamondsearch_form', array('legend'=>Mage::helper('diamondsearch')->__('Attribute Position')));
     
		$fieldset->addField('attribute_position', 'text', array(
			'name'=>'attribute_position',
			'label'     => Mage::helper('diamondsearch')->__('Attribute Position'),
			'class'=>'requried-entry',
			//'value'=>$product->getData('tier_price')
		));
	  

		$form->getElement('attribute_position')->setRenderer(
            $this->getLayout()->createBlock('diamondsearch/adminhtml_diamondsearch_edit_tab_attribute_position')
        );
			
		

      /*if ( Mage::getSingleton('adminhtml/session')->getDiamondsearchData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getDiamondsearchData());
          Mage::getSingleton('adminhtml/session')->setDiamondsearchData(null);
      } elseif ( Mage::registry('diamondsearch_data') ) {
          $form->setValues(Mage::registry('diamondsearch_data')->getData());
      }*/
      return parent::_prepareForm();
  }	
}
?>