<?php

class IWD_OrderManager_Model_Confirm_Operations extends Mage_Core_Model_Abstract
{
    const CONFIG_XML_PATH_CONFIRM_STATUS_CANCEL = 'iwd_ordermanager/edit/confirm_cancel_status';
    const CONFIG_XML_PATH_CONFIRM_STATUS_SUCCESS = 'iwd_ordermanager/edit/confirm_success_status';
    const CONFIG_XML_PATH_CONFIRM_STATUS_WAIT = 'iwd_ordermanager/edit/confirm_wait_status';

    public function confirmById($id)
    {
        $logger = Mage::getModel('iwd_ordermanager/confirm_logger')->load($id);
        return $this->confirm($logger);
    }

    public function confirmByPid($pid)
    {
        $logger = $this->getLogItemByPid($pid);
        return $this->confirm($logger);
    }

    protected function confirm($log)
    {
        if (empty($log)) {
            return false;
        }

        try {
            $status = $log->getStatus();
            $ip = Mage::helper('iwd_ordermanager')->getCurrentIpAddress();
            $data = Mage::getModel('core/date')->gmtDate();
            $orderId = $log->getOrderId();

            if ($status == IWD_OrderManager_Model_Confirm_Options_Status::WAIT_CONFIRM) {
                $result = $this->execOperationsToConfirm($log);

                if ($result) {
                    //if user confirm changes - we confirm this changes and cancel all changes in this order which have status WAIT_CONFIRM
                    $otherLoggers = Mage::getModel('iwd_ordermanager/confirm_logger')->getCollection()
                        ->addFieldToFilter('status', IWD_OrderManager_Model_Confirm_Options_Status::WAIT_CONFIRM)
                        ->addFieldToFilter('edit_type', $log->getEditType())
                        ->addFieldToFilter('order_id', $orderId);

                    foreach ($otherLoggers as $oneLog) {
                        $oneLog->setStatus(IWD_OrderManager_Model_Confirm_Options_Status::CANCELED)
                            ->setConfirmIp($ip)
                            ->setUpdatedAt($data)
                            ->save();
                    }

                    $log->setStatus(IWD_OrderManager_Model_Confirm_Options_Status::CONFIRMED)
                        ->setConfirmIp($ip)
                        ->setUpdatedAt($data)
                        ->save();
                    Mage::getSingleton('iwd_ordermanager/logger')->addCommentToOrderHistoryConfirmSuccess($orderId);
                    return true;
                }
            }
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log($e->getMessage());
        }

        return false;
    }

    public function cancelConfirmById($id)
    {
        $logger = Mage::getModel('iwd_ordermanager/confirm_logger')->load($id);
        return $this->cancelConfirm($logger);
    }

    public function cancelConfirmByPid($pid)
    {
        $logger = $this->getLogItemByPid($pid);
        return $this->cancelConfirm($logger);
    }

    protected function cancelConfirm($log)
    {
        if (empty($log)) {
            return false;
        }
        try {
            $status = $log->getStatus();
            $orderId = $log->getOrderId();
            $ip = Mage::helper('iwd_ordermanager')->getCurrentIpAddress();
            $data = Mage::getModel('core/date')->gmtDate();
            if ($status == IWD_OrderManager_Model_Confirm_Options_Status::WAIT_CONFIRM) {
                //if user cancel changes - we cancel all changes in this order which have status WAIT_CONFIRM
                $otherLoggers = Mage::getModel('iwd_ordermanager/confirm_logger')->getCollection()
                    ->addFieldToFilter('status', IWD_OrderManager_Model_Confirm_Options_Status::WAIT_CONFIRM)
                    ->addFieldToFilter('edit_type', $log->getEditType())
                    ->addFieldToFilter('order_id', $orderId);
                foreach ($otherLoggers as $oneLog) {
                    $oneLog->setStatus(IWD_OrderManager_Model_Confirm_Options_Status::CANCELED)
                        ->setConfirmIp($ip)
                        ->setUpdatedAt($data)
                        ->save();
                }
                $log->setStatus(IWD_OrderManager_Model_Confirm_Options_Status::CANCELED)
                    ->setConfirmIp($ip)
                    ->setUpdatedAt($data)
                    ->save();
                Mage::getSingleton('iwd_ordermanager/logger')->addCommentToOrderHistoryConfirmCancel($orderId);
                return true;
            }
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log($e->getMessage());
            return false;
        }

        return false;
    }

