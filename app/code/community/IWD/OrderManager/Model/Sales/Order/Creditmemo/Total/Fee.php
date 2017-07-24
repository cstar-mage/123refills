<?php

class IWD_OrderManager_Model_Sales_Order_Creditmemo_Total_Fee extends Mage_Sales_Model_Order_Creditmemo_Total_Abstract
{
    /**
     * Collect Creditmemo Totals
     *
     * @param Mage_Sales_Model_Order_Creditmemo $creditmemo
     * @return Mage_Sales_Model_Order_Creditmemo_Total_Abstract
     */
    public function collect(Mage_Sales_Model_Order_Creditmemo $creditmemo)
    {
        $creditmemo->setIwdOmFeeAmount(0);
        $creditmemo->setIwdOmFeeBaseAmount(0);

        if (!$this->isEnabled()) {
            return $this;
        }

        $refundedAmount = $this->getAmountRefunded($creditmemo);
        $orderFeeAmount = $creditmemo->getOrder()->getIwdOmFeeAmount();
        if (($orderFeeAmount > 0 && $orderFeeAmount <= $refundedAmount)
            || ($orderFeeAmount <= 0 && $orderFeeAmount >= $refundedAmount)
        ) {
            return $this;
        }

        $feeAmount = $creditmemo->getOrder()->getIwdOmFeeAmount();
        $feeBaseAmount = $creditmemo->getOrder()->getIwdOmFeeBaseAmount();

        if ($feeAmount) {
            $creditmemo->setIwdOmFeeAmount($feeAmount);
            $creditmemo->setIwdOmFeeBaseAmount($feeBaseAmount);
            $creditmemo->setGrandTotal($creditmemo->getGrandTotal() + $feeAmount);
            $creditmemo->setBaseGrandTotal($creditmemo->getBaseGrandTotal() + $feeBaseAmount);
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
     * Check Amount has been refunded
     *
     * @param Mage_Sales_Model_Order_Creditmemo $creditmemo
     * @return float
     */
    protected function getAmountRefunded(Mage_Sales_Model_Order_Creditmemo $creditmemo)
    {
        $refunded = 0;
        $creditmemos = $creditmemo->getOrder()->getCreditmemosCollection();

        foreach ($creditmemos as $creditmemo) {
            if ($creditmemo->getIwdOmFeeAmount()) {
                $refunded += $creditmemo->getIwdOmFeeAmount();
            }
        }

        return $refunded;
    }
}
