<?php

class IWD_OrderManager_Block_Adminhtml_Cataloginventory_Stock_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'stock_id';
        $this->_blockGroup = 'iwd_ordermanager';
        $this->_controller = 'adminhtml_cataloginventory_stock';

        $this->_updateButton('save', 'label', Mage::helper('iwd_ordermanager')->__('Save Source'));

        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick' => "editForm.submit($('edit_form').action+'back/edit/')",
            'class' => 'save',
        ), -100, 100);
    }

    public function getHeaderText()
    {
        if ($this->isEdit()) {
            $stockData = $this->getStockData();
            return Mage::helper('iwd_ordermanager')
                ->__("Edit Source '%s' (ID: %s)", $stockData->getStockName(), $stockData->getStockId());
        }

        return Mage::helper('iwd_ordermanager')->__('Add New Source');
    }

    protected function isEdit()
    {
        return $this->getStockData() && $this->getStockData()->getStockId();
    }

    public function getValidationUrl()
    {
        return $this->getUrl('*/*/validate', array('_current'=>true));
    }

    protected function getStockData()
    {
        return Mage::registry('iwd_om_stock_data');
    }
}