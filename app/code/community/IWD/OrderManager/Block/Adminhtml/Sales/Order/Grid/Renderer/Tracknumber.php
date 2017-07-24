<?php

class IWD_OrderManager_Block_Adminhtml_Sales_Order_Grid_Renderer_Tracknumber extends IWD_OrderManager_Block_Adminhtml_Sales_Order_Grid_Renderer_Abstract
{
    protected function loadTrackNumbers()
    {
        $orderId = $this->getOrderId();

        return Mage::getResourceModel('sales/order_shipment_track_collection')
            ->addFieldToSelect('track_number')
            ->addFieldToFilter('main_table.order_id', $orderId)
            ->load();
    }

    protected function prepareTrackNumbers()
    {
        $numbers = $this->loadTrackNumbers();
        $trackNumbers = array();

        foreach ($numbers as $number) {
            $trackNumbers[] = $number->getTrackNumber();
        }

        return $trackNumbers;
    }

    protected function Grid()
    {
        $ids = $this->prepareTrackNumbers();
        return $this->formatBigData($ids);
    }

    protected function Export()
    {
        $ids = $this->prepareTrackNumbers();
        return implode(',', $ids);
    }
}