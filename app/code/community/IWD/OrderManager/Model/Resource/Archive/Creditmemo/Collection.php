<?php

/**
 * Class IWD_OrderManager_Model_Resource_Archive_Creditmemo_Collection
 */
class IWD_OrderManager_Model_Resource_Archive_Creditmemo_Collection extends Mage_Sales_Model_Resource_Order_Creditmemo_Grid_Collection
{
    /**
     * {@inheritdoc}
     */
    public function _construct()
    {
        parent::_construct();
        $this->setMainTable('iwd_ordermanager/archive_creditmemo');
    }
}

