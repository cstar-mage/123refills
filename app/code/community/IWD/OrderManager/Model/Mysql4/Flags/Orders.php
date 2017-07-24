<?php

class IWD_OrderManager_Model_Mysql4_Flags_Orders extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('iwd_ordermanager/flags_orders', 'id');
    }
}
