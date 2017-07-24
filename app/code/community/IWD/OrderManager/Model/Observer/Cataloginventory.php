<?php

/**
 * Class IWD_OrderManager_Model_Observer_Cataloginventory
 */
class IWD_OrderManager_Model_Observer_Cataloginventory
{
    /**
     * @param Varien_Event_Observer $observer
     */
    public function saveInventoryData(Varien_Event_Observer $observer)
    {
        if (!Mage::helper('iwd_ordermanager')->isMultiInventoryEnable()) {
            return;
        }

        $stocks = Mage::app()->getRequest()->getParam('product', array());
        if (!isset($stocks['stocks_data'])) {
            return;
        }

        $product = $observer->getEvent()->getProduct();
        $productId = $product->getId();
        $stocks = $stocks['stocks_data'];

        foreach ($stocks as $id => $stock) {
            $stockItem = $this->getStockItem($id, $productId);

            $stockItem->setProduct($product);
            $stockItem = $this->prepareItemForSave($stockItem, $stock);
            $stockItem->setData('stock_id', $id);
            $stockItem->setData('product_id', $productId);

            $stockItem->save();
        }
    }

    /**
     * @param $stockId
     * @param $productId
     * @return Mage_CatalogInventory_Model_Stock_Item
     */
    protected function getStockItem($stockId, $productId)
    {
        $stockItem = Mage::getModel('cataloginventory/stock_item')->getCollection()
            ->addFieldToFilter('stock_id', $stockId)
            ->addFieldToFilter('product_id', $productId);

        return $stockItem->getFirstitem();
    }

    /**
     * @param $item
     * @param $stock
     * @return mixed
     */
    protected function prepareItemForSave($item, $stock)
    {
        $item->addData($stock);

        if (!isset($stock['use_config_manage_stock']) || is_null($stock['use_config_manage_stock'])) {
            $item->setData('use_config_manage_stock', false);
        }

        if (isset($stock['min_qty']) && !is_null($stock['min_qty'])
            && (!isset($stock['use_config_min_qty']) || is_null($stock['use_config_min_qty']))) {
            $item->setData('use_config_min_qty', false);
        }

        if (isset($stock['min_sale_qty']) && !is_null($stock['min_sale_qty'])
            && (!isset($stock['use_config_min_sale_qty']) || is_null($stock['use_config_min_sale_qty']))) {
            $item->setData('use_config_min_sale_qty', false);
        }

        if (isset($stock['max_sale_qty']) && !is_null($stock['max_sale_qty'])
            && (!isset($stock['use_config_max_sale_qty']) || is_null($stock['use_config_max_sale_qty']))) {
            $item->setData('use_config_max_sale_qty', false);
        }

        if (isset($stock['backorders']) && !is_null($stock['backorders'])
            && (!isset($stock['use_config_backorders']) || is_null($stock['use_config_backorders']))) {
            $item->setData('use_config_backorders', false);
        }

        if (isset($stock['notify_stock_qty']) && !is_null($stock['notify_stock_qty'])
            && (!isset($stock['use_config_notify_stock_qty']) || is_null($stock['use_config_notify_stock_qty']))) {
            $item->setData('use_config_notify_stock_qty', false);
        }

        if (isset($stock['original_inventory_qty']) && !is_null($stock['original_inventory_qty'])
            && strlen($stock['original_inventory_qty']) > 0) {
            $item->setQtyCorrection($item->getQty() - $stock['original_inventory_qty']);
        }

        if (isset($stock['enable_qty_increments']) && !is_null($stock['enable_qty_increments'])
            && (!isset($stock['use_config_enable_qty_inc']) || is_null($stock['use_config_enable_qty_inc']))) {
            $item->setData('use_config_enable_qty_inc', false);
        }

        if (isset($stock['qty_increments']) && !is_null($stock['qty_increments'])
            && (!isset($stock['use_config_qty_increments']) || is_null($stock['use_config_qty_increments']))) {
            $item->setData('use_config_qty_increments', false);
        }

        return $item;
    }

    /**
     * @param Varien_Event_Observer $observer
     */
    public function placeOrder(Varien_Event_Observer $observer)
    {
        if (!Mage::helper('iwd_ordermanager')->isMultiInventoryEnable()) {
            return;
        }

        $orderId = $observer->getEvent()->getOrder()->getId();
        Mage::getModel('iwd_ordermanager/cataloginventory_stock_order')
            ->updateStockOrder($orderId);
    }

