<?php

class IWD_OrderManager_Model_Order_Info extends IWD_OrderManager_Model_Order
{
    /**
     * @var array
     */
    protected $params;

    /**
     * @var Mage_Sales_Model_Order_Invoice
     */
    protected $invoice;

    /**
     * @var Mage_Sales_Model_Order_Shipment
     */
    protected $shipment;

    /**
     * @var Mage_Sales_Model_Order_Creditmemo
     */
    protected $creditmemo;

    public function updateOrderInfo($params)
    {
        $this->init($params);
        $this->validation();

        if (isset($this->params['hide_on_front'])) {
            $this->showHideOrderOnFront($this, $this->params['hide_on_front']);
        }

        if (isset($params['confirm_edit']) && !empty($params['confirm_edit'])) {
            $this->addChangesToConfirm();
        } else {
            $this->editInfo();
            $this->updateOrderAmounts();
            $this->addChangesToLog();
            $this->notifyEmail();
        }
    }

    public function showHideOrderOnFront($order, $status)
    {
        $helper = Mage::helper('iwd_ordermanager');
        if ($helper->isAllowHideOrders()) {
            $comment = $status
                ? $helper->__('Order is hidden on front in customer account')
                : $helper->__('Order is shown on front in customer account');

            $order->setIwdOmStatus($status);
            $order->addStatusHistoryComment($comment)
                ->setIsCustomerNotified(false)
                ->setIsVisibleOnFront(false);
            $order->save();
        }
    }

    protected function init($params)
    {
        $this->params = $params;

        if (empty($this->params) || !isset($this->params['order_id'])) {
            throw new Exception("Order id is not defined");
        }

        $this->load($this->params['order_id']);
    }

    protected function validation()
    {
        $this->validateOrderData();
        $this->validateInvoiceData();
        $this->validateCreditmemoData();
        $this->validateShipmentData();
    }

    protected function validateOrderData()
    {
        if (!isset($this->params['created_at']) || empty($this->params['created_at'])) {
            throw new Exception("Order date is empty!");
        }

        if (!isset($this->params['status']) || empty($this->params['status'])) {
            throw new Exception("Order status is empty!");
        }

        if ($this->isAllowChangeOrderState() && (!isset($this->params['state']) || empty($this->params['state']))) {
            throw new Exception("Order state is empty!");
        }

        if (!isset($this->params['store_id']) || empty($this->params['store_id'])) {
            throw new Exception("Store is empty!");
        }

        if (!isset($this->params['increment_id']) || empty($this->params['increment_id'])) {
            throw new Exception("Order number is empty!");
        }
        $incrementId = trim($this->params['increment_id']);
        if ($this->getIncrementId() != $incrementId) {
            $ordersCount = $this->getCollection()->addFieldToFilter('increment_id', $incrementId)->getSize();
            if ($ordersCount != 0) {
                throw new Exception("Order number #$incrementId is already exists");
            }
        }
    }

    protected function validateInvoiceData()
    {
        if (isset($this->params['invoice_id']))
        {
            if (!isset($this->params['invoice_created_at']) || empty($this->params['invoice_created_at'])) {
                throw new Exception("Invoice date is empty!");
            }

            if (!isset($this->params['invoice_status']) || empty($this->params['invoice_status'])) {
                throw new Exception("Invoice status is empty!");
            }

            if (!isset($this->params['invoice_increment_id']) || empty($this->params['invoice_increment_id'])) {
                throw new Exception("Invoice number is empty!");
            }

            $incrementId = trim($this->params['invoice_increment_id']);
            if ($this->getInvoice()->getIncrementId() != $incrementId) {
                $invoiceCount = Mage::getModel('sales/order_invoice')->getCollection()->addFieldToFilter('increment_id', $incrementId)->getSize();
                if ($invoiceCount != 0) {
                    throw new Exception("Invoice number #$incrementId is already exists");
                }
            }
        }
    }

