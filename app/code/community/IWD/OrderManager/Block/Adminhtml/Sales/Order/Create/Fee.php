<?php

class IWD_OrderManager_Block_Adminhtml_Sales_Order_Create_Fee extends Mage_Adminhtml_Block_Template
{
    /**
     * @var Mage_Sales_Model_Quote
     */
    protected $_quote;

    /**
     * @return Mage_Sales_Model_Quote
     */
    public function getQuote()
    {
        if (is_null($this->_quote)) {
            $this->_quote = Mage::getSingleton('adminhtml/session_quote')->getQuote();
        }

        return $this->_quote;
    }

    /**
     * @return mixed
     */
    public function isManageTax()
    {
        return Mage::helper('iwd_ordermanager')->isManageTaxForCustomFee();
    }

    /**
     * @return string
     */
    public function getAdditionalAmount()
    {
        $amount = (!$this->getQuote())
            ? 0
            : ($this->getQuote()->getShippingAddress()->getIwdOmFeeAmount()
                ? $this->getQuote()->getShippingAddress()->getIwdOmFeeAmount()
                : (
                $this->getQuote()->getBillingAddress()->getIwdOmFeeAmount()
                    ? $this->getQuote()->getBillingAddress()->getIwdOmFeeAmount()
                    : 0
                ));

        return empty($amount) ? '' : (string)number_format($amount, 2, '.', '');
    }

    /**
     * @return string
     */
    public function getAdditionalAmountInclTax()
    {
        $amount = (!$this->getQuote())
            ? 0
            : ($this->getQuote()->getShippingAddress()->getIwdOmFeeAmountInclTax()
                ? $this->getQuote()->getShippingAddress()->getIwdOmFeeAmountInclTax()
                : (
                $this->getQuote()->getBillingAddress()->getIwdOmFeeAmountInclTax()
                    ? $this->getQuote()->getBillingAddress()->getIwdOmFeeAmountInclTax()
                    : 0
                ));

        return empty($amount) ? '' : (string)number_format($amount, 2, '.', '');
    }


    /**
     * @return string
     */
    public function getTaxPercent()
    {
        $amount = (!$this->getQuote())
            ? 0
            : ($this->getQuote()->getShippingAddress()->getIwdOmFeeTaxPercent()
                ? $this->getQuote()->getShippingAddress()->getIwdOmFeeTaxPercent()
                : (
                $this->getQuote()->getBillingAddress()->getIwdOmFeeTaxPercent()
                    ? $this->getQuote()->getBillingAddress()->getIwdOmFeeTaxPercent()
                    : 0
                ));

        return empty($amount) ? '0.00' : (string)number_format($amount, 2, '.', '');
    }

    /**
     * @return string
     */
    public function getAdditionalAmountDescription()
    {
        return !$this->getQuote()
            ? ''
            : ($this->getQuote()->getShippingAddress()->getIwdOmFeeDescription()
                ? $this->getQuote()->getShippingAddress()->getIwdOmFeeDescription()
                : (
                    $this->getQuote()->getBillingAddress()->getIwdOmFeeDescription()
                    ? $this->getQuote()->getBillingAddress()->getIwdOmFeeDescription()
                    : ''
                ));
    }

    /**
     * @return bool
     */
    public function isAdditionalDiscountEnabled()
    {
        return (bool)Mage::getStoreConfig('iwd_ordermanager/edit/enable_custom_amount')
            && (bool)Mage::getStoreConfig('iwd_ordermanager/edit/enable_custom_amount_new');
    }

    /**
     * @return float|int
     */
    public function getMinimalAmount()
    {
        return $this->getQuote()
            ? (($this->getQuote()->getGrandTotal() - $this->getQuote()->getIwdOmFeeAmount()) * -1)
            : 0;
    }

    /**
     * @return string
     */
    public function applyUrl()
    {
        return '#';
    }

    /**
     * @return bool
     */
    public function isCreatingOrder()
    {
        return 1;
    }
}
