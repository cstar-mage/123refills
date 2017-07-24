<?php

class IWD_OrderManager_Model_Adminhtml_Options_NotifyYesNo
{
    public function toOptionArray()
    {
        return array(
            array(
                'value' => '1',
                'label' => Mage::helper('adminhtml')->__('Yes')
            ),
            array(
                'value' => '0',
                'label' => Mage::helper('adminhtml')->__('No')
            )
        );
    }
}
