<?php

/**
 * Class IWD_OrderManager_Model_Flags_Flag_Type
 *
 * @method string getFlagId()
 * @method IWD_OrderManager_Model_Flags_Flag_Type setFlagId(string $value)
 * @method string getTypeId()
 * @method IWD_OrderManager_Model_Flags_Flag_Type setTypeId(string $value)
 */
class IWD_OrderManager_Model_Flags_Flag_Type extends Mage_Core_Model_Abstract
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('iwd_ordermanager/flags_flag_type');
    }
}
