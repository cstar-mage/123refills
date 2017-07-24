<?php
class EcommerceTeam_FastImport_Block_Adminhtml_Product_Import_Tab_File extends Mage_Adminhtml_Block_Widget_Form
{
	
	protected function _prepareLayout(){
		
        $this->setChild('continue_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => $this->__('Run Import'),
                    'onclick'   => "editForm.submit()",
                    'class'     => 'save'
                    ))
                );
        return parent::_prepareLayout();
        
    }
    
    public function getDataMaxSize()
    {
        return min($this->getPostMaxSize(), $this->getUploadMaxSize());
    }
    public function getPostMaxSize()
    {
        return ini_get('post_max_size');
    }

    public function getUploadMaxSize()
    {
        return ini_get('upload_max_filesize');
    }
	
	protected function _prepareForm(){
        
        $form = new Varien_Data_Form();
        
        $this->setForm($form);
        
        $fieldset = $form->addFieldset('main_fieldset', array('legend' => $this->__('Import')));
        
    	$fieldset->addField('data_file', 'file', array(
            'name'      => 'data_file',
            'label'     => $this->__('CSV File'),
            'title'     => $this->__('CSV File'),
            'required'  => true,
            'note'	=> $this->__('Your server PHP settings allow you to upload files not more than %s at a time. Please modify post_max_size (currently is %s) and upload_max_filesize (currently is %s) values in php.ini if you want to upload larger files.', $this->getDataMaxSize(), $this->getPostMaxSize(), $this->getUploadMaxSize()),
        ));
        
        $field = $fieldset->addField('delimeter', 'text', array(
            'name'      => 'delimeter',
            'label'     => $this->__('Value Delimiter'),
            'title'     => $this->__('Value Delimiter'),
            'required'  => false,
        ));
        
        $field->setValue(',');
        
        $field = $fieldset->addField('enclose', 'text', array(
            'name'      => 'enclose',
            'label'     => $this->__('Enclose Values In'),
            'title'     => $this->__('Enclose Values In'),
            'required'  => false,
        ));
        
        $field->setValue('"');
        
        $fieldset->addField('create_categories', 'select', array(
            'name'      => 'create_categories',
            'label'     => $this->__('Automatically Create Categories'),
            'title'     => $this->__('Automatically Create Categories'),
            'required'  => false,
            'values'	=> array(
            	0 => $this->__('No'),
            	1 => $this->__('Yes'),
            )
        ));
        
        $fieldset->addField('create_options', 'select', array(
            'name'      => 'create_options',
            'label'     => $this->__('Automatically Create Attribute Options'),
            'title'     => $this->__('Automatically Create Attribute Options'),
            'required'  => false,
            'values'	=> array(
            	0 => $this->__('No'),
            	1 => $this->__('Yes'),
            )
        ));
        
        $fieldset->addField('update_indexes', 'select', array(
            'name'      => 'update_indexes',
            'label'     => $this->__('Update Indexes After Import is Finished Successfully'),
            'title'     => $this->__('Update Indexes After Import is Finished Successfully'),
            'required'  => false,
            'values'	=> array(
            	0 => $this->__('No'),
            	1 => $this->__('Yes'),
            )
        ));
        
        $fieldset->addField('continue_button', 'note', array(
            'text' => $this->getChildHtml('continue_button'),
        ));
        
        return parent::_prepareForm();
        
    }
    
  
}