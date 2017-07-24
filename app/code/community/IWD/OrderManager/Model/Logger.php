<?php

/**
 * Class IWD_OrderManager_Model_Logger
 */
class IWD_OrderManager_Model_Logger extends IWD_OrderManager_Model_Logger_Abstract
{
    const CONFIG_XML_PATH_CONFIRM_STATUS_CANCEL = 'iwd_ordermanager/edit/confirm_cancel_status';
    const CONFIG_XML_PATH_CONFIRM_STATUS_SUCCESS = 'iwd_ordermanager/edit/confirm_success_status';
    const CONFIG_XML_PATH_CONFIRM_STATUS_WAIT = 'iwd_ordermanager/edit/confirm_wait_status';
    const CONFIG_XPATH_IS_COMMENT_VISIBLE = 'iwd_ordermanager/edit/is_visible_comment_on_front';

    /**
     * @param $orderId
     * @param bool|false $status
     * @param bool|false $isCustomerNotified
     */
    public function addCommentToOrderHistory($orderId, $status = false, $isCustomerNotified = false)
    {
        $this->getLogOutput($orderId);
        if (empty($this->logOutput)) {
            return;
        }

        $isCustomerNotified = Mage::app()->getRequest()->getParam('notify', null) ? true : false;
        $this->addOrderStatusHistoryComment($this->logOutput, $orderId, $status, $isCustomerNotified);
    }

    /**
     * @param $orderId
     */
    public function addCommentToOrderHistoryConfirmSuccess($orderId)
    {
        $message = Mage::helper('iwd_ordermanager')->__("Changes were applied.");
        $this->addOrderStatusHistoryComment($message, $orderId, "success");
    }

    /**
     * @param $orderId
     */
    public function addCommentToOrderHistoryConfirmCancel($orderId)
    {
        $message = Mage::helper('iwd_ordermanager')->__("Changes were canceled.");
        $this->addOrderStatusHistoryComment($message, $orderId, "cancel");
    }

    /**
     * @param $comment
     * @param $orderId
     * @param bool|false $status
     * @param bool|false $isCustomerNotified
     */
    protected function addOrderStatusHistoryComment($comment, $orderId, $status = false, $isCustomerNotified = false)
    {
        /**
         * @var $order Mage_Sales_Model_Order
         */
        $order = Mage::getModel('sales/order')->load($orderId);

        if ($status === 'wait') {
            $orderStatus = Mage::getStoreConfig(self::CONFIG_XML_PATH_CONFIRM_STATUS_WAIT, Mage::app()->getStore());
            $comment .= "<i>" . Mage::helper('iwd_ordermanager')->__("Wait confirm...") . "</i>";
            $isCustomerNotified = true;
        } elseif ($status === 'success') {
            $orderStatus = Mage::getStoreConfig(self::CONFIG_XML_PATH_CONFIRM_STATUS_SUCCESS, Mage::app()->getStore());
        } elseif ($status === 'cancel') {
            $orderStatus = Mage::getStoreConfig(self::CONFIG_XML_PATH_CONFIRM_STATUS_CANCEL, Mage::app()->getStore());
        } else {
            $orderStatus = $order->getStatus();
        }

        if (empty($orderStatus)) {
            $orderStatus = $order->getStatus();
        }

        $isVisibleOnFront = Mage::getStoreConfig(self::CONFIG_XPATH_IS_COMMENT_VISIBLE, Mage::app()->getStore());

        $order->addStatusHistoryComment($comment, $orderStatus)
            ->setIsCustomerNotified($isCustomerNotified)
            ->setIsVisibleOnFront($isVisibleOnFront)
            ->save();

        $order->setData('status', $orderStatus)->save();
    }

    /**
     * @param $type
     * @param $orderId
     * @param null $params
     */
    public function addLogToLogTable($type, $orderId, $params = null)
    {
        $this->getLogOutput($orderId);
        if (empty($this->logOutput)) {
            return;
        }

        $this->updateLogs($type, $orderId, $params);
    }

    /**
     * @param $type
     * @param $orderId
     * @param null $params
     */
    public function updateLogs($type, $orderId, $params = null)
    {
        if (empty($params)) {
            $this->getConfirmLogger()->addOperationToLog($type, $this->logOutput, $orderId);
        } else {
            $this->getConfirmLogger()->addOperationForConfirm($type, $this->logOutput, $params, $orderId);
        }
    }

    /**
     * @return false|Mage_Core_Model_Abstract
     */
    public function getConfirmLogger()
    {
        return Mage::getModel('iwd_ordermanager/confirm_logger');
    }

    /**
     * @param $message
     * @param bool|false $sessionError
     */
    public static function log($message, $sessionError = false)
    {
        Mage::log($message, null, 'iwd_order_manager.log');

        if (!empty($sessionError)) {
            $sessionError = is_string($sessionError) ? $sessionError : $message;

            /**
             * @var $session Mage_Adminhtml_Model_Session
             */
            $session = Mage::getSingleton('adminhtml/session');
            $session->addError($sessionError);
        }
    }

    /**
     * @param $orderId
     * @param $statusId
     * @param bool|false $isCustomerNotified
     */
    public function addCommentToOrderHistoryInGrid($orderId, $statusId, $isCustomerNotified = false)
    {
        $this->getLogOutput($orderId);
        if (empty($this->logOutput)) {
            return;
        }

        $isVisibleOnFront = Mage::getStoreConfig(self::CONFIG_XPATH_IS_COMMENT_VISIBLE, Mage::app()->getStore());
        /**
         * @var $order Mage_Sales_Model_Order
         */
        $order = Mage::getModel('sales/order')->load($orderId);

        $order->addStatusHistoryComment($this->logOutput, $statusId)
            ->setIsCustomerNotified($isCustomerNotified)
            ->setIsVisibleOnFront($isVisibleOnFront)
            ->save();
    }
}
