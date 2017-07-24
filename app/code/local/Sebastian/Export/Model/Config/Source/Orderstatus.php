<?php

/**
 *
 * Copyright Sebastian Enzinger <sebastian@enzinger.de> www.sebastian-enzinger.de
 *
 * All rights reserved.
 *
**/

class Sebastian_Export_Model_Config_Source_Orderstatus
{

    public function toOptionArray()
    {
        $statuses[] = array('value' => 'no_change', 'label' => Mage::helper('adminhtml')->__('-- No change --'));
        foreach (Mage::getConfig()->getNode('global/sales/order/statuses')->children() as $status) {
            $statuses[] = array('value' => $status->getName(), 'label' => Mage::helper('adminhtml')->__((string)$status->label));
        }
        return $statuses;
    }

}
