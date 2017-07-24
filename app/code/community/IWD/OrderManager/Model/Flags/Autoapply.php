<?php

/**
 * Class IWD_OrderManager_Model_Flags_Autoapply
 *
 * @method string getFlagId()
 * @method IWD_OrderManager_Model_Flags_Autoapply setFlagId(string $value)
 * @method string getTypeId()
 * @method IWD_OrderManager_Model_Flags_Autoapply setTypeId(string $value)
 * @method string getApplyType()
 * @method IWD_OrderManager_Model_Flags_Autoapply setApplyType(string $value)
 * @method string getKey()
 * @method IWD_OrderManager_Model_Flags_Autoapply setKey(string $value)
 */
class IWD_OrderManager_Model_Flags_Autoapply extends Mage_Core_Model_Abstract
{
    const TYPE_ORDER_STATUS = 'status';
    const TYPE_SHIPPING_METHOD = 'shipping';
    const TYPE_PAYMENT_METHOD = 'payment';

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('iwd_ordermanager/flags_autoapply');
    }
}
