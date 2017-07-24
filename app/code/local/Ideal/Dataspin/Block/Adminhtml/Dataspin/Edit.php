<?php

class Ideal_Dataspin_Block_Adminhtml_Dataspin_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'dataspin';
        $this->_controller = 'adminhtml_dataspin';
        
        $this->_updateButton('save', 'label', Mage::helper('dataspin')->__('Save & Apply'));
        //$this->_updateButton('delete', 'label', Mage::helper('dataspin')->__('Delete Item'));
		
        $this->removeButton('back');
        //$this->removeButton('save');
        $this->removeButton('delete');
        $this->removeButton('reset');
		
		$this->_formScripts[] = "
		jQuery('#dataspin_products_massaction-form').css('display','none');
		";
		
		
		/*
		 $this->_formScripts[] = "
            jQuery(document).ready(function(){
			    jQuery('#in_dataspin_products').val(''); 
			    jQuery('.checkbox').change(function() {
					if(jQuery(this).is(':checked')){
					    var currentId =  jQuery(this).val();
						var includedVal = jQuery('#in_dataspin_products').val();
						if(includedVal !== '')
						{
							jQuery('#in_dataspin_products').val(includedVal + ',' + currentId);
						}else{
							jQuery('#in_dataspin_products').val(currentId);
						}
					}else{
						var exid = jQuery('#in_dataspin_products').val();
						var currentId =  jQuery(this).val();
						if(exid !== '')
						{
							var new_val = removeValue(exid,currentId);
							jQuery('#in_dataspin_products').val(new_val);
						}else{
							jQuery('#in_dataspin_products').val(currentId);
						}
					}
				});
				
				function removeValue(list, value) {
					return list.replace(new RegExp(',?' + value + ',?'), function(match) {
						var first_comma = match.charAt(0) === ',',
							second_comma;				
						if (first_comma &&
							(second_comma = match.charAt(match.length - 1) === ',')) {
						  return ',';
						}
						return '';
					});
				};
				
			});        
        "; */
        
        /* $this->_addButton('apply_to_product', array(
        		'label'     => Mage::helper('adminhtml')->__('Apply To Products'),
        		'onclick'   => 'setLocation(\''.$this->getUrl('adminhtml/dataspin/applyToProducts', array('_current'=>true)).'\')',
        		'class'     => 'go',
        ), -100); */
    }

    public function getHeaderText()
    {
    	return Mage::helper('dataspin')->__('Data Spin Templates');
        
    }
}