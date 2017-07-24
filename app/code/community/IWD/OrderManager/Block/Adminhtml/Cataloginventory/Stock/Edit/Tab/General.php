<?php

class IWD_OrderManager_Block_Adminhtml_Cataloginventory_Stock_Edit_Tab_General extends IWD_OrderManager_Block_Adminhtml_Cataloginventory_Stock_Edit_Tab_Abstract
{
    protected function addFieldsetToForm()
    {
        $helper = Mage::helper('iwd_ordermanager');

        $fieldsetGeneralInfo = $this->form->addFieldset('iwd_ordermanager_stock_general', array(
            'legend' => $helper->__('General')
        ));

        $fieldsetGeneralInfo->addField('stock_name', 'text', array(
            'label' => $helper->__('Source'),
            'title' => $helper->__('Source'),
            'name' => 'stock_name',
            'required' => true
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $fieldsetGeneralInfo->addField('store_ids', 'multiselect', array(
                'name' => 'store_ids',
                'label' => $helper->__('Store View'),
                'title' => $helper->__('Store View'),
                'required' => true,
                'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
                'value' => '0',
            ));
        } else {
            $fieldsetGeneralInfo->addField('store_ids', 'hidden', array(
                'name' => 'store_ids',
                'value' => '0',
            ));
        }
    }
}