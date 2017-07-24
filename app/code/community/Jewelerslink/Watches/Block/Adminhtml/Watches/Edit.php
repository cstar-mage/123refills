<?php

class Jewelerslink_Watches_Block_Adminhtml_Watches_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'watches';
        $this->_controller = 'adminhtml_watches';
        $this->_removeButton('reset');
        $this->_removeButton('back');
        $this->_updateButton('save', 'label', Mage::helper('watches')->__('Save'));
		
        /* $this->_addButton('disable_older', array(
        		'label'     => Mage::helper('adminhtml')->__('Disable Old Products'),
        		'onclick'   => 'setLocation(\''.$this->getUrl('watches/adminhtml_watches/disableOlder', array('_current'=>true)).'\')',
        		'class'     => 'delete',
        ), -100); */
        
        $this->_addButton('restore_price_increase', array(
        		'label'     => Mage::helper('adminhtml')->__('Restore Price Increase'),
        		'onclick'   => 'setLocation(\''.$this->getUrl('adminhtml/watches/restorePriceIncrease', array('_current'=>true)).'\')',
        		'class'     => 'delete',
        ), -100);
    }
    
    protected function _prepareLayout()
    {
    	return parent::_prepareLayout();
    }

    public function getHeaderText()
    {
        return Mage::helper('watches')->__('Manage Watches');
    }
}