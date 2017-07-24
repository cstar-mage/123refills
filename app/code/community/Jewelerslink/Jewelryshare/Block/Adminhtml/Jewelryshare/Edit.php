<?php

class Jewelerslink_Jewelryshare_Block_Adminhtml_Jewelryshare_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'jewelryshare';
        $this->_controller = 'adminhtml_jewelryshare';
        $this->_removeButton('reset');
        $this->_removeButton('back');
        $this->_updateButton('save', 'label', Mage::helper('jewelryshare')->__('Save'));
		
        $this->_addButton('disable_older', array(
        		'label'     => Mage::helper('adminhtml')->__('Delete Old Products'),
        		'onclick'   => 'setLocation(\''.$this->getUrl('jewelryshare/adminhtml_jewelryshare/disableOlder', array('_current'=>true)).'\')',
        		'class'     => 'delete',
        ), -100);
        
        $this->_addButton('restore_price_increase', array(
        		'label'     => Mage::helper('adminhtml')->__('Restore Price Increase'),
        		'onclick'   => 'setLocation(\''.$this->getUrl('jewelryshare/adminhtml_jewelryshare/restorePriceIncrease', array('_current'=>true)).'\')',
        		'class'     => 'delete',
        ), -100);
    }
    
    protected function _prepareLayout()
    {
    	return parent::_prepareLayout();
    }

    public function getHeaderText()
    {
        return Mage::helper('jewelryshare')->__('Manage Jewelry');
    }
}