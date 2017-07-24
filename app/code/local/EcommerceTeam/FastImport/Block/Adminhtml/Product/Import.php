<?php
	class EcommerceTeam_FastImport_Block_Adminhtml_Product_Import extends Mage_Adminhtml_Block_Widget_Form_Container{
		
		public function __construct(){
    	
        	parent::__construct();
        	$this->_blockGroup	= 'ecommerceteam_fastimport';
        	$this->_controller	= 'adminhtml_product';
    		$this->_mode 		= 'import';
    		
    		$this->_buttons = array();
    	}
		
		public function getHeaderText(){
	    	
	        return $this->__('Products Import');
	        
	    }
		
	}
