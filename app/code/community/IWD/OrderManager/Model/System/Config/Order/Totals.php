<?php

/**
 * Class IWD_OrderManager_Model_System_Config_Order_Totals
 */
class IWD_OrderManager_Model_System_Config_Order_Totals
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        $sets = Mage::getBlockSingleton('iwd_ordermanager/adminhtml_sales_order_grid_totals')->getTotalSets();

        $options = array();
        foreach ($sets as $id => $set) {
            $options[] = array(
                'value' => $id,
                'label' => $set['label']
            );
        }

        return $options;
    }
}
