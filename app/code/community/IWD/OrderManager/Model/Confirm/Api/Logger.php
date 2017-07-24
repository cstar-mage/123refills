<?php

class IWD_OrderManager_Model_Confirm_Api_Logger extends IWD_OrderManager_Model_Confirm_Logger
{
    public function addOperationToLog($type, $log, $orderId)
    {
        $data = array();

        $data['edit_type'] = $type;
        $data['params'] = null;
        $data['confirm_link'] = null;
        $data['log_operations'] = $log;
        $data['status'] = IWD_OrderManager_Model_Confirm_Options_Status::LOG;
        $data['order_id'] = $orderId;
        $data['customer_email'] = null;

        $data = $this->setBaseInfo($data);

        $this->setData($data);
        $this->save();
    }

    public function setBaseInfo($data)
    {
        $user = Mage::getSingleton('api/session')->getUser();
        if ($user) {
            $data['admin_id'] = $user->getId();
            $data['admin_name'] = "{$user->getFirstname()} {$user->getLastname()} ({$user->getUsername()})";
        }
        $data['created_at'] = Mage::getModel('core/date')->gmtDate();
        $data['updated_at'] = null;
        $data['request_ip'] = Mage::helper('iwd_ordermanager')->getCurrentIpAddress();
        $data['confirm_ip'] = null;

        return $data;
    }
}
