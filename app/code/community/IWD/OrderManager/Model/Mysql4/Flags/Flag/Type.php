<?php

/**
 * Class IWD_OrderManager_Model_Mysql4_Flags_Flag_Type
 */
class IWD_OrderManager_Model_Mysql4_Flags_Flag_Type extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('iwd_ordermanager/flags_flag_type', 'id');
    }
}
