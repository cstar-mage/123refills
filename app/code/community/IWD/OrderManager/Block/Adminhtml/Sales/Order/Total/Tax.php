<?php

class IWD_OrderManager_Block_Adminhtml_Sales_Order_Total_Tax extends Mage_Adminhtml_Block_Sales_Order_Totals_Tax
{
    public function getFullTaxInfo()
    {
        /** @var $source Mage_Sales_Model_Order */
        $source = $this->getOrder();

        $taxClassAmount = array();
        if ($source instanceof Mage_Sales_Model_Order) {
            $taxClassAmount = Mage::helper('tax')->getCalculatedTaxes($source);
            if (empty($taxClassAmount)) {
                $rates = Mage::getModel('sales/order_tax')->getCollection()->loadByOrder($source)->toArray();
                $taxClassAmount = Mage::getSingleton('tax/calculation')->reproduceProcess($rates['items']);
            }
        }

        return $taxClassAmount;
    }

    protected function isTotalExists($shippingTax, $taxClassAmount)
    {
        $shippingTax = is_array($shippingTax) ? $shippingTax[0] : $shippingTax;

        foreach ($taxClassAmount as $item) {
            if (isset($item['title']) && isset($shippingTax['title']) && $shippingTax['title'] == $item['title']) {
                return true;
            }
        }

        return false;
    }
}