    protected function validateCreditmemoData()
    {
        if (isset($this->params['creditmemo_id'])) {
            if (!isset($this->params['creditmemo_created_at']) || empty($this->params['creditmemo_created_at'])) {
                throw new Exception("Credit memo date is empty!");
            }

            if (!isset($this->params['creditmemo_status']) || empty($this->params['creditmemo_status'])) {
                throw new Exception("Credit memo status is empty!");
            }

            if (!isset($this->params['creditmemo_increment_id']) || empty($this->params['creditmemo_increment_id'])) {
                throw new Exception("Credit memo number is empty!");
            }

            $incrementId = trim($this->params['creditmemo_increment_id']);
            if ($this->getCreditmemo()->getIncrementId() != $incrementId) {
                $creditmemoCount = Mage::getModel('sales/order_creditmemo')->getCollection()->addFieldToFilter('increment_id', $incrementId)->getSize();
                if ($creditmemoCount != 0) {
                    throw new Exception("Credit memo number #$incrementId is already exists");
                }
            }
        }
    }

    protected function validateShipmentData()
    {
        if (isset($this->params['shipping_id'])) {
            if (!isset($this->params['shipping_created_at']) || empty($this->params['shipping_created_at'])) {
                throw new Exception("Shipment date is empty!");
            }

            if (!isset($this->params['shipping_increment_id']) || empty($this->params['shipping_increment_id'])) {
                throw new Exception("Shipment number is empty!");
            }

            $incrementId = trim($this->params['shipping_increment_id']);
            if ($this->getShipment()->getIncrementId() != $incrementId) {
                $shipmentCount = Mage::getModel('sales/order_shipment')->getCollection()->addFieldToFilter('increment_id', $incrementId)->getSize();
                if ($shipmentCount != 0) {
                    throw new Exception("Shipment number #$incrementId is already exists");
                }
            }
        }
    }

    public function execUpdateOrderInfo($params)
    {
        $this->init($params);
        $this->editInfo();
        $this->updateOrderAmounts();
        $this->notifyEmail();

        return true;
    }

    protected function addChangesToLog()
    {
        $orderId = $this->params['order_id'];

        $this->getLogger()->addCommentToOrderHistory($orderId);
        $this->getLogger()->addLogToLogTable(IWD_OrderManager_Model_Confirm_Options_Type::ORDER_INFO, $orderId);
    }

    protected function editInfo()
    {
        $this->updateOrderData();
        $this->updateInvoiceData();
        $this->updateCreditmemoData();
        $this->updateShippingData();
    }

    protected function notifyEmail()
    {
        $notify = isset($this->params['notify']) ? $this->params['notify'] : null;
        $orderId = $this->params['order_id'];

        if ($notify) {
            $message = isset($this->params['comment_text']) ? $this->params['comment_text'] : null;
            $email = isset($this->params['comment_email']) ? $this->params['comment_email'] : null;
            Mage::getModel('iwd_ordermanager/notify_notification')->sendNotifyEmail($orderId, $email, $message);
        }
    }

    protected function addChangesToConfirm()
    {
        $logger = $this->getLogger();
        $orderId = $this->params['order_id'];

        $this->estimateOrderInfoChanges();
        $this->estimateInvoiceInfoChanges();
        $this->estimateCreditmemoInfoChanges();
        $this->estimateShipmentInfoChanges();
        $this->estimateOrderAmounts();

        $logger->addCommentToOrderHistory($orderId, $this->getCommentStatus());
        $logger->addLogToLogTable(IWD_OrderManager_Model_Confirm_Options_Type::ORDER_INFO, $orderId, $this->params);

        $message = Mage::helper('iwd_ordermanager')
            ->__('Updates was not applied now! Customer get email with confirm link. Order will be updated after confirm.');
        Mage::getSingleton('adminhtml/session')->addNotice($message);
    }

