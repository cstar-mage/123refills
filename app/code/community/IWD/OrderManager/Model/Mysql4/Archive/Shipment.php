<?php

class IWD_OrderManager_Model_Mysql4_Archive_Shipment extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('iwd_ordermanager/archive_shipment', 'entity_id');
    }
}
