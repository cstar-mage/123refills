<?php

class IWD_OrderManager_Block_Adminhtml_Sales_Order_Create_Store_Switcher extends Mage_Adminhtml_Block_Store_Switcher
{
    public function getStoreId()
    {
        $store = $this->getSessionStoreId();
        if (empty($store)) {
            $store = $this->getSessionStoreId();
        }

        return $this->getRequest()->getParam($this->_storeVarName, $store);
    }

    public function getDefaultStoreId()
    {
        return Mage::getStoreConfig('iwd_ordermanager/crate_process/default_store');
    }

    public function getSessionStoreId()
    {
        return $this->_getSession()->getStoreId();
    }

    protected function _getSession()
    {
        return Mage::getSingleton('adminhtml/session_quote');
    }
}
