<?php

/**
 * Class IWD_OrderManager_Model_Api_Logger
 */
class IWD_OrderManager_Model_Api_Logger extends IWD_OrderManager_Model_Logger
{
    /**
     * {@inheritdoc}
     */
    public function getConfirmLogger()
    {
        return Mage::getModel('iwd_ordermanager/confirm_api_logger');
    }
}