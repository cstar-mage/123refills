<?php

class IWD_OrderManager_Model_Order_Api_Edit extends IWD_OrderManager_Model_Order_Edit
{
    public function getLogger()
    {
        return Mage::getSingleton('iwd_ordermanager/api_logger');
    }

    public function addNewOrderItem($quoteItemId, $item)
    {
        $orderItem = parent::addNewOrderItem($quoteItemId, $item);
        Mage::register('om_api_new_order_item_id', $orderItem->getId());
        return $orderItem;
    }
}