<?php

class IWD_OrderManager_Model_Order_AdditionalFee
{
    /**
     * @var float
     */
    protected $amount = 0.0;

    /**
     * @var float
     */
    protected $amountInclTax = 0.0;

    /**
     * @var float
     */
    protected $taxPercent = 0.0;

    /**
     * @var string
     */
    protected $description = '';

    /**
     * @var Mage_Sales_Model_Order
     */
    protected $order;

    /**
     * @var Mage_Sales_Model_Order
     */
    protected $oldOrder;

    /**
     * @return Mage_Sales_Model_Order
     */
    protected function getOrder()
    {
        return $this->order;
    }

    /**
     * @param Mage_Sales_Model_Order $order
     * @return $this
     */
    protected function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @return float
     */
    protected function getAdditionalAmount()
    {
        return $this->amount;
    }

    /**
     * @param $amount
     * @return $this
     */
    public function setAdditionalAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return float
     */
    protected function getAdditionalAmountInclTax()
    {
        if (!$this->isManageTaxForCustomFee()) {
            return $this->getAdditionalAmount();
        }

        return $this->amountInclTax;
    }

    /**
     * @param $amount
     * @return $this
     */
    public function setAdditionalAmountInclTax($amount)
    {
        $this->amountInclTax = $amount;
        return $this;
    }

    /**
     * @return float
     */
    protected function getAdditionalTaxPercent()
    {
        if (!$this->isManageTaxForCustomFee()) {
            return 0;
        }

        return $this->taxPercent;
    }

    /**
     * @param $taxPercent
     * @return $this
     */
    public function setAdditionalTaxPercent($taxPercent)
    {
        $this->taxPercent = $taxPercent;
        return $this;
    }

    /**
     * @return string
     */
    protected function getFeeDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setFeeDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param Mage_Sales_Model_Order $order
     */
    public function applyAdditionalFeeToOrder($order)
    {
        $this->setOrder($order);
        $this->oldOrder = clone $order;

        $amount = $this->getAdditionalAmount();
        $baseAmount = $this->getBaseAmount($amount);
        $amountInclTax = $this->getAdditionalAmountInclTax();
        $baseAmountInclTax = $this->getBaseAmount($amountInclTax);
        $taxPercent = $this->getAdditionalTaxPercent();
        $description = $this->getFeeDescription();

        $feeTaxAmount = $order->getIwdOmFeeAmountInclTax() - $order->getIwdOmFeeAmount();
        $baseFeeTaxAmount = $order->getIwdOmFeeBaseAmountInclTax() - $order->getIwdOmFeeBaseAmount();
        $taxAmount = $order->getTaxAmount() - $feeTaxAmount + ($amountInclTax - $amount);
        $baseTaxAmount = $order->getBaseTaxAmount() - $baseFeeTaxAmount + ($baseAmountInclTax - $baseAmount);

        $grandTotal = $order->getGrandTotal() + ($amountInclTax - $order->getIwdOmFeeAmountInclTax()) ;
        $baseGrandTotal = $order->getBaseGrandTotal() + ($baseAmountInclTax - $order->getIwdOmFeeBaseAmountInclTax());

        if ($grandTotal < 0) {
            $amountInclTax += abs($grandTotal);
            $baseAmountInclTax += abs($baseGrandTotal);
            $amount = $amountInclTax / (1 + $taxPercent / 100);
            $baseAmount = $baseAmountInclTax / (1 + $taxPercent / 100);
            $grandTotal = 0;
            $baseGrandTotal = 0;
        }

        $order->setIwdOmFeeAmount($amount)
            ->setIwdOmFeeBaseAmount($baseAmount)
            ->setIwdOmFeeAmountInclTax($amountInclTax)
            ->setIwdOmFeeBaseAmountInclTax($baseAmountInclTax)
            ->setIwdOmFeeTaxPercent($taxPercent)
            ->setIwdOmFeeDescription($description)
            ->setTaxAmount($taxAmount)
            ->setBaseTaxAmount($baseTaxAmount)
            ->setGrandTotal($grandTotal)
            ->setBaseGrandTotal($baseGrandTotal);

        $order->save();

        $this->updateTaxTable($order);
        $this->updateOrderPayment();

        $this->addLogInfo();
    }

