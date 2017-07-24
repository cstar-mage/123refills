<?php

class IWD_OrderManager_Model_Shipment extends Mage_Sales_Model_Order_Shipment
{
    const XML_PATH_SALES_ALLOW_DEL_SHIPMENTS = 'iwd_ordermanager/iwd_delete_shipments/allow_del_shipments';

    public function isAllowDeleteShipments()
    {
        $confAllow = Mage::getStoreConfig(self::XML_PATH_SALES_ALLOW_DEL_SHIPMENTS, Mage::app()->getStore());
        $permissionAllow = Mage::getSingleton('admin/session')->isAllowed('iwd_ordermanager/shipment/actions/delete');
        $engine = Mage::helper('iwd_ordermanager')->CheckShipmentTableEngine();

        return ($confAllow && $permissionAllow && $engine);
    }

    public function DeleteShipment()
    {
        if (!$this->isAllowDeleteShipments()) {
            Mage::getSingleton('iwd_ordermanager/logger')->itemDeleteError('shipment', $this->getIncrementId());
            return false;
        }

        Mage::dispatchEvent('iwd_ordermanager_sales_shipment_delete_after', array('shipment' => $this, 'shipment_items' => $this->getItemsCollection()));

        $order = Mage::getModel('sales/order')->load($this->getOrderId());

        $this->updateOrderShippedQty();

        Mage::getSingleton('iwd_ordermanager/logger')->itemDeleteSuccess('shipment', $this->getIncrementId());

        $items = $this->getItemsCollection();
        $obj = $this;

        Mage::register('isSecureArea', true);
        $this->delete();
        $this->deleteFromGrid();
        Mage::unregister('isSecureArea');

        $this->updateShippingReport($order, $obj);
        $this->changeOrderStatusAfterDeleteShipment($order);

        Mage::dispatchEvent('iwd_ordermanager_sales_shipment_delete_before', array('shipment' => $obj, 'shipment_items' => $items));

        return true;
    }

    protected function deleteFromGrid()
    {
        try {
            $resource = Mage::getSingleton('core/resource');
            $readConnection = $resource->getConnection('core_read');
            $tableName = $resource->getTableName('sales_flat_shipment_grid');
            $query = 'DELETE FROM `' . $tableName . '` WHERE `' . $tableName . '`.`entity_id` = ' . $this->getEntityId();
            $readConnection->fetchAll($query);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    protected function updateShippingReport($order, $shipping)
    {
        Mage::getSingleton('iwd_ordermanager/report')
            ->addShippingPeriod($shipping->getCreatedAt(), $shipping->getUpdatedAt(), $order->getCreatedAt());
    }

    protected function updateOrderShippedQty()
    {
        $shipmentItems = Mage::getResourceModel('sales/order_shipment_item_collection')
            ->addFieldToFilter('parent_id', $this->getEntityId())
            ->load();

        foreach ($shipmentItems as $shipmentItem) {
            $orderItems = Mage::getModel('sales/order_item')->getCollection()
                ->addFieldToFilter('order_id', $this->getOrderId())
                ->addFieldToFilter('item_id', $shipmentItem->getOrderItemId());

            foreach ($orderItems as $orderItem) {
                $qty = $orderItem->getQtyShipped() - $shipmentItem['qty'];
                $orderItem->setQtyShipped($qty);
                $orderItem->save();
            }
        }
    }

    protected function changeOrderStatusAfterDeleteShipment($order)
    {
        $message = Mage::helper('iwd_ordermanager')->__('State was changed after deletion shipment');
        $state = ($order->hasInvoices()) ? Mage_Sales_Model_Order::STATE_PROCESSING : Mage_Sales_Model_Order::STATE_NEW;

        $order->setState($state, true, $message);
        $order->save();
    }
}
