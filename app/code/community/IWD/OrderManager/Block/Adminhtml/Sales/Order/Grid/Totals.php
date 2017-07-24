<?php

class IWD_OrderManager_Block_Adminhtml_Sales_Order_Grid_Totals extends Mage_Adminhtml_Block_Template
{
    public function getTotalSets()
    {
        $helper = Mage::helper('iwd_ordermanager');

        return array(
            'tax'      => array('label' => $helper->__('Tax Total'), 'page_label' => $helper->__('Tax Page Total')),
            'invoiced' => array('label' => $helper->__('Invoiced Total'), 'page_label' => $helper->__('Invoiced Page Total')),
            'shipped'  => array('label' => $helper->__('Shipping Total'), 'page_label' => $helper->__('Shipping Page Total')),
            'refunded' => array('label' => $helper->__('Refunds Total'), 'page_label' => $helper->__('Refunds Page Total')),
            'discount' => array('label' => $helper->__('Coupons Total'), 'page_label' => $helper->__('Coupons Page Total'))
        );
    }

    public function getSelectedTotalSets()
    {
        $totalSets = $this->getTotalSets();
        $selectedSets = $this->getSelectedOrderTotalSets();

        foreach ($totalSets as $id => $set) {
            if (!in_array($id, $selectedSets)) {
                unset($totalSets[$id]);
            }
        }

        return $totalSets;
    }

    /**
     * @return array
     */
    protected function getSelectedOrderTotalSets()
    {
        $orderSets = Mage::getStoreConfig('iwd_ordermanager/grid_order/order_totals_sets');
        return explode(',', $orderSets);
    }

    public function getGridOptions()
    {
        return Mage::getModel('iwd_ordermanager/order_totals')->getGridOptions();
    }

    public function getTotals()
    {
        return Mage::getModel('iwd_ordermanager/order_totals')->getTotals();
    }

    /**
     * @return string
     */
    public function getTotalsJson()
    {
        $totals = $this->getTotals();
        return json_encode($totals);
    }

    /**
     * @return string
     */
    public function getGridOptionsJson()
    {
        $options = $this->getGridOptions();
        return json_encode($options);
    }

    /**
     * @return bool
     */
    public function isTotalsEnabled()
    {
        return Mage::getStoreConfig('iwd_ordermanager/grid_order/order_totals_enable');
    }
}