    protected function estimateOrderInfoChanges()
    {
        $logger = $this->getLogger();

        if ($this->getIncrementId() != $this->params['increment_id']) {
            $logger->addChangesToLog('order_increment_id', $this->getIncrementId(), $this->params['increment_id']);
        }

        $createdAt = $this->prepareDate($this->params['created_at']);
        if ($this->getCreatedAt() != $createdAt) {
            $logger->addChangesToLog('created_at', $this->getCreatedAt(), $createdAt);
        }

        if ($this->getStatus() != $this->params['status']) {
            $logger->addChangesToLog('order_status', $this->getStatus(), $this->params['status']);
        }

        if ($this->isAllowChangeOrderState() && ($this->getState() != $this->params['state'])) {
            $logger->addChangesToLog('order_state', $this->getState(), $this->params['state']);
        }

        if ($this->getStoreId() != $this->params['store_id']) {
            $newStore = Mage::app()->getStore($this->params['store_id']);
            $oldStore = Mage::app()->getStore($this->getStoreId());
            $logger->addChangesToLog('order_store_name', $oldStore->getName(), $newStore->getName());
        }
    }

    protected function estimateInvoiceInfoChanges()
    {
        if (isset($this->params['invoice_id'])) {
            $logger = $this->getLoggerInvoice();
            $invoice = $this->getInvoice();

            if ($invoice->getIncrementId() != $this->params['invoice_increment_id']) {
                $logger->addChangesToLog('invoice_increment_id', $invoice->getIncrementId(), $this->params['invoice_increment_id']);
            }

            $createdAt = $this->prepareDate($this->params['invoice_created_at']);
            if ($invoice->getCreatedAt() != $createdAt) {
                $logger->addChangesToLog('invoice_created_at', $invoice->getCreatedAt(), $createdAt);
            }

            if ($invoice->getState() != $this->params['invoice_status']) {
                $statuses = Mage::getModel('sales/order_invoice')->getStates();
                $logger->addChangesToLog('invoice_status', $statuses[$invoice->getState()], $statuses[$this->params['invoice_status']]);
            }

            $logger->addCommentToHistory($invoice->getOrderId(), $invoice->getEntityId(), $this->getCommentStatus());
        }
    }

    protected function estimateCreditmemoInfoChanges()
    {
        if (isset($this->params['creditmemo_id'])) {
            $logger = $this->getLoggerCreditmemo();
            $creditmemo = $this->getCreditmemo();

            if ($creditmemo->getIncrementId() != $this->params['creditmemo_increment_id']) {
                $logger->addChangesToLog('creditmemo_increment_id', $creditmemo->getIncrementId(), $this->params['creditmemo_increment_id']);
            }

            $createdAt = $this->prepareDate($this->params['creditmemo_created_at']);
            if ($creditmemo->getCreatedAt() != $createdAt) {
                $logger->addChangesToLog('creditmemo_created_at', $creditmemo->getCreatedAt(), $createdAt);
            }

            if ($creditmemo->getState() != $this->params['creditmemo_status']) {
                $statuses = Mage::getModel('sales/order_creditmemo')->getStates();
                $logger->addChangesToLog('creditmemo_status', $statuses[$creditmemo->getState()], $statuses[$this->params['creditmemo_status']]);
            }

            $logger->addCommentToHistory($creditmemo->getOrderId(), $creditmemo->getEntityId(), $this->getCommentStatus());
        }
    }

    protected function estimateShipmentInfoChanges()
    {
        if (isset($this->params['shipping_id'])) {
            $logger = $this->getLoggerShipment();
            $shipment = $this->getShipment();

            if ($shipment->getIncrementId() != $this->params['shipping_increment_id']) {
                $logger->addChangesToLog('shipping_increment_id', $shipment->getIncrementId(), $this->params['shipping_increment_id']);
            }

            $createdAt = $this->prepareDate($this->params['shipping_created_at']);
            if ($shipment->getCreatedAt() != $createdAt) {
                $logger->addChangesToLog('shipping_created_at', $shipment->getCreatedAt(), $createdAt);
            }

            $logger->addCommentToHistory($shipment->getOrderId(), $shipment->getEntityId(), $this->getCommentStatus());
        }
    }

    protected function getCommentStatus()
    {
        return isset($this->params['confirm_edit']) && !empty($this->params['confirm_edit']) ? 'wait' : false;
    }

    protected function updateOrderData()
    {
        $this->updateOrderItemsState();
        $this->updateOrderState();
        $this->updateOrderStatus();
        $this->updateOrderIncrementId();
        $this->updateOrderStoreId();
        $this->updateOrderDate();
    }

