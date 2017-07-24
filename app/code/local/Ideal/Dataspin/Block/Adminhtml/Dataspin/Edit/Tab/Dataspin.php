<?php
 
class Ideal_Dataspin_Block_Adminhtml_Dataspin_Edit_Tab_Dataspin extends Mage_Adminhtml_Block_Widget_Form
{
	
	protected function _prepareForm()
	{
		
		$form = new Varien_Data_Form();
		$this->setForm($form);
		
		$configSettings = Mage::getSingleton('cms/wysiwyg_config')->getConfig(
				array(
						'add_images' => true,
						'add_widgets' => true,
						'add_variables' => true,
						'files_browser_window_url'=> Mage::helper("adminhtml")->getUrl("adminhtml/cms_wysiwyg_images/index"),
				));
		
		$fieldset = $form->addFieldset('dataspin_form1', array('legend'=>Mage::helper('dataspin')->__('General')));
		 
		$fieldset->addField('name', 'text', array(
				'label'     => Mage::helper('dataspin')->__('Name'),
				'class'     => 'required-entry',
				'required'  => true,
				'name'      => 'name',
		));
		$fieldset->addField('short_description', 'editor', array(
				'name'      => 'short_description',
				'label'     => Mage::helper('dataspin')->__('Short Description'),
				'title'     => Mage::helper('dataspin')->__('Short Description'),
				'wysiwyg'   => false,
				'required'  => true,
				'style' => 'width:500px; height:200px;',
				'config'    => $configSettings,
		));
		
		$fieldset->addField('description', 'editor', array(
				'name'      => 'description',
				'label'     => Mage::helper('dataspin')->__('Description'),
				'title'     => Mage::helper('dataspin')->__('Description'),
				'wysiwyg'   => false,
				'required'  => true,
				'style' => 'width:500px; height:200px;',
				'config'    => $configSettings,
		));
		
		
		$fieldset2 = $form->addFieldset('dataspin_form2', array('legend'=>Mage::helper('dataspin')->__('Meta Information')));
		$fieldset2->addField('meta_title', 'text', array(
				'label'     => Mage::helper('dataspin')->__('Meta Title'),
				'class'     => 'required-entry',
				//'required'  => true,
				'name'      => 'meta_title',
		));
		$fieldset2->addField('meta_description', 'editor', array(
				'name'      => 'meta_description',
				'label'     => Mage::helper('dataspin')->__('Meta Description'),
				'title'     => Mage::helper('dataspin')->__('Meta Description'),
				'wysiwyg'   => false,
				//'required'  => true,
				'style' => 'width:500px; height:200px;',
				'config'    => $configSettings,
		));
		
		$fieldset3 = $form->addFieldset('dataspin_form3', array('legend'=>Mage::helper('dataspin')->__('Spin Information')));
		for($i=1;$i<=16;$i++) {
			$fieldset3->addField('spin'.$i, 'text', array(
					'label'     => Mage::helper('dataspin')->__('Spin Word %s {{spin%s}}',$i,$i),
					//'class'     => 'required-entry',
					//'required'  => true,
					'name'      => 'spin'.$i,
			));
		}
		//echo "<pre>"; print_r(Mage::registry('dataspin_data')->getData());echo "</pre>";
		if ( Mage::getSingleton('adminhtml/session')->getDataspinData() )
		{
			$form->setValues(Mage::getSingleton('adminhtml/session')->getDataspinData());
			Mage::getSingleton('adminhtml/session')->setDataspinData(null);
		} elseif ( Mage::registry('dataspin_data') ) {
			$form->setValues(Mage::registry('dataspin_data')->getData());
		}
		return parent::_prepareForm();
	}
}
?>