    /**
     * @param $amount
     * @return float
     */
    protected function getBaseAmount($amount)
    {
        $currentCurrencyCode = $this->getOrder()->getOrderCurrency();
        $baseCurrencyCode = $this->getOrder()->getBaseCurrency();

        $baseAmount = ($baseCurrencyCode != $currentCurrencyCode)
            ? Mage::helper('directory')->currencyConvert($amount, $currentCurrencyCode, $baseCurrencyCode)
            : $amount;

        return round($baseAmount, 2);
    }

    protected function updateOrderPayment()
    {
        /**
         * @var $orderEditor IWD_OrderManager_Model_Order_Edit
         */
        $orderEditor = Mage::getModel('iwd_ordermanager/order_edit');

        $orderId = $this->getOrder()->getId();
        $orderEditor->updateOrderPayment($orderId, $this->oldOrder);
    }

    protected function updateTaxTable($order)
    {
        if ($order->getIwdOmFeeTaxPercent() == 0) {
            $this->deleteOrderFeeTax($order);
        } else {
            $this->updateOrderFeeTax($order);
        }
    }

    protected function deleteOrderFeeTax($order)
    {
        $orderTaxCollection = Mage::getModel('sales/order_tax')->getCollection()
            ->addFieldToFilter('order_id', $order->getId())
            ->addFieldToFilter('code', IWD_OrderManager_Model_Sales_Quote_Address_Total_Feeincl::TAX_CODE);

        foreach ($orderTaxCollection as $item) {
            $item->delete();
        }
    }

    protected function updateOrderFeeTax($order)
    {
        $orderTaxCollection = Mage::getModel('sales/order_tax')->getCollection()
            ->addFieldToFilter('order_id', $order->getId())
            ->addFieldToFilter('code', IWD_OrderManager_Model_Sales_Quote_Address_Total_Feeincl::TAX_CODE);

        if ($orderTaxCollection->getSize() == 1) {
            $orderTax = $orderTaxCollection->getFirstItem();
        } else {
            $this->deleteOrderFeeTax($order);
            $orderTax = Mage::getModel('sales/order_tax');
        }

        $percent = $order->getIwdOmFeeTaxPercent();
        $amount = $order->getIwdOmFeeAmountInclTax() - $order->getIwdOmFeeAmount();
        $baseAmount = $order->getIwdOmFeeBaseAmountInclTax() - $order->getIwdOmFeeBaseAmount();
        $baseRealAmount = $baseAmount / $percent * $percent;
        $description = $order->getIwdOmFeeDescription();
        $description = empty($description) ? Mage::helper('iwd_ordermanager')->__('Custom Amount') : $description;

        $orderTax->setOrderId($order->getId())
            ->setCode(IWD_OrderManager_Model_Sales_Quote_Address_Total_Feeincl::TAX_CODE)
            ->setTitle($description)
            ->setAmount($amount)
            ->setBaseAmount($baseAmount)
            ->setPercent($percent)
            ->setBaseRealAmount($baseRealAmount)
            ->save();
    }

    /**
     * @return void
     */
    protected function addLogInfo()
    {
        $amount = $this->getAdditionalAmount();
        $amountInclTax = $this->getAdditionalAmountInclTax();
        $additionalDescription = $this->getFeeDescription();
        if (empty($amount)) {
            $message = Mage::helper('iwd_ordermanager')->__('Custom order amount was removed');
        } else {
            $message = sprintf(
                Mage::helper('iwd_ordermanager')->__('Custom order amount was applied: %s - %s (incl tax %s)'),
                $additionalDescription,
                Mage::helper('core')->currency($amount, true, false),
                Mage::helper('core')->currency($amountInclTax, true, false)
            );
        }

        /**
         * @var $log IWD_OrderManager_Model_Logger
         */
        $log = Mage::getSingleton('iwd_ordermanager/logger');
        $log->addToLog($message);
        $log->addCommentToOrderHistory($this->getOrder()->getId(), false);
    }

    /**
     * @return bool
     */
    protected function isManageTaxForCustomFee()
    {
        return Mage::helper('iwd_ordermanager')->isManageTaxForCustomFee();
    }
}
