<?php

class IWD_OrderManager_Block_Sales_Order_Total_Fee extends Mage_Core_Block_Abstract
{
    /**
     * Get Source Model
     * @return mixed
     */
    public function getSource()
    {
        return $this->getParentBlock()->getSource();
    }

    /**
     * Add this total to parent
     */
    public function initTotals()
    {
        $amount = $this->getSource()->getIwdOmFeeAmount();

        if ($amount != 0) {
            $this->addFeeExcludeTax();
            $this->addFeeIncludeTax();
        }

        return $this;
    }

    protected function addFeeIncludeTax()
    {
        if ($this->displayInclTax()) {
            $amount = $this->isManageTax()
                ? $this->getSource()->getIwdOmFeeAmountInclTax()
                : $this->getSource()->getIwdOmFeeAmount();

            $label = $this->getOrder()->getIwdOmFeeDescription();
            $label = empty($label) ? $this->__('Custom Amount') : $label;
            if ($this->displayInclAndExlTax()) {
                $label .= $this->__(' (Incl. Tax)');
            }

            $total = new Varien_Object(array(
                'code' => 'iwd_om_fee_incl_tax',
                'field' => 'iwd_om_fee_amount_incl_tax',
                'value' => $amount,
                'label' => $label
            ));
            $this->getParentBlock()->addTotalBefore($total, array('subtotal_excl', 'subtotal_incl', 'subtotal'));
        }
    }

    protected function addFeeExcludeTax()
    {
        if ($this->displayExlTax()) {
            $amount = $this->getSource()->getIwdOmFeeAmount();

            $label = $this->getOrder()->getIwdOmFeeDescription();
            $label = (empty($label) ? $this->__('Custom Amount') : $label);
            if ($this->displayInclAndExlTax()) {
                $label .= $this->__(' (Excl. Tax)');
            }

            $total = new Varien_Object(array(
                'code'  => 'iwd_om_fee_excl_tax',
                'field' => 'iwd_om_fee_amount_excl_tax',
                'value' => $amount,
                'label' => $label
            ));
            $this->getParentBlock()->addTotalBefore($total, array('subtotal_excl', 'subtotal_incl', 'subtotal'));
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
        return Mage::getStoreConfig('iwd_ordermanager/edit/display_custom_amount', $this->getSource()->getStoreId());
    }

    /**
     * @return mixed
     */
    protected function isManageTax()
    {
        return Mage::helper('iwd_ordermanager')->isManageTaxForCustomFee();
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        $source = $this->getSource();
        if ($source instanceof Mage_Sales_Model_Order) {
            return $source;
        }

        return $source->getOrder();
    }
}
