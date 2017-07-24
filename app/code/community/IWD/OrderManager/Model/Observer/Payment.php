<?php

class IWD_OrderManager_Model_Observer_Payment
{
    /**
     * FIX: Sets current instructions for bank transfer account
     *
     * @param Varien_Event_Observer $observer
     * @return void
     */
    public function beforeOrderPaymentSave(Varien_Event_Observer $observer)
    {
        /** @var Mage_Sales_Model_Order_Payment $payment */
        $payment = $observer->getEvent()->getPayment();
        if ($payment->getMethod() === Mage_Payment_Model_Method_Banktransfer::PAYMENT_METHOD_BANKTRANSFER_CODE) {
            $payment->setAdditionalInformation('instructions', $this->getInstructions($payment));
        }
    }

    /**
     * @param Mage_Sales_Model_Order_Payment $payment
     * @return string
     */
    protected function getInstructions($payment)
    {
        if ($payment->getOrder()) {
            return $payment->getOrder()->getStore()->getConfig('payment/banktransfer/instructions');
        }

        return $payment->getMethodInstance()->getInstructions();
    }
}
