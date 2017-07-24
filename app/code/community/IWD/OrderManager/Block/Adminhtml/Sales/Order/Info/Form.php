<?php

class IWD_OrderManager_Block_Adminhtml_Sales_Order_Info_Form extends Mage_Adminhtml_Block_Widget
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('iwd/ordermanager/info/form.phtml');
    }

    public function getOrderStatusList()
    {
        return Mage::getModel('sales/order_status')->getResourceCollection()->getData();
    }

    public function getOrderStateList()
    {
        $helper = Mage::helper('iwd_ordermanager');
        return array('new' => $helper->__('New'),
            'pending_payment' => $helper->__('Pending Payment'),
            'processing' => $helper->__('Processing'),
            'complete' => $helper->__('Complete'),
            'closed' => $helper->__('Closed'),
            'canceled' => $helper->__('Canceled'),
            'holded' => $helper->__('Holded'),
            'payment_review' => $helper->__('Payment Review')
        );
    }

    public function getInvoiceStatusList()
    {
        return Mage::getModel('sales/order_invoice')->getStates();
    }

    public function getCreditMemoStatusList()
    {
        return Mage::getModel('sales/order_creditmemo')->getStates();
    }

    public function getInvoiceId()
    {
        return Mage::app()->getRequest()->getParam('invoice_id', null);
    }

    public function getCreditmemoId()
    {
        return Mage::app()->getRequest()->getParam('creditmemo_id', null);
    }

    public function getShippingId()
    {
        return Mage::app()->getRequest()->getParam('shipping_id', null);
    }

    public function isInvoicePage()
    {
        $id = $this->getInvoiceId();
        return !empty($id);
    }

    public function isCreditmemoPage()
    {
        $id = $this->getCreditmemoId();
        return !empty($id);
    }

    public function isShippingPage()
    {
        $id = $this->getShippingId();
        return !empty($id);
    }

    public function getShipping()
    {
        try {
            $id = $this->getShippingId();
            return Mage::getModel('sales/order_shipment')->load($id);
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log($e->getMessage());
        }

        return null;
    }

    public function getInvoice()
    {
        try {
            $id = $this->getInvoiceId();
            return Mage::getModel('sales/order_invoice')->load($id);
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log($e->getMessage());
        }

        return null;
    }

    public function getCreditMemo()
    {
        try {
            $id = $this->getCreditmemoId();
            return Mage::getModel('sales/order_creditmemo')->load($id);
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log($e->getMessage());
        }

        return null;
    }
}
