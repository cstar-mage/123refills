<?php

class IWD_OrderManager_Model_Api_Shipping extends IWD_OrderManager_Model_Shipping
{
    public function getLogger()
    {
        return Mage::getSingleton('iwd_ordermanager/api_logger');
    }
}