<?php

class EcommerceTeam_FastImport_Block_Adminhtml_Product_Import_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct(){
    	
        parent::__construct();
        
        $this->setId('ecommerceteam_fastimport');
        $this->setDestElementId('edit_form');
        $this->setTitle($this->__('Import Products'));
        
    }
    
    protected function _prepareLayout(){
        
    	$this->addTab('main_section', array(
            'label'     => $this->__('Choose File'),
            'title'     => $this->__('Choose File'),
            'content'   => $this->getLayout()->createBlock('ecommerceteam_fastimport/adminhtml_product_import_tab_file')->toHtml(),
        ));
        
        
    }
       
}