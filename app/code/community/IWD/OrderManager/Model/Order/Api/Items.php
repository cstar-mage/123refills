<?php

class IWD_OrderManager_Model_Order_Api_Items extends IWD_OrderManager_Model_Order_Items
{
    public function getLogger()
    {
        return Mage::getSingleton('iwd_ordermanager/api_logger');
    }

    protected function editItems()
    {
        $orderId = isset($this->params['order_id']) ? $this->params['order_id'] : null;
        $items = isset($this->params['items']) ? $this->params['items'] : null;

        return Mage::getModel('iwd_ordermanager/order_api_edit')->editItems($orderId, $items);
    }
}