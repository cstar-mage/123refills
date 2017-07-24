<?php

class IWD_OrderManager_Model_Sales_Pdf_Fee extends Mage_Sales_Model_Order_Pdf_Total_Default
{
    protected $totals = array();

    /**
     * Get array of arrays with totals information for display in PDF
     * array(
     *  $index => array(
     *      'amount'   => $amount,
     *      'label'    => $label,
     *      'font_size'=> $font_size
     *  )
     * )
     * @return array
     */
    public function getTotalsForDisplay()
    {
        if ($this->getOrder()->getIwdOmFeeAmount() == 0) {
            return array();
        }

        $this->feeAmountExclTax();
        $this->feeAmountInclTax();

        return $this->totals;
    }

    protected function feeAmountInclTax()
    {
        if ($this->displayExlTax()) {
            $amount = $this->isManageTax()
                ? $this->getOrder()->getIwdOmFeeAmountInclTax()
                : $this->getOrder()->getIwdOmFeeAmount();

            $amount = $this->getOrder()->formatPriceTxt($amount);
            $fontSize = $this->getFontSize() ? $this->getFontSize() : 7;
            $label = $this->getOrder()->getIwdOmFeeDescription();
            if ($this->displayInclAndExlTax()) {
                $label .= Mage::helper('iwd_ordermanager')->__(' (Incl. Tax)');
            }

            $this->totals[] = array(
                'amount' => $this->getAmountPrefix() . $amount,
                'label' => $label . ':',
                'font_size' => $fontSize,
            );
        }
    }

    protected function feeAmountExclTax()
    {
        if ($this->displayInclTax()) {
            $amount = $this->getOrder()->formatPriceTxt($this->getOrder()->getIwdOmFeeAmount());
            $fontSize = $this->getFontSize() ? $this->getFontSize() : 7;
            $label = $this->getOrder()->getIwdOmFeeDescription();
            if ($this->displayInclAndExlTax()) {
                $label .= Mage::helper('iwd_ordermanager')->__(' (Excl. Tax)');
            }

            $this->totals[] = array(
                'amount' => $this->getAmountPrefix() . $amount,
                'label' => $label . ':',
                'font_size' => $fontSize,
            );
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
        return Mage::getStoreConfig('iwd_ordermanager/edit/display_custom_amount');
    }

    protected function isManageTax()
    {
        return Mage::helper('iwd_ordermanager')->isManageTaxForCustomFee();
    }
}