    protected function updateOrderStatus()
    {
        $statusId = $this->params['status'];

        if (!empty($statusId) && $this->getStatus() != $statusId && $statusId !== 'false' && $statusId != false) {
            $this->getLogger()->addChangesToLog('order_status', $this->getStatus(), $statusId);
            $this->setData('status', $statusId)->save();
        }
    }

    protected function updateOrderStoreId()
    {
        $storeId = $this->params['store_id'];

        $newStore = Mage::app()->getStore($storeId);
        $oldStore = Mage::app()->getStore($this->getStoreId());

        if (!empty($storeId) && $this->getStoreId() != $storeId) {
            $this->getLogger()->addChangesToLog('order_store_name', $oldStore->getName(), $newStore->getName());
            $this->setData('store_id', $storeId)->save();
        }
    }

    protected function updateOrderIncrementId()
    {
        $newOrderIncrementId = $this->params['increment_id'];

        if ($this->getIncrementId() != $newOrderIncrementId) {
            $this->setData('increment_id', $newOrderIncrementId)->save();
            $orders =$this->getCollection()->addFieldToFilter('original_increment_id', $newOrderIncrementId);
            foreach ($orders as $order) {
                $order->setData('original_increment_id', $newOrderIncrementId)->save();
            }

            $this->getLogger()->addChangesToLog('order_increment_id', $this->getIncrementId(), $newOrderIncrementId);
        }
    }

    protected function updateOrderState()
    {
        if (isset($this->params['state'])) {
            $stateId = $this->params['state'];

            $allowChangeState = $this->isAllowChangeOrderState();

            if (!empty($stateId) && $this->getState() != $stateId && $allowChangeState) {
                $this->getLogger()->addChangesToLog('order_state', $this->getState(), $stateId);
                $this->setData('state', $stateId)->save();
            }
        }
    }

    protected function updateOrderItemsState()
    {
        try {
            if ($this->getState() == Mage_Sales_Model_Order::STATE_CANCELED) {
                if (isset($this->params['state']) && !empty($this->params['state'])) {
                    if ($this->getState() != $this->params['state']) {
                        $this->restoreCanceledItems();
                    }
                } elseif (isset($this->params['status']) && !empty($this->params['status'])) {
                    $statusCode = $this->params['status'];
                    $state = Mage::getModel('sales/order_status')->getCollection()
                        ->addFieldToFilter('main_table.status', $statusCode)
                        ->joinStates()
                        ->getFirstItem()
                        ->getData("state");

                    if ($this->getState() != $state && Mage_Sales_Model_Order::STATE_CANCELED != $state) {
                        $this->restoreCanceledItems();
                    }
                }
            }
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log($e->getMessage());
        }
    }

    protected function restoreCanceledItems()
    {
        $items = $this->getItemsCollection();
        foreach ($items as $item) {
            $qty = $item->getQtyCanceled();
            $productId = $item->getProductId();

            $item->setQtyCanceled(0.0)
                ->setHiddenTaxCanceled(0.0)
                ->setTaxCanceled(0.0)
                ->save();

            $stockItem = Mage::getModel('cataloginventory/stock_item')->loadByProduct($productId);

            if (Mage::helper('cataloginventory')->isQty($stockItem->getTypeId())) {
                if ($item->getStoreId()) {
                    $stockItem->setStoreId($item->getStoreId());
                }
                if ($stockItem->checkQty($qty)) {
                    $stockItem->subtractQty($qty)->save();
                }
            }
        }
    }

    protected function updateOrderDate()
    {
        if (isset($this->params['created_at'])) {
            $createdAt = $this->params['created_at'];

            if (!empty($createdAt) && $this->getCreatedAt() != $createdAt) {
                $createdAt = $this->prepareDate($createdAt);
                $this->getLogger()->addChangesToLog('created_at', $this->getCreatedAt(), $createdAt);
                $this->setData('created_at', $createdAt)->save();
            }
        }
    }

    /**
     * @return Mage_Core_Model_Abstract|Mage_Sales_Model_Order_Invoice
     */
    protected function getInvoice()
    {
        if (empty($this->invoice)) {
            $id = $this->params['invoice_id'];
            $this->invoice = Mage::getModel('sales/order_invoice')->load($id);
        }
        return $this->invoice;
    }

