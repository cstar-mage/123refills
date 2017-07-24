<?php 
class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Tab_Designer extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset('evolved_form_designer', array('legend'=>Mage::helper('evolved')->__('Designer Setting')));
		$fieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Color'));
		$fieldset->addType('select_fonts', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Font'));
		
		$fieldset->addField('evolved_designer_style', 'select', array(
				'label'     => Mage::helper('evolved')->__('Style:'),
				'name'      => 'evolved_designer_style',
				'options'   => array(
						'' => Mage::helper('evolved')->__('Please Select'),
						'square' => Mage::helper('evolved')->__('Square'),
						'rectangle' => Mage::helper('evolved')->__('Rectangle'),
				),
		));
		
		$fieldset->addField('evolved_designer_style_border', 'select', array(
				'label'     => Mage::helper('evolved')->__('Border Enable:'),
				'name'      => 'evolved_designer_style_border',
				'options'   => array(
						'' => Mage::helper('evolved')->__('Please Select'),
						'1' => Mage::helper('evolved')->__('Enable'),
						'0' => Mage::helper('evolved')->__('Disable'),
				),
		));
		
		$fieldset->addField('evolved_designer_style_hover', 'select', array(
				'label'     => Mage::helper('evolved')->__('Hover Enable:'),
				'name'      => 'evolved_designer_style_hover',
				'options'   => array(
						'' => Mage::helper('evolved')->__('Please Select'),
						'1' => Mage::helper('evolved')->__('Enable'),
						'0' => Mage::helper('evolved')->__('Disable'),
				),
		));	
		
		$fieldset->addField('evolved_designer_style_border_color', 'colorpicker', array(
				'label'     => Mage::helper('evolved')->__('Border color:'),
				'name'      => 'evolved_designer_style_border_color',
		));
		
		$fieldset->addField('evolved_designer_style_border_hover_color', 'colorpicker', array(
				'label'     => Mage::helper('evolved')->__('Border Hover color:'),
				'name'      => 'evolved_designer_style_border_hover_color',
		));
		Mage::getSingleton('core/session')->setBlockName('evolved_designer');
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