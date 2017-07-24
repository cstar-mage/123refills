<?php

/**
 * Class IWD_OrderManager_Model_Mysql4_Cataloginventory_Stock_Address
 */
class IWD_OrderManager_Model_Mysql4_Cataloginventory_Stock_Address extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('iwd_ordermanager/cataloginventory_stock_address', 'id');
    }
}