    /**
     * @return Mage_Core_Model_Abstract|Mage_Sales_Model_Order_Shipment
     */
    protected function getShipment()
    {
        if (empty($this->shipment)) {
            $id = $this->params['shipping_id'];
            $this->shipment = Mage::getModel('sales/order_shipment')->load($id);
        }
        return $this->shipment;
    }

    /**
     * @return Mage_Core_Model_Abstract|Mage_Sales_Model_Order_Creditmemo
     */
    protected function getCreditmemo()
    {
        if (empty($this->creditmemo)) {
            $id = $this->params['creditmemo_id'];
            $this->creditmemo = Mage::getModel('iwd_ordermanager/creditmemo')->load($id);
            $this->creditmemo->disallowDispatchAfterSave();
        }
        return $this->creditmemo;
    }

    protected function updateInvoiceData()
    {
        if (isset($this->params['invoice_id']))
        {
            $this->estimateInvoiceInfoChanges();
            $this->getInvoice()
                ->setData('created_at', $this->prepareDate($this->params['invoice_created_at']))
                ->setData('state',  $this->params['invoice_status'])
                ->setData('increment_id',  $this->params['invoice_increment_id'])
                ->save();
        }
    }

    protected function updateCreditmemoData()
    {
        if (isset($this->params['creditmemo_id']))
        {
            $this->estimateCreditmemoInfoChanges();
            $this->getCreditmemo()
                ->setData('created_at', $this->prepareDate($this->params['creditmemo_created_at']))
                ->setData('state',  $this->params['creditmemo_status'])
                ->setData('increment_id',  $this->params['creditmemo_increment_id'])
                ->save();
        }
    }

    protected function updateShippingData()
    {
        if (isset($this->params['shipping_id']))
        {
            $this->estimateShipmentInfoChanges();
            $this->getShipment()
                ->setData('created_at', $this->prepareDate($this->params['shipping_created_at']))
                ->setData('increment_id',  $this->params['shipping_increment_id'])
                ->save();
        }
    }

    protected function prepareDate($createdAt)
    {
        $myDateTime = DateTime::createFromFormat(Mage::helper('iwd_ordermanager')->getDataTimeFormat(), $createdAt);
        $createdAt = $myDateTime->format('Y-m-d H:i:s');
        return Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s', $createdAt);
    }


    protected function updateOrderAmounts()
    {
        if (isset($this->params['recalculate_amount']) && !empty($this->params['recalculate_amount'])) {
            //TODO: add!!!
        }
    }

    protected function estimateOrderAmounts()
    {
        if (isset($this->params['recalculate_amount']) && !empty($this->params['recalculate_amount'])) {
            $orderId = $this->params['order_id'];
            $order = Mage::getModel('sales/order')->load($orderId);
            Mage::getSingleton('adminhtml/session_quote')->clear();

            $quote = Mage::getModel('adminhtml/sales_order_create')->initFromOrder($order)->getQuote();

            $quote->setData('store_id', $this->params['store_id'])->save();

            $quote = $quote->setTotalsCollectedFlag(false)->collectTotals();

            $totals = array(
                'grand_total' => $quote->getGrandTotal(),
                'base_grand_total' => $quote->getBaseGrandTotal(),
            );

            $this->getLogger()->addNewTotalsToLog($totals);
        }
    }

    /**
     * @return IWD_OrderManager_Model_Logger
     */
    public function getLogger()
    {
        return Mage::getSingleton('iwd_ordermanager/logger');
    }

    /**
     * @return IWD_OrderManager_Model_Logger_Invoice
     */
    public function getLoggerInvoice()
    {
        return Mage::getSingleton('iwd_ordermanager/logger_invoice');
    }

    /**
     * @return IWD_OrderManager_Model_Logger_Creditmemo
     */
    public function getLoggerCreditmemo()
    {
        return Mage::getSingleton('iwd_ordermanager/logger_creditmemo');
    }

    /**
     * @return IWD_OrderManager_Model_Logger_Shipment
     */
    public function getLoggerShipment()
    {
        return Mage::getSingleton('iwd_ordermanager/logger_shipment');
    }
}
