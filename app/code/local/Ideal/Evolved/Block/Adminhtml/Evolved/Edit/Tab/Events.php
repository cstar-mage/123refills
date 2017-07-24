<?php 
class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Tab_Events extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset('evolved_form_events', array('legend'=>Mage::helper('evolved')->__('Events Setting')));
		$fieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
		$fieldset->addType('select_fonts', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Font'));
		
		$fieldset->addField('evolved_events_style_popup', 'select', array(
				'label'     => Mage::helper('evolved')->__('Popup Enable:'),
				'name'      => 'evolved_form_events[evolved_events_style_popup]',
				'options'   => array(
						'' => Mage::helper('evolved')->__('Please Select'),
						'1' => Mage::helper('evolved')->__('Yes'),
						'0' => Mage::helper('evolved')->__('No'),
				),
		));
		
		Mage::getSingleton('core/session')->setBlockName('evolved_events');
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