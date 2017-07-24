<?php

class IWD_OrderManager_Model_Observer_Sales
{
    /**
     * @param Varien_Event_Observer $observer
     */
    public function initQuoteAddress(Varien_Event_Observer $observer)
    {
        if (!Mage::helper('iwd_ordermanager')->isCustomCreationProcess()) {
            return;
        }

        /**
         * @var $sessionQuote Mage_Adminhtml_Model_Session_Quote
         */
        $sessionQuote = $observer->getEvent()->getData("session_quote");
        $quote = $sessionQuote->getQuote();
        $customer = $sessionQuote->getCustomer(true);
        $customerId = $customer->getId();

        if ($customerId) {
            $quoteAddress = $quote->getShippingAddress();
            if ($customerId != $quoteAddress->getCustomerId()) {
                $defaultAddress = $customer->getDefaultShippingAddress();
                $this->updateQuoteAddress($quoteAddress, $defaultAddress);
            }

            $quoteAddress = $quote->getBillingAddress();
            if ($customerId != $quoteAddress->getCustomerId()) {
                $defaultAddress = $customer->getDefaultBillingAddress();
                $this->updateQuoteAddress($quoteAddress, $defaultAddress);
            }

            $quote->setCustomer($customer)->save();
        }
    }

    protected function updateQuoteAddress($quoteAddress, $defaultAddress)
    {
        if ($quoteAddress && $quoteAddress->getId() && $defaultAddress && $defaultAddress->getId()) {
            $customerId = $quoteAddress->getCustomerId();
            $customerAddressId = $quoteAddress->getCustomerAddressId();
            if (empty($customerAddressId) || $customerAddressId != $defaultAddress->getId()) {
                $quoteAddress->setCustomerAddressId($defaultAddress->getId())->setCustomerId($customerId);
                $quoteAddress->addData($defaultAddress->getData());
                $quoteAddress->save();
            }
        }
    }

    public function beforeOrderCreateLoadBlock()
    {
        if (!Mage::helper('iwd_ordermanager')->isCustomCreationProcess()) {
            return;
        }

        $this->recollectShipping();
        $this->selectDefaultShippingMethod();
    }

    protected function recollectShipping()
    {
        /**
         * @var $quote Mage_Sales_Model_Quote
         */
        $quote = Mage::getSingleton('adminhtml/session_quote')->getQuote();
        $request = Mage::app()->getRequest();

        $request->setPost('reset_shipping', 0);
        $quote->getShippingAddress()->setCollectShippingRates(true)->save();
    }

    protected function selectDefaultShippingMethod()
    {
        $quote = Mage::getSingleton('adminhtml/session_quote')->getQuote();
        $request = Mage::app()->getRequest();

        $shippingMethod = $quote->getShippingAddress()->getShippingMethod();
        $order = Mage::app()->getRequest()->getParam('order', array());

        if (empty($shippingMethod) && !isset($order['shipping_method'])) {
            $defaultShippingMethod = Mage::getStoreConfig('iwd_ordermanager/crate_process/default_shipping');
            $order = $request->getPost('order');
            $order['shipping_method'] = $defaultShippingMethod;
            $request->setPost('order', $order);
        }
    }

    /**
     * @param Varien_Event_Observer $observer
     */
    public function backupOrderBeforeEdit(Varien_Event_Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $orderItems = $observer->getEvent()->getOrderItems();

        /**
         * @var $backup IWD_OrderManager_Model_Backup_Sales
         */
        $backup = Mage::getModel('iwd_ordermanager/backup_sales');
        $backup->saveBackup($order, $orderItems, 'order', 'edit');

        $backupId = $order->getIwdBackupId();
        $autoReAuthorization = Mage::helper('iwd_ordermanager')->isAutoReAuthorization();

        if (empty($backupId) && !$autoReAuthorization) {
            $allowedForReauthorize = Mage::getModel('iwd_ordermanager/payment_payment')->isPaymentAllowedForReauthorize($order);
            if ($allowedForReauthorize) {
                $order->setData('iwd_backup_id', $backup->getId())->save();
            }
        }
    }

    /**
     * @param Varien_Event_Observer $observer
     * @return $this
     */
    public function addFeeToQuote(Varien_Event_Observer $observer)
    {
        $request = $observer->getEvent()->getRequest();

        $quote = $observer->getEvent()->getOrderCreateModel()->getQuote();

        if (isset($request['iwd_om_fee_amount'])) {
            $feeAmount = $request['iwd_om_fee_amount'];
            $baseFeeAmount = $this->convertToBaseAmount($feeAmount, $quote);
            $quote->setIwdOmFeeAmount($feeAmount)->setIwdOmFeeBaseAmount($baseFeeAmount);
        }

        if (isset($request['iwd_om_fee_amount_incl_tax'])) {
            $feeAmountInclTax = $request['iwd_om_fee_amount_incl_tax'];
            $baseFeeAmountInclTax = $this->convertToBaseAmount($feeAmountInclTax, $quote);
            $quote->setIwdOmFeeAmountInclTax($feeAmountInclTax)->setIwdOmFeeBaseAmountInclTax($baseFeeAmountInclTax);
        }

        if (isset($request['iwd_om_fee_description'])) {
            $description = $request['iwd_om_fee_description'];
            $quote->setIwdOmFeeDescription($description);
        }

        if (isset($request['iwd_om_fee_tax_percent'])) {
            $taxPercent = $request['iwd_om_fee_tax_percent'];
            $quote->setIwdOmFeeTaxPercent($taxPercent);
        }

        try {
            $quote->save();
        } catch (Mage_Core_Exception $e) {
            Mage::getSingleton('adminhtml/session_quote')->addError($e->getMessage());
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session_quote')->addException(
                $e, Mage::helper('opc')->__('Cannot apply custom amount')
            );
        }

        return $this;
    }

    /**
     * @param $feeAmount
     * @param $quote
     * @return float
     */
    protected function convertToBaseAmount($feeAmount, $quote)
    {
        $baseCurrencyCode = $quote->getStore()->getBaseCurrencyCode();
        $currentCurrencyCode = $quote->getStore()->getCurrentCurrencyCode();

        $baseFeeAmount = ($baseCurrencyCode != $currentCurrencyCode)
            ? Mage::helper('directory')->currencyConvert($feeAmount, $currentCurrencyCode, $baseCurrencyCode)
            : $feeAmount;

        return round($baseFeeAmount, 2);
    }
}
