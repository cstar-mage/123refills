<?php 
class Mage_Uploadtool_Block_Adminhtml_Diamondinquiries_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Init class
     */
    public function __construct()
    {  
    	parent::__construct();
        $this->_blockGroup = 'uploadtool';
        $this->_controller = 'adminhtml_diamondinquiries';

        $this->_updateButton('save', 'label', $this->__('Save Diamondinquiries'));
        $this->_updateButton('delete', 'label', $this->__('Delete Diamondinquiries'));
        
    }  
     
    
    protected function _prepareLayout()
    {
    	return parent::_prepareLayout();
    }
    
    /**
     * Get Header text
     *
     * @return string
     */
    public function getHeaderText()
    {  
    	//return $this->__('Edit Diamondinquiries');
        if (Mage::registry('uploadtool')->getId()) {
            return $this->__('Edit Diamondinquiries');
        }  
        else {
            return $this->__('New Diamondinquiries');
        }  
    }  
}