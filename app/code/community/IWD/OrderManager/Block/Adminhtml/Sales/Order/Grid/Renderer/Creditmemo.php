<?php

class IWD_OrderManager_Block_Adminhtml_Sales_Order_Grid_Renderer_Creditmemo extends IWD_OrderManager_Block_Adminhtml_Sales_Order_Grid_Renderer_Abstract
{
    protected function loadCreditMemos()
    {
        $orderId = $this->getOrderId();

        return Mage::getResourceModel('sales/order_creditmemo_grid_collection')
            ->addFieldToSelect('increment_id')
            ->addFieldToFilter('main_table.order_id', $orderId)
            ->load();
    }

    protected function prepareCreditMemoIds()
    {
        $creditMemos = $this->loadCreditMemos();
        $incrementIds = array();

        foreach ($creditMemos as $creditmemo) {
            $incrementIds[] = $creditmemo->getIncrementId();
        }

        return $incrementIds;
    }

    protected function Grid()
    {
        $incrementIds = $this->prepareCreditMemoIds();
        return $this->formatBigData($incrementIds);
    }

    protected function Export()
    {
        $incrementIds = $this->prepareCreditMemoIds();
        return implode(',', $incrementIds);
    }
}