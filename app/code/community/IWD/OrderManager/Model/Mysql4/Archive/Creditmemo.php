<?php

/**
 * Class IWD_OrderManager_Model_Mysql4_Archive_Creditmemo
 */
class IWD_OrderManager_Model_Mysql4_Archive_Creditmemo extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('iwd_ordermanager/archive_creditmemo', 'entity_id');
    }
}
