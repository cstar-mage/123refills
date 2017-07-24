<?php

class IWD_OrderManager_Block_Adminhtml_Sales_Order_Payment_Form extends Mage_Adminhtml_Block_Sales_Order_Create_Billing_Method_Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('iwd/ordermanager/payment/form.phtml');
    }

    public function getOrder()
    {
        $orderId = $this->getOrderId();
        return Mage::getModel("sales/order")->load($orderId);
    }

    /**
     * @return int
     */
    protected function getOrderId()
    {
        return Mage::app()->getRequest()->getParam('order_id', 0);
    }

    public function getQuote()
    {
        $orderId = $this->getOrderId();
        if (!isset($orderId) || empty($orderId)) {
            return parent::getQuote();
        }

        $order = Mage::getModel("sales/order")->load($orderId);
        if (empty($order)) {
            return null;
        }

        $data = $order->getData();
        if (empty($data)) {
            return null;
        }

        $quote = Mage::getModel('sales/quote')->setStore($order->getStore())->load($order->getQuoteId());
        if (!empty($quote)) {
            $entityId = $quote->getEntityId();
            if (!empty($entityId)) {
                return $quote;
            }
        }

        $quote = Mage::getModel('iwd_ordermanager/order_converter')->convertOrderToQuote($orderId);
        if (empty($quote)) {
            return null;
        }

        $quote->setBaseSubtotal($order->getBaseSubtotal());

        return $quote;
    }
}
