<?php 

class Ideal_Testing_Model_Observer
{
	public function cmsField($observer)
	{
		//get CMS model with data
		$model = Mage::registry('cms_page');
		//get form instance
		$form = $observer->getForm();
		//create new custom fieldset 'atwix_content_fieldset'
		$fieldset = $form->addFieldset('ideal_content_fieldset', array('legend'=>Mage::helper('cms')->__('Custom'),'class'=>'fieldset-wide'));
		//add new field
		$fieldset->addField('cms_header_text', 'textarea', array(
				'name'      => 'cms_header_text',
				'label'     => Mage::helper('cms')->__('Header Text'),
				'title'     => Mage::helper('cms')->__('Header Text'),
				'disabled'  => false,
				//set field value
				'value'     => $model->getCmsHeaderText()
		));

	}
}

?>