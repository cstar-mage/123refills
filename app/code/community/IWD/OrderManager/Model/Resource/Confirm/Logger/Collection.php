<?php

/**
 * Class IWD_OrderManager_Model_Resource_Confirm_Logger_Collection
 */
class IWD_OrderManager_Model_Resource_Confirm_Logger_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * {@inheritdoc}
     */
    public function _construct()
    {
        parent::_construct();
        $this->setMainTable('iwd_ordermanager/confirm_logger');
    }
}
