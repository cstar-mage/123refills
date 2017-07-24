<?php

class IWD_OrderManager_Block_Adminhtml_Sales_Order_Grid_Renderer_Items extends IWD_OrderManager_Block_Adminhtml_Sales_Order_Grid_Renderer_Abstract
{
    protected function loadItems()
    {
        $orderId = $this->getOrderId();
        $order = Mage::getModel('sales/order')->load($orderId);
        $orderItemCollection = $order->getAllVisibleItems();
        $items = array();

        foreach ($orderItemCollection as $item) {
            $url = Mage::helper('adminhtml')->getUrl('adminhtml/catalog_product/edit', array('id' => $item->getProductId()));
            $items[] = '<a href="' . $url . '" target="_blank">' . $item->getName() . '</a>';
        }

        return $items;
    }

    protected function Grid()
    {
        $items = $this->loadItems();
        return $this->formatBigData($items);
    }

    protected function Export()
    {
        $items = $this->loadItems();
        return implode(',', $items);
    }
}
