<?php

class IWD_OrderManager_Model_Sales_Quote_Address_Total_Fee extends Mage_Sales_Model_Quote_Address_Total_Abstract
{
    protected $_code = 'iwd_om_fee';

    /**
     * @var Mage_Sales_Model_Quote_Address
     */
    protected $address;

    /**
     * @param Mage_Sales_Model_Quote_Address $address
     * @return $this
     */
    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        $this->address = $address;

        parent::collect($address);

        if (!$this->isAdminArea()) {
            return $this;
        }

        $this->_setAmount(0);
        $this->_setBaseAmount(0);

        $items = $this->_getAddressItems($address);
        if (!count($items)) {
            return $this;
        }

        $quote = $address->getQuote();

        $feeAmount = $quote->getIwdOmFeeAmount();
        $baseFeeAmount = $quote->getIwdOmFeeBaseAmount();
        $address->setIwdOmFeeAmount($feeAmount);
        $address->setIwdOmFeeBaseAmount($baseFeeAmount);
        $address->setIwdOmFeeDescription($quote->getIwdOmFeeDescription());

        if (Mage::helper('iwd_ordermanager')->isManageTaxForCustomFee()) {
            $feeAmount = $quote->getIwdOmFeeAmountInclTax();
            $baseFeeAmount = $quote->getIwdOmFeeBaseAmountInclTax();
            $address->setIwdOmFeeAmountInclTax($feeAmount);
            $address->setIwdOmFeeBaseAmountInclTax($baseFeeAmount);
            $address->setIwdOmFeeTaxPercent($quote->getIwdOmFeeTaxPercent());

            $taxAmount = $address->getTaxAmount() + ($feeAmount - $address->getIwdOmFeeAmount());
            $baseTaxAmount = $address->getBaseTaxAmount() + ($baseFeeAmount - $address->getIwdOmFeeBaseAmount());
            $address->setTaxAmount($taxAmount);
            $address->setTaxBaseAmount($baseTaxAmount);
        }

        $address->setGrandTotal($address->getGrandTotal() + $feeAmount);
        $address->setBaseGrandTotal($address->getBaseGrandTotal() + $baseFeeAmount);

        return $this;
    }

    /**
     * @param Mage_Sales_Model_Quote_Address $address
     * @return $this
     */
    public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
        $this->address = $address;

        $amount = $address->getIwdOmFeeAmountInclTax();

        if ($amount != 0) {
            $this->addFeeExcludeTax();
        }

        return $this;
    }

    protected function addFeeExcludeTax()
    {
        if ($this->displayExlTax()) {
            $amount = $this->address->getIwdOmFeeAmount();

            $label = $this->address->getIwdOmFeeDescription();
            $label = (empty($label) ? Mage::helper('iwd_ordermanager')->__('Custom Amount') : $label);
            if ($this->displayInclAndExlTax()) {
                $label .= Mage::helper('iwd_ordermanager')->__(' (Excl. Tax)');
            }

            $this->address->addTotal(array(
                'code' => $this->getCode(),
                'title' => $label,
                'value' => $amount
            ));
        }
    }

    protected function displayExlTax()
    {
        return $this->displayCustomAmountType() == 1 || $this->displayCustomAmountType() == 3;
    }

    protected function displayInclTax()
    {
        return $this->displayCustomAmountType() == 2 || $this->displayCustomAmountType() == 3;
    }

    protected function displayInclAndExlTax()
    {
        return $this->displayCustomAmountType() == 3;
    }

    protected function displayCustomAmountType()
    {
        return Mage::getStoreConfig('iwd_ordermanager/edit/display_custom_amount', $this->address->getStoreId());
    }

    protected function isManageTax()
    {
        return Mage::helper('iwd_ordermanager')->isManageTaxForCustomFee();
    }

    /**
     * @return unknown
     */
    public function isAdminArea()
    {
        return Mage::app()->getStore()->isAdmin();
    }
}