    /**
     * @param Varien_Event_Observer $observer
     */
    public function afterCreateRefund(Varien_Event_Observer $observer)
    {
        if (!Mage::helper('iwd_ordermanager')->isMultiInventoryEnable()) {
            return;
        }

        $creditmemo = $observer->getEvent()->getCreditmemo();

        $orderId = $creditmemo->getOrderId();
        $stockOrder = Mage::getModel('iwd_ordermanager/cataloginventory_stock_order');
        $stockOrderItem = Mage::getModel('iwd_ordermanager/cataloginventory_stock_order_item');

        /* update iwd_cataloginventory_stock_order */
        $assigned = $stockOrderItem->getOrderQtyAssigned($orderId);
        $ordered = $stockOrderItem->getQtyOrdered($orderId) - $creditmemo->getQty();
        $stockOrder->updateStockOrder($orderId, $assigned, $ordered);

        foreach ($creditmemo->getItemsCollection() as $item) {
            $orderItem = $item->getOrderItem();
            $stockOrderItem->updateStockOrderItemIfOneStockAssignedOnly($orderItem, $item->getQty() * -1);
        }
    }


    /**
     * @param Varien_Event_Observer $observer
     */
    public function afterCancelRefund(Varien_Event_Observer $observer)
    {
        if (!Mage::helper('iwd_ordermanager')->isMultiInventoryEnable()) {
            return;
        }

        $creditmemo = $observer->getEvent()->getCreditmemo();

        $orderId = $creditmemo->getOrderId();
        $stockOrder = Mage::getModel('iwd_ordermanager/cataloginventory_stock_order');
        $stockOrderItem = Mage::getModel('iwd_ordermanager/cataloginventory_stock_order_item');

        /* update iwd_cataloginventory_stock_order */
        $assigned = $stockOrderItem->getOrderQtyAssigned($orderId);
        $ordered = $stockOrderItem->getQtyOrdered($orderId) + $this->getCreditmemoQty($creditmemo);

        $stockOrder->updateStockOrder($orderId, $assigned, $ordered);
    }

    /**
     * @param $creditmemo
     * @return int
     */
    protected function getCreditmemoQty($creditmemo)
    {
        $qty = 0;
        foreach ($creditmemo->getAllItems() as $item) {
            $qty += $item->getQty();
        }

        return $qty;
    }

    /**
     * @param Varien_Event_Observer $observer
     */
    public function cancelOrder(Varien_Event_Observer $observer)
    {
        if (!Mage::helper('iwd_ordermanager')->isMultiInventoryEnable()) {
            return;
        }

        $stockOrder = Mage::getModel('iwd_ordermanager/cataloginventory_stock_order');
        $stockOrderItem = Mage::getModel('iwd_ordermanager/cataloginventory_stock_order_item');

        $orderId = $observer->getEvent()->getOrder()->getId();
        $assigned = $stockOrderItem->getOrderQtyAssigned($orderId);

        $stockOrder->updateStockOrder($orderId, $assigned, 0);
    }

    /**
     * @param Varien_Event_Observer $observer
     * @return $this
     */
    public function cancelOrderItem(Varien_Event_Observer $observer)
    {
        if (!Mage::helper('iwd_ordermanager')->isMultiInventoryEnable()) {
            return $this;
        }

        $item = $observer->getEvent()->getItem();
        $children = $item->getChildrenItems();

        if ($item->getId() && empty($children)) {
            $stockOrderItem = Mage::getModel('iwd_ordermanager/cataloginventory_stock_order_item');
            $assignedItems = $stockOrderItem->getStocksForOrderItem($item->getId());

            foreach ($assignedItems as $assigned) {
                $stockItem = Mage::getModel('cataloginventory/stock_item')->getCollection()
                    ->addFieldToFilter('product_id', $assigned['product_id'])
                    ->addFieldToFilter('stock_id', $assigned['stock_id'])
                    ->getFirstItem();

                if ($stockItem) {
                    $qty = $assigned['qty_stock_assigned'] * 1.0;
                    $stockItem->addQty($qty)->save();
                }
            }
        }

        return $this;
    }

    /**
     * @param Varien_Event_Observer $observer
     */
    public function afterEditItems(Varien_Event_Observer $observer)
    {
        if (!Mage::helper('iwd_ordermanager')->isMultiInventoryEnable()) {
            return;
        }

        $stockOrder = Mage::getModel('iwd_ordermanager/cataloginventory_stock_order');
        $stockOrderItem = Mage::getModel('iwd_ordermanager/cataloginventory_stock_order_item');

        $orderId = $observer->getEvent()->getOrder()->getId();
        $assigned = $stockOrderItem->getOrderQtyAssigned($orderId);
        $ordered = $stockOrderItem->getQtyOrdered($orderId);

        $stockOrder->updateStockOrder($orderId, $assigned, $ordered);
    }
}
