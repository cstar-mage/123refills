<?php

/**
 * Class IWD_OrderManager_Model_Mysql4_Backup_Comments
 */
class IWD_OrderManager_Model_Mysql4_Backup_Comments extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('iwd_ordermanager/backup_comments', 'id');
    }
}
