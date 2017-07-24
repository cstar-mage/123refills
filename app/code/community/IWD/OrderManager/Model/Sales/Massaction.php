<?php

class IWD_OrderManager_Model_Sales_Massaction extends Mage_Core_Model_Abstract
{
    const XPATH_MASSACTION_SAVE = 'iwd_ordermanager/massaction/order_grid';

    public function getMassactionForCurrentUser()
    {
        $massaction = $this->getMassaction();
        $adminId = Mage::getSingleton('admin/session')->getUser()->getUserId();

        return isset($massaction[$adminId]) ? $massaction[$adminId] : '{}';
    }

    public function getMassaction()
    {
        $massaction = Mage::getStoreConfig(self::XPATH_MASSACTION_SAVE);
        $massaction = unserialize($massaction);
        return empty($massaction) || !is_array($massaction) ? array() : $massaction;
    }

    public function saveMassactionForCurrentUser($massactionData)
    {
        $massaction = $this->getMassaction();
        $adminId = Mage::getSingleton('admin/session')->getUser()->getUserId();
        $massaction[$adminId] = $massactionData;
        $massaction = serialize($massaction);

        Mage::getModel('core/config')->saveConfig(self::XPATH_MASSACTION_SAVE, $massaction);
    }
}
