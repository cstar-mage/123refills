<?php

/**
 * Class IWD_OrderManager_Model_Mysql4_Flags_Autoapply
 */
class IWD_OrderManager_Model_Mysql4_Flags_Autoapply extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('iwd_ordermanager/flags_autoapply', 'id');
    }
}
