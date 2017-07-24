<?php

class IWD_OrderManager_Model_Sales_Quote_Address_Total_Feeincl extends IWD_OrderManager_Model_Sales_Quote_Address_Total_Fee
{
    const TAX_CODE = 'iwd_om_custom_fee';

    protected $_code = 'iwd_om_fee_incl';

    /**
     * {@inheritdoc}
     */
    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
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
            $this->addFeeIncludeTax();
            $this->prepareAppliedTaxes($this->address);
        }

        return $this;
    }

    protected function addFeeIncludeTax()
    {
        if ($this->displayInclTax()) {
            $amount = $this->isManageTax()
                ? $this->address->getIwdOmFeeAmountInclTax()
                : $this->address->getIwdOmFeeAmount();

            $label = $this->address->getIwdOmFeeDescription();
            $label = empty($label) ? Mage::helper('iwd_ordermanager')->__('Custom Amount') : $label;
            if ($this->displayInclAndExlTax()) {
                $label .= Mage::helper('iwd_ordermanager')->__(' (Incl. Tax)');
            }

            $this->address->addTotal(array(
                'code' => $this->getCode(),
                'title' => $label,
                'value' => $amount
            ));
        }
    }

    public function prepareAppliedTaxes($address)
    {
        $percent = $address->getIwdOmFeeTaxPercent();
        if ($percent != 0) {
            $amount = $address->getIwdOmFeeAmountInclTax() - $address->getIwdOmFeeAmount();
            $baseAmount = $address->getIwdOmFeeBaseAmountInclTax() - $address->getIwdOmFeeBaseAmount();
            $title = $address->getIwdOmFeeDescription() . ' ' . Mage::helper('iwd_ordermanager')->__('tax');

            $previouslyAppliedTaxes = $address->getAppliedTaxes();

            $previouslyAppliedTaxes[self::TAX_CODE] = array(
                'rates' => array(
                    array(
                        'percent' => $percent,
                        'title' => $title,
                        'id' => self::TAX_CODE,
                        'code' => self::TAX_CODE,
                        'position' => "1",
                        'priority' => "1"
                    )
                ),
                'percent' => $percent,
                'id' => self::TAX_CODE,
                'code' => self::TAX_CODE,
                'process' => 0,
                'amount' => $amount,
                'base_amount' => $baseAmount
            );

            $address->setAppliedTaxes($previouslyAppliedTaxes);
            $address->save();
        }
    }
}
