<?php

/**
 * Class IWD_OrderManager_Model_Mysql4_Flags_Flags_Collection
 */
class IWD_OrderManager_Model_Mysql4_Flags_Flags_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * {@inheritdoc}
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('iwd_ordermanager/flags_flags');
    }
}
