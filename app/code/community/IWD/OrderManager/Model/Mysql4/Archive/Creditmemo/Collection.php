<?php

/**
 * Class IWD_OrderManager_Model_Mysql4_Archive_Creditmemo_Collection
 */
class IWD_OrderManager_Model_Mysql4_Archive_Creditmemo_Collection extends IWD_OrderManager_Model_Resource_Archive_Creditmemo_Collection
{
    /**
     * {@inheritdoc}
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('iwd_ordermanager/archive_creditmemo');
    }
}
