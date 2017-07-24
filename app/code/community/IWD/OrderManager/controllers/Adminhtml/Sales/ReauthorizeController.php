<?php

/**
 * Class IWD_OrderManager_Adminhtml_Sales_ReauthorizeController
 */
class IWD_OrderManager_Adminhtml_Sales_ReauthorizeController extends Mage_Adminhtml_Controller_Action
{
    /**
     * @var Mage_Sales_Model_Order
     */
    protected $order = null;

    /**
     *
     */
    public function reauthorizeAction()
    {
        if ($this->reauthorizePayment()) {
            $this->getOrder()->setData('iwd_backup_id', null)->save();
        }

        $this->_redirect('*/sales_order/view', array('order_id' => $this->getOrderId()));
    }

    /**
     * @return mixed
     */
    protected function getOrderId()
    {
        return Mage::app()->getRequest()->getParam('order_id');
    }

    /**
     * @return Mage_Core_Model_Abstract|Mage_Sales_Model_Order
     */
    protected function getOrder()
    {
        if (empty($this->order)) {
            $orderId = $this->getOrderId();
            $this->order = Mage::getModel('sales/order')->load($orderId);
        }

        return $this->order;
    }

    /**
     * @return mixed
     */
    protected function getOldOrder()
    {
        $backupId = $this->getOrder()->getIwdBackupId();
        return Mage::getModel('iwd_ordermanager/backup_sales')->loadSalesObject($backupId);
    }

    /**
     * @return int
     */
    protected function reauthorizePayment()
    {
        $orderId = $this->getOrderId();
        $oldOrder = $this->getOldOrder();
        /**
         * @var $payment IWD_OrderManager_Model_Order_Edit
         */
        $payment = Mage::getModel('iwd_ordermanager/order_edit');
        return $payment->reauthorizeOrderPayment($orderId, $oldOrder);
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return true;
    }
}
