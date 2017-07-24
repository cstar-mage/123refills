<?php

class IWD_OrderManager_Model_Sales_Order_Invoice_Total_Fee extends Mage_Sales_Model_Order_Invoice_Total_Abstract
{
    /**
     * Collect Invoice Totals
     *
     * @param Mage_Sales_Model_Order_Invoice $invoice
     * @return Mage_Sales_Model_Order_Invoice_Total_Abstract
     */
    public function collect(Mage_Sales_Model_Order_Invoice $invoice)
    {
        $invoice->setIwdOmFeeAmount(0);
        $invoice->setIwdOmFeeBaseAmount(0);

        if (!$this->isEnabled()) {
            return $this;
        }

        $invoiceFeeAmount = $this->getAmountInvoiced($invoice);
        $orderFeeAmount = $invoice->getOrder()->getIwdOmFeeAmount();
        if (($orderFeeAmount > 0 && $orderFeeAmount <= $invoiceFeeAmount)
            || ($orderFeeAmount <= 0 && $orderFeeAmount >= $invoiceFeeAmount)
        ) {
            return $this;
        }

        $feeAmount = $invoice->getOrder()->getIwdOmFeeAmount();
        $feeBaseAmount = $invoice->getOrder()->getIwdOmFeeBaseAmount();

        if ($feeAmount) {
            $invoice->setIwdOmFeeAmount($feeAmount);
            $invoice->setIwdOmFeeBaseAmount($feeBaseAmount);
            $invoice->setGrandTotal($invoice->getGrandTotal() + $feeAmount);
            $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal() + $feeBaseAmount);
        }

        return $this;
    }

    /**
     * @return bool
     */
    protected function isEnabled()
    {
        return (bool)Mage::getStoreConfig('iwd_ordermanager/edit/enable_custom_amount');
    }

    /**
     * Check Amount has been invoiced
     *
     * @param Mage_Sales_Model_Order_Invoice $invoice
     * @return float
     */
    protected function getAmountInvoiced(Mage_Sales_Model_Order_Invoice $invoice)
    {
        $invoiceFeeAmount = 0;
        $invoices = $invoice->getOrder()->getInvoiceCollection();

        foreach ($invoices as $invoice) {
            if ($invoice->getIwdOmFeeAmount() && !$invoice->isCanceled()) {
                $invoiceFeeAmount += $invoice->getIwdOmFeeAmount();
            }
        }

        return $invoiceFeeAmount;
    }
}