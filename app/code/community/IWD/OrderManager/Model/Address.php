<?php

/**
 * Class IWD_OrderManager_Model_Address
 */
class IWD_OrderManager_Model_Address
{
    /**
     * Billing Address
     */
    const TYPE_BILLING = 'billing';

    /**
     * Shipping Address
     */
    const TYPE_SHIPPING = 'shipping';

    /**
     * @var Mage_Sales_Model_Order_Address
     */
    protected $orderAddress;

    /**
     * @var
     */
    protected $address;

    /**
     * @var Mage_Sales_Model_Quote
     */
    protected $quote;

    /**
     * @return array
     */
    public function getOrderAddressFields()
    {
        $helper = Mage::helper('iwd_ordermanager');

        return array(
            'prefix' => $helper->__("Prefix"),
            'firstname' => $helper->__("First name"),
            'middlename' => $helper->__("Middle Name/Initial"),
            'lastname' => $helper->__("Last name"),
            'suffix' => $helper->__("Suffix"),
            'company' => $helper->__("Company"),
            'street' => $helper->__("Street Address"),

            'region' => $helper->__("State/Province"),
            'country' => $helper->__("Country"),
            'region_id' => $helper->__("State/Province"),
            'country_id' => $helper->__("Country "),

            'city' => $helper->__("City"),
            'postcode' => $helper->__("Zip/Postal Code"),
            'telephone' => $helper->__("Telephone"),
            'fax' => $helper->__("Fax"),
            'email' => $helper->__("E-mail"),
            'vat_id' => $helper->__("VAT number"),
        );
    }

    /**
     * @return mixed
     */
    public function isAllowEditAddress()
    {
        return Mage::getSingleton('admin/session')->isAllowed('iwd_ordermanager/order/actions/edit_address');
    }

    /**
     * @param $newAddress
     */
    public function updateOrderAddress($newAddress)
    {
        $this->init($newAddress);

        if (isset($newAddress['confirm_edit']) && !empty($newAddress['confirm_edit'])) {
            $this->addChangesToConfirm();
        } else {
            $this->editOrderAddress();
            $this->addChangesToLog();
        }
    }

    /**
     * @param null $address
     * @return bool
     */
    public function editOrderAddress($address = null)
    {
        if ($address !== null) {
            $this->init($address);
        }

        $this->updateOrderAmounts();
        $this->updateOrderAddressFields();

        $this->notifyEmail();

        return true;
    }

    /**
     * @return void
     */
    protected function notifyEmail()
    {
        $notify = isset($this->address['notify']) ? $this->address['notify'] : null;
        $orderId = $this->address['order_id'];

        if ($notify) {
            $message = isset($this->address['comment_text']) ? $this->address['comment_text'] : "";
            $email = isset($this->address['comment_email']) ? $this->address['comment_email'] : null;
            Mage::getModel('iwd_ordermanager/notify_notification')->sendNotifyEmail($orderId, $email, $message);
        }
    }

    /**
     * @param $params
     */
    protected function init($params)
    {
        if (!isset($params['address_id'])) {
            Mage::throwException("Address id is not defined");
        }

        $this->orderAddress = Mage::getModel('sales/order_address')->load($params['address_id']);
        $this->address = $params;

        $this->setRegion();
        $this->setStreet();
    }

    /**
     * @return void
     */
    protected function setStreet()
    {
        if (is_array($this->address['street'])) {
            $this->address['street'] = trim(implode("\n", $this->address['street']));
        }
    }

    /**
     * @param $streetArray
     * @return string
     */
    protected function getStreetString($streetArray)
    {
        if (is_array($streetArray)) {
            return trim(implode("\n", $streetArray));
        }

        return $streetArray;
    }

    /**
     * @return void
     */
    protected function setRegion()
    {
        if (isset($this->address['region']) && empty($this->address['region'])
            && (isset($this->address['region_id']) && !empty($this->address['region_id']))
        ) {
            $this->address['region'] = Mage::getModel('directory/region')->load($this->address['region_id'])->getName();
        }
    }

    /**
     * @return void
     */
    public function addChangesToConfirm()
    {
        $logger = Mage::getSingleton('iwd_ordermanager/logger');
        $orderId = Mage::getModel('sales/order_address')->load($this->address['address_id'])->getParentId();
        $type = $this->orderAddress->getAddressType() == self::TYPE_BILLING
            ? IWD_OrderManager_Model_Confirm_Options_Type::BILLING_ADDRESS
            : IWD_OrderManager_Model_Confirm_Options_Type::SHIPPING_ADDRESS;

        $this->estimateUpdateOrderAddressFields();
        $this->estimateUpdateOrderAmounts();

        $logger->addCommentToOrderHistory($orderId, 'wait');
        $logger->addLogToLogTable($type, $orderId, $this->address);

        $message = Mage::helper('iwd_ordermanager')
            ->__('Order update not yet applied. Customer has been sent an email with a confirmation link. Updates will be applied after confirmation.');
        Mage::getSingleton('adminhtml/session')->addNotice($message);
    }

    /**
     * @return void
     */
    protected function addChangesToLog()
    {
        $logger = Mage::getSingleton('iwd_ordermanager/logger');
        $orderId = Mage::getModel('sales/order_address')->load($this->address['address_id'])->getParentId();

        $type = $this->orderAddress->getAddressType() == self::TYPE_BILLING
            ? IWD_OrderManager_Model_Confirm_Options_Type::BILLING_ADDRESS
            : IWD_OrderManager_Model_Confirm_Options_Type::SHIPPING_ADDRESS;

        $logger->addCommentToOrderHistory($orderId);
        $logger->addLogToLogTable($type, $orderId);
    }

