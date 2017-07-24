<?php

class IWD_OrderManager_Block_Adminhtml_Sales_Order_View_Tab_Creditmemos extends Mage_Adminhtml_Block_Sales_Order_View_Tab_Creditmemos
{
    protected function _getCollectionClass()
    {
        if ($this->isArchived()) {
            return 'iwd_ordermanager/archive_creditmemo_collection';
        }
        return 'sales/order_creditmemo_grid_collection';
    }

    protected function isArchived()
    {
        $order = $this->getOrder();
        return Mage::getModel('iwd_ordermanager/order')->isArchived($order);
    }
}