    public function getLogItemByPid($pid)
    {
        $log = Mage::getModel('iwd_ordermanager/confirm_logger')->getCollection()
            ->addFieldToFilter('confirm_link', $pid)
            ->getFirstItem();

        if (empty($log)) {
            return null;
        }

        $id = $log->getId();

        if (empty($id)) {
            return null;
        }

        return $log;
    }

    protected function changeOrderStatusAfterConfirmChanges($orderId)
    {
        $status = Mage::getStoreConfig(self::CONFIG_XML_PATH_CONFIRM_STATUS_CANCEL, Mage::app()->getStore());
        $message = Mage::helper('iwd_ordermanager')->__("Order changes were canceled");

        $order = Mage::getModel('sales/order')->load($orderId);

        if (empty($status) || $status === 'false' || $status === false) {
            $status = $order->getStatus();
        }

        $order->addStatusHistoryComment($message, $status)->setIsCustomerNotified(false);
        $order->setData('status', $status);

        $order->save();
    }


    protected function execOperationsToConfirm($log)
    {
        $orderId = $log->getOrderId();
        $params = $log->getParams();
        $params = unserialize($params);
        if (empty($params)) {
            return false;
        }

        switch ($log->getEditType()) {
            case IWD_OrderManager_Model_Confirm_Options_Type::ITEMS:
                return $this->execOrderItemsUpdate($orderId, $params);

            case IWD_OrderManager_Model_Confirm_Options_Type::PAYMENT:
                return $this->execPaymentUpdate($orderId, $params);

            case IWD_OrderManager_Model_Confirm_Options_Type::SHIPPING:
                return $this->execShippingUpdate($orderId, $params);

            case IWD_OrderManager_Model_Confirm_Options_Type::CUSTOMER_INFO:
                return $this->execCustomerInfoUpdate($params);

            case IWD_OrderManager_Model_Confirm_Options_Type::ORDER_INFO:
                return $this->execOrderInfoUpdate($params);

            case IWD_OrderManager_Model_Confirm_Options_Type::BILLING_ADDRESS:
            case IWD_OrderManager_Model_Confirm_Options_Type::SHIPPING_ADDRESS:
                return $this->execAddressUpdate($params);

            default:
                throw new Exception(Mage::helper('iwd_ordermanager')->__('Unknown operation type for confirm'));
        }
    }

    protected function execOrderItemsUpdate($orderId, $params)
    {
        try {
            return Mage::getModel('iwd_ordermanager/order_edit')->execEditOrderItems($orderId, $params);
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log($e->getMessage());
            return false;
        }
    }

    protected function execPaymentUpdate($orderId, $params)
    {
        try {
            return Mage::getModel('iwd_ordermanager/payment_payment')->execUpdatePaymentMethod($params['payment'], $orderId);
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log($e->getMessage());
            return false;
        }
    }

    protected function execShippingUpdate($orderId, $params)
    {
        try {
            $shippingModel = Mage::getModel('iwd_ordermanager/shipping');
            $shipping = $shippingModel->prepareShippingObj($params);
            return $shippingModel->editSipping($orderId, $shipping);
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log($e->getMessage());
            return false;
        }
    }

    protected function execCustomerInfoUpdate($params)
    {
        try {
            return Mage::getModel('iwd_ordermanager/order_customer')->execUpdateOrderCustomer($params);
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log($e->getMessage());
            return false;
        }
    }

    protected function execOrderInfoUpdate($params)
    {
        try {
            return Mage::getModel('iwd_ordermanager/order_info')->execUpdateOrderInfo($params);
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log($e->getMessage());
            return false;
        }
    }

    protected function execAddressUpdate($params)
    {
        try {
            return Mage::getModel('iwd_ordermanager/address')->editOrderAddress($params);
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log($e->getMessage());
            return false;
        }
    }
}
