<?php

/**
 * Class IWD_OrderManager_Block_System_Config_Form_Fieldset_Status
 */
class IWD_OrderManager_Block_System_Config_Form_Fieldset_Status extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    /**
     * {@inheritdoc}
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $storeId = $this->getStoreId();
        /**
         * @var IWD_OrderManager_Helper_SettlementReport $helper
         */
        $helper = Mage::helper('iwd_ordermanager/settlementReport');

        $request = $helper->checkApiCredentials($storeId);
        $style = ($request['error']) ? "color:#D40707" : "color:#059147";
        $message = $request['message'];

        return "<span style='{$style}'>{$message}</span>";
    }

    /**
     * @return int|mixed
     */
    protected function getStoreId()
    {
        $storeId = 0;

        $store = Mage::app()->getRequest()->getParam('store', null);

        if ($store != null) {
            $storeId = Mage::getModel('core/store')->load($store)->getId();
        } else {
            $website = Mage::app()->getRequest()->getParam('website', null);
            if ($website != null) {
                $storeId = Mage::getModel('core/website')->load($website)->getDefaultGroup()->getDefaultStoreId();
            }
        }

        return $storeId;
    }
}
