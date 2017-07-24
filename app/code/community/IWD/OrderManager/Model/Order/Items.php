<?php

class IWD_OrderManager_Model_Order_Items extends Mage_Sales_Model_Order_Item
{
    protected $params;
    protected $needUpdateStock = false;

    public function updateOrderItems($params)
    {
        $this->init($params);

        if (isset($params['confirm_edit']) && !empty($params['confirm_edit'])) {
            $this->addChangesToConfirm();
        } else {
            $status = $this->editItems();
            $this->addChangesToLog();
            if ($status == 1) {
                $this->notifyEmail();
            }
        }
    }

    protected function init($params)
    {
        $this->params = $params;
        if (empty($this->params) || !isset($this->params['order_id'])) {
            throw new Exception("Order id is not defined");
        }
    }

    public function getLogger()
    {
        return Mage::getSingleton('iwd_ordermanager/logger');
    }

    public function getNeedUpdateStock()
    {
        return $this->needUpdateStock;
    }

    protected function addChangesToConfirm()
    {
        /* @var $logger IWD_OrderManager_Model_Logger */
        $logger = $this->getLogger();
        $orderId = $this->params['order_id'];
        $items = $this->params['items'];

        Mage::getModel('iwd_ordermanager/order_estimate')->estimateEditItems($orderId, $items);

        $logger->addCommentToOrderHistory($orderId, 'wait');
        $logger->addLogToLogTable(IWD_OrderManager_Model_Confirm_Options_Type::ITEMS, $orderId, $this->params);

        $message = Mage::helper('iwd_ordermanager')->__('Updates were not applied now! Customer gets email with confirm link. Order will be updated after confirm.');
        Mage::getSingleton('adminhtml/session')->addNotice($message);
    }

    protected function editItems()
    {
        $orderId = isset($this->params['order_id']) ? $this->params['order_id'] : null;
        $items = isset($this->params['items']) ? $this->params['items'] : null;

        /**
         * @var $orderEdit IWD_OrderManager_Model_Order_Edit
         */
        $orderEdit = Mage::getModel('iwd_ordermanager/order_edit');
        $status = $orderEdit->editItems($orderId, $items);
        $this->needUpdateStock = $orderEdit->getNeedUpdateStock();

        $this->updateCoupon();

        return $status;
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

    protected function addChangesToLog()
    {
        /* @var $logger IWD_OrderManager_Model_Logger */
        $logger = $this->getLogger();
        $orderId = $this->params['order_id'];

        $logger->addCommentToOrderHistory($orderId, false);
        $logger->addLogToLogTable(IWD_OrderManager_Model_Confirm_Options_Type::ITEMS, $orderId);
    }

    protected function updateCoupon()
    {
        if (isset($this->params['coupon_code'])) {
            $couponCode = $this->params['coupon_code'];
            $this->loadOrder()->setCouponCode($couponCode)->setDiscountDescription($couponCode)->save();
        }
    }

    /**
     * @return Mage_Sales_Model_Order
     */
    protected function loadOrder()
    {
        $orderId = $this->params['order_id'];
        return Mage::getModel('sales/order')->load($orderId);
    }
}
