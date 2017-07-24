<?php

class IWD_OrderManager_Model_Observer_OrderCollection
{
    public function hideOrderOnFront($observer)
    {
        if ($this->isFilterHiddenOrders()) {
            $order = $observer->getOrder();
            $order->setId(null);
            $order->setData(array());
        }
    }

    public function hideOrdersOnFront($observer)
    {
        if ($this->isFilterHiddenOrders()) {
            $collection = $observer->getOrderCollection();
            $collection->addFieldToFilter('iwd_om_status', array(array('eq' => 0), array('null' => 0)));
        }
    }

    protected function isFilterHiddenOrders()
    {
        return Mage::helper('iwd_ordermanager')->isAllowHideOrders();
    }
}
