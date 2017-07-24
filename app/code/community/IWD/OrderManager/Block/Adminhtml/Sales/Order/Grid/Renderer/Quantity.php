<?php

class IWD_OrderManager_Block_Adminhtml_Sales_Order_Grid_Renderer_Quantity extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $order = Mage::getModel('sales/order')->loadByIncrementId($row['increment_id']);
        $items = $order->getAllVisibleItems();

        $qtyOrdered = 0;
        $qtyInvoiced = 0;
        $qtyShipped = 0;
        $qtyRefunded = 0;
        $qtyCanceled = 0;

        foreach ($items as $item) {
            $qtyOrdered += $item['qty_ordered'];
            $qtyInvoiced += $item['qty_invoiced'];
            $qtyShipped += $item['qty_shipped'];
            $qtyRefunded += $item['qty_refunded'];
            $qtyCanceled += $item['qty_canceled'];
        }

        if (Mage::helper('iwd_ordermanager')->isGridExport()) {
            return $this->Export($qtyOrdered, $qtyInvoiced, $qtyShipped, $qtyRefunded, $qtyCanceled);
        }

        return $this->Grid($qtyOrdered, $qtyInvoiced, $qtyShipped, $qtyRefunded, $qtyCanceled);
    }

    private function Grid($qtyOrdered, $qtyInvoiced, $qtyShipped, $qtyRefunded, $qtyCanceled)
    {
        $helper = Mage::helper('iwd_ordermanager');
        $orderQty = "";
        if ($qtyOrdered) {
            $orderQty .= $helper->__('Ordered') . ':&nbsp;' . number_format($qtyOrdered, 0) . '<br/>';
        }
        if ($qtyInvoiced) {
            $orderQty .= $helper->__('Invoiced') . ':&nbsp;' . number_format($qtyInvoiced, 0) . '<br/>';
        }
        if ($qtyShipped) {
            $orderQty .= $helper->__('Shipped') . ':&nbsp;' . number_format($qtyShipped, 0) . '<br/>';
        }
        if ($qtyRefunded) {
            $orderQty .= $helper->__('Refunded') . ':&nbsp;' . number_format($qtyRefunded, 0) . '<br/>';
        }
        if ($qtyCanceled) {
            $orderQty .= $helper->__('Cancelled') . ':&nbsp;' . number_format($qtyCanceled, 0);
        }
        return $orderQty;
    }

    private function Export($qtyOrdered, $qtyInvoiced, $qtyShipped, $qtyRefunded, $qtyCanceled)
    {
        $helper = Mage::helper('iwd_ordermanager');
        $orderQty = "";
        if ($qtyOrdered) {
            $orderQty .= $helper->__('Ordered') . '=' . number_format($qtyOrdered, 0);
        }
        if ($qtyInvoiced) {
            $orderQty .= $helper->__(' Invoiced') . '=' . number_format($qtyInvoiced, 0);
        }
        if ($qtyShipped) {
            $orderQty .= $helper->__(' Shipped') . '=' . number_format($qtyShipped, 0);
        }
        if ($qtyRefunded) {
            $orderQty .= $helper->__(' Refunded') . '=' . number_format($qtyRefunded, 0);
        }
        if ($qtyCanceled) {
            $orderQty .= $helper->__(' Cancelled') . '=' . number_format($qtyCanceled, 0);
        }
        return $orderQty;
    }
}
