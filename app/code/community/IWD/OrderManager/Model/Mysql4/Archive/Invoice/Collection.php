<?php

/**
 * Class IWD_OrderManager_Model_Mysql4_Archive_Invoice_Collection
 */
class IWD_OrderManager_Model_Mysql4_Archive_Invoice_Collection extends IWD_OrderManager_Model_Resource_Archive_Invoice_Collection
{
    /**
     * {@inheritdoc}
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('iwd_ordermanager/archive_invoice');
    }
}