<?php

/**
 * Class IWD_OrderManager_Model_Resource_Archive_Order_Collection
 */
class IWD_OrderManager_Model_Resource_Archive_Order_Collection extends IWD_OrderManager_Model_Resource_Order_Grid_Collection
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setMainTable('iwd_ordermanager/archive_order');
    }
}
