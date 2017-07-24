<?php 
class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Tab_Comingsoon extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset('evolved_form_commingsoon', array('legend'=>Mage::helper('evolved')->__('Coming Soon Setting')));
		$fieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
		$fieldset->addType('select_fonts', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Font'));
		
		$fieldset->addField('commingsoon_title', 'text', array(
				'label'     => Mage::helper('evolved')->__('Title'),
				'required'  => false,
				'name'      => 'commingsoon_title',
		));
		
		$fieldset->addField('commingsoon_image', 'image', array(
				'label'     => Mage::helper('evolved')->__('Image'),
				'required'  => false,
				'name'      => 'commingsoon_image',
		));
		
		Mage::getSingleton('core/session')->setBlockName('evolved_Coming_soon');
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