    /**
     * @return bool
     */
    protected function estimateUpdateOrderAmounts()
    {
        if ($this->isNeedRecalculateOrderTotalAmount($this->address, $this->orderAddress)) {
            $baseShippingInclTax = $this->recalculateOrderTotalAmount(true);

            if ($baseShippingInclTax !== null) {
                $orderId = $this->orderAddress->getParentId();
                $order = Mage::getModel('sales/order')->load($orderId);

                $baseCurrencyCode = $order->getBaseCurrencyCode();
                $orderCurrencyCode = $order->getOrderCurrencyCode();
                $baseGrandTotal = $order->getBaseGrandTotal() - $order->getBaseShippingInclTax() + $baseShippingInclTax;
                $grandTotal = Mage::helper('directory')->currencyConvert($baseGrandTotal, $baseCurrencyCode, $orderCurrencyCode);
                $totals = array('grand_total' => $grandTotal, 'base_grand_total' => $baseGrandTotal);

                Mage::getSingleton('iwd_ordermanager/logger')->addNewTotalsToLog($totals);
            }

            return $baseShippingInclTax;
        }

        return true;
    }

    /**
     * @return bool
     */
    protected function updateOrderAmounts()
    {
        if ($this->isNeedRecalculateOrderTotalAmount($this->address, $this->orderAddress)) {
            $orderId = $this->orderAddress->getParentId();
            $order = Mage::getModel('sales/order')->load($orderId);

            $baseShippingInclTax = $this->recalculateOrderTotalAmount(false);
            if ($baseShippingInclTax !== null) {
                Mage::dispatchEvent(
                    'iwd_ordermanager_update_order_amount_before',
                    array('order' => $order, 'order_items' => $order->getItemsCollection())
                );

                /**
                 * @var $orderEdit IWD_OrderManager_Model_Order_Edit
                 */
                $orderEdit = Mage::getModel('iwd_ordermanager/order_edit');
                $orderEdit->collectOrderTotals($orderId);
                $orderEdit->updateOrderPayment($orderId, $order);
            }

            return $baseShippingInclTax;
        }

        return true;
    }

    /**
     * @param $address
     * @param $orderAddress
     * @return bool
     */
    public function isNeedRecalculateOrderTotalAmount($address, $orderAddress)
    {
        if (isset($address['recalculate_amount']) && $address['recalculate_amount']) {
            $fieldsWhichAffectToTotals = array('street', 'city', 'region', 'country', 'region_id', 'country_id', 'postcode');

            foreach ($fieldsWhichAffectToTotals as $field) {
                if (isset($address[$field]) && !empty($address[$field])) {
                    if ($field == 'street') {
                        $address[$field] = $this->getStreetString($address[$field]);
                    }

                    if ($address[$field] != $orderAddress->getData($field)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * @param $estimate
     * @return mixed
     */
    protected function recalculateOrderTotalAmount($estimate)
    {
        $orderId = $this->orderAddress->getParentId();
        $order = Mage::getModel('sales/order')->load($orderId);

        $shipping = Mage::getModel('iwd_ordermanager/shipping');
        $request = $shipping->prepareShippingRequest($order);

        $request
            ->setDestCountryId($this->address['country_id'])
            ->setDestRegionId($this->address['region_id'])
            ->setDestPostcode($this->address['postcode'])
            ->setDestCity($this->address['city']);

        $shippingAmount = $shipping->estimateShippingAmount($order, $request, $estimate);

        if (empty($shippingAmount)) {
            //TODO: show form with available shipping methods and change method
            $shippingAmount = $order->getBaseShippingAmount();
        }

        return $shippingAmount;
    }

    /**
     * @return void
     */
    protected function updateOrderAddressFields()
    {
        $logger = Mage::getSingleton('iwd_ordermanager/logger');
        $addressType = $this->orderAddress->getAddressType();

        $addressFields = $this->getOrderAddressFields();
        foreach ($addressFields as $field => $title) {
            if (!isset($this->address[$field])) {
                continue;
            }

            $logger->addAddressFieldChangesToLog(
                $addressType, $field, $title,
                $this->orderAddress->getData($field),
                $this->address[$field]
            );

            $this->orderAddress->setData($field, $this->address[$field]);
        }

        $this->orderAddress->save();
    }

    /**
     * @return void
     */
    protected function estimateUpdateOrderAddressFields()
    {
        $logger = Mage::getSingleton('iwd_ordermanager/logger');
        $addressType = $this->orderAddress->getAddressType();

        $addressFields = $this->getOrderAddressFields();
        foreach ($addressFields as $field => $title) {
            if (!isset($this->address[$field])) {
                continue;
            }

            $logger->addAddressFieldChangesToLog(
                $addressType, $field, $title,
                $this->orderAddress->getData($field),
                $this->address[$field]
            );
        }
    }

    /**
     * @param $quote
     */
    protected function updateQuoteAddress($quote)
    {
        $address = $quote->getShippingAddress();

        if ($address) {
            $addressFields = $this->getOrderAddressFields();
            foreach ($addressFields as $field => $title) {
                if (!isset($this->address[$field])) {
                    continue;
                }

                $address->setData($field, $this->address[$field]);
            }

            $address->save();
        }
    }
}
