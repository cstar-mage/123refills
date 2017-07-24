<?php

class IWD_OrderManager_Block_Adminhtml_Sales_Order_View_Tab_Invoices extends Mage_Adminhtml_Block_Sales_Order_View_Tab_Invoices
{
    protected function _getCollectionClass()
    {
        if ($this->isArchived()) {
            return 'iwd_ordermanager/archive_invoice_collection';
        }
        return 'sales/order_invoice_grid_collection';
    }

    protected function isArchived()
    {
        $order = $this->getOrder();
        return Mage::getModel('iwd_ordermanager/order')->isArchived($order);
    }
}