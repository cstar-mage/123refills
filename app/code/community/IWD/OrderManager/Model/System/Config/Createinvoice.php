<?php

/**
 * Class IWD_OrderManager_Model_System_Config_Createinvoice
 */
class IWD_OrderManager_Model_System_Config_Createinvoice
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array(
                'value' => 'never',
                'label' => Mage::helper('adminhtml')->__('Never')
            ),
            array(
                'value' => 'always',
                'label' => Mage::helper('adminhtml')->__('Always')
            ),
            array(
                'value' => 'authorizenet',
                'label' => Mage::helper('adminhtml')->__('Only Authorize.net')
            ),
        );
    }
}
