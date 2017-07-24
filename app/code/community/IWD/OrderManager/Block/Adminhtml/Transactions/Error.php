<?php

class IWD_OrderManager_Block_Adminhtml_Transactions_Error extends Mage_Adminhtml_Block_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('iwd/ordermanager/settlementreport/error.phtml');
    }
}
