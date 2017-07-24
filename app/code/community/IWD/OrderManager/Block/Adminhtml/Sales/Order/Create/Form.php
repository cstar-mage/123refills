<?php

class IWD_OrderManager_Block_Adminhtml_Sales_Order_Create_Form extends Mage_Adminhtml_Block_Sales_Order_Create_Form
{
    public function _toHtml()
    {
        if (Mage::helper('iwd_ordermanager')->isCustomCreationProcess()) {
            $this->insert('top_actions', 'form');
            $this->setTemplate('iwd/ordermanager/create/form.phtml');
        }
        return parent::_toHtml();
    }

    public function getDefaultStoreView()
    {
        return Mage::getStoreConfig('iwd_ordermanager/crate_process/default_store');
    }
}