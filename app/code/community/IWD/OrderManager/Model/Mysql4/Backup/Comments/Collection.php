<?php

/**
 * Class IWD_OrderManager_Model_Mysql4_Backup_Comments_Collection
 */
class IWD_OrderManager_Model_Mysql4_Backup_Comments_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    /**
     * {@inheritdoc}
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('iwd_ordermanager/backup_comments');
    }
}