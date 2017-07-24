<?php

class IWD_OrderManager_Block_Adminhtml_Sales_Order_Create_Data extends Mage_Adminhtml_Block_Sales_Order_Create_Data
{
    public function _toHtml()
    {
        if (Mage::helper('iwd_ordermanager')->isCustomCreationProcess()) {
            $this->setTemplate('iwd/ordermanager/create/data.phtml');
        }
        return parent::_toHtml();
    }
}