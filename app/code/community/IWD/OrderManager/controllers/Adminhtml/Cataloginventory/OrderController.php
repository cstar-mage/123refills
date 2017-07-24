<?php

/**
 * Class IWD_OrderManager_Adminhtml_Cataloginventory_OrderController
 */
class IWD_OrderManager_Adminhtml_Cataloginventory_OrderController extends IWD_OrderManager_Controller_Abstract
{
    /**
     * @return array
     */
    protected function getForm()
    {
        return array(
            'status' => 1,
            'form' => $this->prepareStocksForm()
        );
    }

    /**
     * @return mixed
     */
    protected function prepareStocksForm()
    {
        $orderId = $this->getRequest()->getPost('order_id');
        $isOrderView = $this->getRequest()->getPost('order_view', 0);

        return $this->getLayout()
            ->createBlock('iwd_ordermanager/adminhtml_cataloginventory_order_stock')
            ->setData('order_id', $orderId)
            ->setIsOrderView($isOrderView)
            ->toHtml();
    }

    /**
     * @return array
     */
    protected function updateInfo()
    {
        $this->updateStocks();

        $reload = $this->getRequest()->getPost('reload', false);

        $result = array(
            'status' => 1,
        );

        if ($reload) {
            $result['reload'] = 1;
        } else {
            $result['info'] = $this->prepareAssignedStocks();
        }

        return $result;
    }

    /**
     * @return mixed
     */
    protected function updateStocks()
    {
        $stockItem = $this->getRequest()->getPost('stock_item', array());
        $items = $this->getRequest()->getPost('item', array());
        $orderId = $this->getRequest()->getPost('order_id');

        $orderStockItems = Mage::getModel('iwd_ordermanager/cataloginventory_stock_order_item');
        $orderStockItems->updateStocks($stockItem);

        return $orderStockItems->updateAssignedStockOrderItems($items, $orderId);
    }

    /**
     * @return mixed
     */
    protected function prepareAssignedStocks()
    {
        $isOrderViewPage = $this->getRequest()->getPost('order_view', 0);

        $orderId = $this->getOrder()->getId();
        $block = Mage::getBlockSingleton('iwd_ordermanager/adminhtml_sales_order_grid_renderer_inventory');

        return $block->getStockMessageForOrder($orderId, $isOrderViewPage);
    }

    /**
     * @return mixed
     */
    protected function _isAllowed()
    {
        return Mage::helper('iwd_ordermanager')->isMultiInventoryEnable();
    }
}