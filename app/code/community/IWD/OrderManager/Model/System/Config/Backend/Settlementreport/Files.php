<?php

class IWD_OrderManager_Model_System_Config_Backend_Settlementreport_Files
{
    public function toOptionArray()
    {
        $helper = Mage::helper('iwd_ordermanager');
        return array(
            array(
                'value' => 'csv',
                'label' => $helper->__('CSV file')
            ),
            array(
                'value' => 'xml',
                'label' => $helper->__('Excel XML file')
            )
        );
    }
}
