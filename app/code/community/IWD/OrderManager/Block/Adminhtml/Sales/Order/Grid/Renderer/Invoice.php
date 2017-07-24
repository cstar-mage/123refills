<?php

class IWD_OrderManager_Block_Adminhtml_Sales_Order_Grid_Renderer_Invoice extends IWD_OrderManager_Block_Adminhtml_Sales_Order_Grid_Renderer_Abstract
{
    protected function loadInvoices()
    {
        $orderId = $this->getOrderId();

        return Mage::getResourceModel('sales/order_invoice_grid_collection')
            ->addFieldToSelect('increment_id')
            ->addFieldToFilter('main_table.order_id', $orderId)
            ->load();
    }

    protected function prepareInvoiceIds()
    {
        $invoices = $this->loadInvoices();
        $incrementIds = array();

        foreach ($invoices as $invoice) {
            $incrementIds[] = $invoice->getIncrementId();
        }

        return $incrementIds;
    }

    protected function Grid()
    {
        $incrementIds = $this->prepareInvoiceIds();
        return $this->formatBigData($incrementIds);
    }

    protected function Export()
    {
        $incrementIds = $this->prepareInvoiceIds();
        return implode(',', $incrementIds);
    }
}