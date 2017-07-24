<?php

class IWD_OrderManager_Model_Observer_Tax
{
    /**
     * Restore custom fee tax on collect_totals_after event of quote address
     *
     * @param Varien_Event_Observer $observer
     */
    public function restoreCustomFeeTax($observer)
    {
        $quoteAddress = $observer->getQuoteAddress();
        Mage::getModel('iwd_ordermanager/sales_quote_address_total_feeincl')->prepareAppliedTaxes($quoteAddress);
    }
}
