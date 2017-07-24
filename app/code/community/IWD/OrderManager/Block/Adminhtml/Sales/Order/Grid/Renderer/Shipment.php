<?php

class IWD_OrderManager_Block_Adminhtml_Sales_Order_Grid_Renderer_Shipment extends IWD_OrderManager_Block_Adminhtml_Sales_Order_Grid_Renderer_Abstract
{
    protected function loadShipments()
    {
        $orderId = $this->getOrderId();

        return Mage::getResourceModel('sales/order_shipment_grid_collection')
            ->addFieldToSelect('increment_id')
            ->addFieldToFilter('main_table.order_id', $orderId)
            ->load();
    }

    protected function prepareShipmentIds()
    {
        $shipments = $this->loadShipments();
        $incrementIds = array();

        foreach ($shipments as $shipment) {
            $incrementIds[] = $shipment->getIncrementId();
        }

        return $incrementIds;
    }

    protected function Grid()
    {
        $incrementIds = $this->prepareShipmentIds();
        return $this->formatBigData($incrementIds);
    }

    protected function Export()
    {
        $incrementIds = $this->prepareShipmentIds();
        return implode(',', $incrementIds);
    }
}