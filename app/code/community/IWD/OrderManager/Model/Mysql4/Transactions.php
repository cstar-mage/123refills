<?php

/**
 * Class IWD_OrderManager_Model_Mysql4_Transactions
 */
class IWD_OrderManager_Model_Mysql4_Transactions extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('iwd_ordermanager/transactions', 'id');
    }
}
