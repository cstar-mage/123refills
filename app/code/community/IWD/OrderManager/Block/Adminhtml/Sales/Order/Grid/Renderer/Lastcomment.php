<?php

class IWD_OrderManager_Block_Adminhtml_Sales_Order_Grid_Renderer_Lastcomment extends IWD_OrderManager_Block_Adminhtml_Sales_Order_Grid_Renderer_Longstring
{
    protected function loadItems()
    {
        $orderId = $this->getOrderId();

        $item = Mage::getModel('sales/order_status_history')->getCollection()
            ->addFieldToSelect('comment')
            ->addFieldToFilter('comment', array('neq' => 'NULL'))
            ->addFieldToFilter('parent_id', $orderId)
            ->setOrder('entity_id', 'DESC')
            ->setOrder('created_at', 'DESC')
            ->getFirstItem();
        return $item->getComment();
    }

    protected function Grid()
    {
        return $this->wrapper($this->loadItems());
    }

    protected function Export()
    {
        return $this->loadItems();
    }
}
