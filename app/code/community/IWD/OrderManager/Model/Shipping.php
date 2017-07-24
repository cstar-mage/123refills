<?php
class IWD_OrderManager_Model_Shipping extends Mage_Core_Model_Abstract
{
    const CUSTOM_METHOD_CODE = 'ordermanager_custom';

    protected $params;

    public function updateOrderShipping($params)
    {
        $this->init($params);

        if (isset($params['confirm_edit']) && !empty($params['confirm_edit'])) {
            $this->addChangesToConfirm();
        } else {
            $shipping = $this->prepareShippingObj($this->params);

            $this->editSipping($this->params['order_id'], $shipping);
            $this->addChangesToLog();
        }
    }

    public function editSipping($orderId, $shipping)
    {
        /** @var $orderEdit IWD_OrderManager_Model_Order_Edit */
        $orderEdit = Mage::getModel('iwd_ordermanager/order_edit');
        $order = Mage::getModel('sales/order')->load($orderId);
        $oldOrder = clone $order;
        Mage::dispatchEvent('iwd_ordermanager_update_order_amount_before', array('order' => $order, 'order_items' => $order->getItemsCollection()));

        $oldShipping = $order->getShippingDescription() . " (" . Mage::helper('core')->currency($order->getShippingInclTax(), true, false) . ")";

        $this->updateOrderShippingInformation($order, $shipping);

        $orderEdit->collectOrderTotals($orderId);
        $orderEdit->updateOrderPayment($orderId, $oldOrder);

        $newShipping = $shipping->getDescription() . " (" . Mage::helper('core')->currency($shipping->getAmountInclTax(), true, false) . ")";
        $this->getLogger()->addChangesToLog("shipping_method", $oldShipping, $newShipping);

        $this->notifyEmail();

        return 1;
    }

    public function getLogger()
    {
        return Mage::getSingleton('iwd_ordermanager/logger');
    }

    public function getShippingRates($order)
    {
        $request = $this->prepareShippingRequest($order);
        $shipping = Mage::getModel('shipping/shipping');

        try {
            $result = $shipping->collectRates($request)->getResult();

            if ($result) {
                $rates = array();
                foreach ($result->getAllRates() as $_rate) {
                    $rate = new Varien_Object();
                    $rate->setData($_rate->getData());
                    $carrier = $rate->getCarrier();

                    if (!isset($rates[$carrier])) {
                        $rates[$carrier] = array();
                    }

                    $rate->setCode($carrier . '_' . $rate->getMethod());
                    $rates[$carrier][$rate->getCode()] = $rate;
                }
                return $rates;
            }
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log($e->getMessage());
        }

        return null;
    }

    protected function init($params)
    {
        if (!isset($params['order_id'])) {
            Mage::throwException("Order id is not defined");
        }

        $this->params = $params;
    }

    protected function notifyEmail()
    {
        $notify = isset($this->params['notify']) ? $this->params['notify'] : null;
        $orderId = $this->params['order_id'];

        if ($notify) {
            $message = isset($this->params['comment_text']) ? $this->params['comment_text'] : null;
            $email = isset($this->params['comment_email']) ? $this->params['comment_email'] : null;
            Mage::getModel('iwd_ordermanager/notify_notification')->sendNotifyEmail($orderId, $email, $message);
        }
    }

    protected function addChangesToConfirm()
    {
        $orderId = $this->params['order_id'];
        $order = Mage::getModel('sales/order')->load($orderId);
        $shipping = $this->prepareShippingObj($this->params);

        $oldShipping = $order->getShippingDescription() . " (" . Mage::helper('core')->currency($order->getBaseShippingInclTax(), true, false) . ")";
        $newShipping = $shipping->getDescription() . " (" . Mage::helper('core')->currency($shipping->getAmountInclTax(), true, false) . ")";

        $baseCurrencyCode = $order->getBaseCurrencyCode();
        $orderCurrencyCode = $order->getOrderCurrencyCode();
        $baseGrandTotal = $order->getBaseGrandTotal() - $order->getBaseShippingInclTax() + $shipping->getAmountInclTax();
        $grand_total = Mage::helper('directory')->currencyConvert($baseGrandTotal, $baseCurrencyCode, $orderCurrencyCode);
        $totals = array(
            'grand_total' => $grand_total,
            'base_grand_total' => $baseGrandTotal,
        );

        $logger = $this->getLogger();

        $logger->addNewTotalsToLog($totals);
        $logger->addChangesToLog("shipping_method", $oldShipping, $newShipping);
        $logger->addCommentToOrderHistory($orderId, 'wait');
        $logger->addLogToLogTable(IWD_OrderManager_Model_Confirm_Options_Type::SHIPPING, $orderId, $this->params);

        $message = Mage::helper('iwd_ordermanager')
            ->__('Order update not yet applied. Customer has been sent an email with a confirmation link. Updates will be applied after confirmation.');
        Mage::getSingleton('adminhtml/session')->addNotice($message);
    }

    protected function addChangesToLog()
    {
        $logger = $this->getLogger();
        $orderId = $this->params['order_id'];
        $logger->addCommentToOrderHistory($orderId);
        $logger->addLogToLogTable(IWD_OrderManager_Model_Confirm_Options_Type::SHIPPING, $orderId);
    }

    protected function updateOrderShippingInformation($order, $shipping)
    {
        $baseShippingInclTax = $shipping->getAmountInclTax();
        $baseShippingAmount = $shipping->getAmount();
        $baseShippingTaxAmount = $baseShippingInclTax - $baseShippingAmount;

        /** convert currency **/
        $baseCurrencyCode = $order->getBaseCurrencyCode();
        $orderCurrencyCode = $order->getOrderCurrencyCode();
        if ($baseCurrencyCode === $orderCurrencyCode) {
            $shippingAmount = $baseShippingAmount;
            $shippingInclTax = $baseShippingInclTax;
            $shippingTaxAmount = $baseShippingTaxAmount;
        } else {
            $directory = Mage::helper('directory');
            $shippingAmount = $directory->currencyConvert($baseShippingAmount, $baseCurrencyCode, $orderCurrencyCode);
            $shippingInclTax = $directory->currencyConvert($baseShippingInclTax, $baseCurrencyCode, $orderCurrencyCode);
            $shippingTaxAmount = $directory->currencyConvert($baseShippingTaxAmount, $baseCurrencyCode, $orderCurrencyCode);
        }

        $order
            ->setShippingDescription($shipping->getDescription())->setShippingMethod($shipping->getMethod())
            ->setShippingAmount($shippingAmount)->setBaseShippingAmount($baseShippingAmount)
            ->setShippingInclTax($shippingInclTax)->setBaseShippingInclTax($baseShippingInclTax)
            ->setShippingTaxAmount($shippingTaxAmount)->setBaseShippingTaxAmount($baseShippingTaxAmount)
            ->save();
    }

    /* edit order  - recollect shipping */
    public function recollectShippingAmount($orderId)
    {
        $order = Mage::getModel('sales/order')->load($orderId);

        if ($order->getShippingMethod() == self::CUSTOM_METHOD_CODE) {
            return $this->recollectShippingWithCustomShippingMethod($order);
        }

        return $this->recollectShippingWithStandardShippingMethod($order);
    }

    protected function recollectShippingWithCustomShippingMethod($order)
    {
        //add shipping tax
        $taxAmount = $order->getTaxAmount() + $order->getShippingTaxAmount();
        $baseTaxAmount = $order->getBaseTaxAmount() + $order->getBaseShippingTaxAmount();
        $order->setTaxAmount($taxAmount)->setBaseTaxAmount($baseTaxAmount)->save();

        return $order->getShippingAmount() - $order->getShippingInvoiced();
    }

    protected function recollectShippingWithStandardShippingMethod($order)
    {
        $oldAmount = $order->getBaseShippingInclTax();
        $request = $this->prepareShippingRequest($order);

        $result = Mage::getModel('shipping/shipping')
            ->collectRates($request)
            ->getResult();

        if ($result) {
            $shippingRates = $result->getAllRates();

            foreach ($shippingRates as $shippingRate) {
                $rate = Mage::getModel('sales/quote_address_rate')->importShippingRate($shippingRate)->getData();
                if ($order->getShippingMethod() == $rate['code']) {

                    /** convert currency **/
                    $baseCurrencyCode = $order->getBaseCurrencyCode();
                    $orderCurrencyCode = $order->getOrderCurrencyCode();
                    $price = Mage::helper('directory')->currencyConvert($rate["price"], $baseCurrencyCode, $orderCurrencyCode);
                    $basePrice = $rate["price"];

                    $newAmount = $this->collectShipping($order, $price, $basePrice);

                    $newAmountCurrency = Mage::helper('core')->currency($newAmount, true, false);
                    $oldAmountCurrency = Mage::helper('core')->currency($oldAmount, true, false);
                    $this->getLogger()->addChangesToLog("shipping_amount", $oldAmountCurrency, $newAmountCurrency);

                    return $basePrice - $order->getShippingInvoiced();
                }
            }
        }

        return $order->getShippingAmount() - $order->getShippingInvoiced();
    }


    public function prepareShippingRequest($order)
    {
        if ($order->getIsVirtual()) {
            return null;
        }

        $qtyOrdered = $this->getQtyOrderItems($order);
        $weight = $this->getOrderWeight($order);

        $storeId = $order->getStoreId();
        $websiteId = Mage::getModel('core/store')->load($storeId)->getWebsiteId();
        $shippingId = $order->getShippingAddress()->getId();
        $address = Mage::getModel('sales/order_address')->load($shippingId);
        $request = Mage::getModel('shipping/rate_request');
        $baseCurrencyCode = Mage::app()->getStore()->getBaseCurrency();
        $orderCurrencyCode = $order->getOrderCurrencyCode();
        $allItems = $this->getAllOrderItems($order);

        $request->setDestCountryId($address->getCountryId())
            ->setDestRegionId($address->getRegionId())
            ->setDestPostcode($address->getPostcode())
            ->setDestCity($address->getCity())
            ->setPackageValue($order->getBaseSubtotal())
            ->setPackageValueWithDiscount($order->getBaseSubtotalWithDiscount())
            ->setPackageWeight($weight)
            ->setFreeMethodWeight($address->getFreeMethodWeight())
            ->setPackageQty($qtyOrdered)
            ->setStoreId($storeId)
            ->setWebsiteId($websiteId)
            ->setBaseCurrency($baseCurrencyCode)
            ->setPackageCurrency($orderCurrencyCode)
            ->setBaseSubtotalInclTax($order->getBaseSubtotalInclTax())
            ->setAllItems($allItems)
            ->setPackagePhysicalValue($order->getBaseSubtotal());

        return $request;
    }

    protected function getAllOrderItems($order)
    {
        $items = $order->getAllItems();
        foreach ($items as $item) {
            $item->setHasChildren(false);
        }

        return $items;
    }

    protected function getQtyOrderItems($order)
    {
        $qty_ordered = 0;
        $orderItems = $order->getAllItems();
        foreach ($orderItems as $order_item) {
            if ($order_item->getIsVirtual() != 0 || $order_item->getParentItemId() != null) {
                continue;
            }

            $qty_ordered += $order_item->getQtyOrdered() - $order_item->getQtyRefunded() - $order_item->getQtyCanceled();
        }

        return $qty_ordered;
    }

    protected function getOrderWeight($order)
    {
        $weight = 0;
        $orderItems = $order->getAllItems();
        foreach ($orderItems as $order_item) {
            if ($order_item->getIsVirtual() != 0 || $order_item->getParentItemId() != null) {
                continue;
            }

            $weight += $order_item->getWeight() * ($order_item->getQtyOrdered() - $order_item->getQtyRefunded() - $order_item->getQtyCanceled());
        }

        return $weight;
    }

    protected function collectShipping($order, $shippingAmount, $baseShippingAmount, $estimate = false)
    {
        $store = $order->getStore();
        $shippingId = $order->getShippingAddress()->getId();
        $billingId = $order->getBillingAddress()->getId();
        $shippingAddress = Mage::getModel('sales/order_address')->load($shippingId);
        $billingAddress = Mage::getModel('sales/order_address')->load($billingId);
        $shippingTaxClass = Mage::getStoreConfig(Mage_Tax_Model_Config::CONFIG_XML_PATH_SHIPPING_TAX_CLASS, $store);
        $taxCalculationModel = Mage::getSingleton('tax/calculation');
        $customerGroupId = $order->getCustomerGroupId();
        $customerTaxClassId = Mage::getModel('customer/group')->getTaxClassId($customerGroupId);
        $shippingTaxAmount = 0;
        $baseShippingTaxAmount = 0;

        if ($shippingTaxClass) {
            $request = $taxCalculationModel->getRateRequest($shippingAddress, $billingAddress, $customerTaxClassId, $store);

            if ($rate = $taxCalculationModel->getRate($request->setProductClassId($shippingTaxClass))) {
                $shippingTaxAmount = $shippingAmount - $shippingAmount / (1 + $rate / 100);
                $baseShippingTaxAmount = $baseShippingAmount - $baseShippingAmount / (1 + $rate / 100);

                $shippingTaxAmount = $store->roundPrice($shippingTaxAmount);
                $baseShippingTaxAmount = $store->roundPrice($baseShippingTaxAmount);
                $order->setTaxAmount($order->getTaxAmount() + $shippingTaxAmount);
                $order->setBaseTaxAmount($order->getBaseTaxAmount() + $baseShippingTaxAmount);
            }
        }

        if (Mage::helper('tax')->shippingPriceIncludesTax()) {
            $baseSippingInclTax = $baseShippingAmount;
            $baseSippingAmount = $baseShippingAmount - $baseShippingTaxAmount;
            $sippingInclTax = $shippingAmount;
            $sippingAmount = $shippingAmount - $shippingTaxAmount;
        } else {
            $baseSippingInclTax = $baseShippingAmount + $baseShippingTaxAmount;
            $baseSippingAmount = $baseShippingAmount;
            $sippingInclTax = $shippingAmount + $shippingTaxAmount;
            $sippingAmount = $shippingAmount;
        }

        if (!$estimate) {
            $order
                ->setShippingInclTax($sippingInclTax)->setBaseShippingInclTax($baseSippingInclTax)
                ->setShippingTaxAmount($shippingTaxAmount)->setBaseShippingTaxAmount($baseShippingTaxAmount)
                ->setShippingAmount($sippingAmount)->setBaseShippingAmount($baseSippingAmount)
                ->save();
        }

        return $baseSippingInclTax;
    }

    public function prepareShippingObj($params)
    {
        $method = $params['shipping_method_radio'];
        $shipping = new Varien_Object();

        $shipping->setDescription($params['s_description'][$method])
            ->setAmount($params['s_amount_excl_tax'][$method])
            ->setAmountInclTax($params['s_amount_incl_tax'][$method])
            ->setTaxPercent($params['s_tax_percent'][$method])
            ->setMethod($method);

        return $shipping;
    }

    public function estimateShippingAmount($order, $request, $estimate=true)
    {
        $oldAmount = $order->getBaseShippingInclTax();
        if ($order->getShippingMethod() == self::CUSTOM_METHOD_CODE) {
            return $oldAmount;
        }

        $shipping = Mage::getModel('shipping/shipping');
        $result = $shipping->collectRates($request)->getResult();
        $baseCurrencyCode = $order->getBaseCurrencyCode();
        $orderCurrencyCode = $order->getOrderCurrencyCode();

        if ($result) {
            $shippingRates = $result->getAllRates();

            foreach ($shippingRates as $shippingRate) {
                $rate = Mage::getModel('sales/quote_address_rate')->importShippingRate($shippingRate)->getData();
                if ($order->getShippingMethod() == $rate['code']) {

                    /** convert currency **/
                    $price = Mage::helper('directory')->currencyConvert($rate["price"], $baseCurrencyCode, $orderCurrencyCode);
                    $basePrice = $rate["price"];

                    /** recalculate **/
                    $newAmount = $this->collectShipping($order, $price, $basePrice, $estimate);

                    $newAmountCurrency = Mage::helper('core')->currency($newAmount, true, false);
                    $oldAmountCurrency = Mage::helper('core')->currency($oldAmount, true, false);

                    $this->getLogger()->addChangesToLog("shipping_amount", $oldAmountCurrency, $newAmountCurrency);

                    return $newAmount;
                }
            }
        }

        /** shipping is not available with this request **/
        $this->noticeShippingIsNotAvailable();
        return null;
    }

    protected function noticeShippingIsNotAvailable()
    {
        $notice = Mage::helper('iwd_ordermanager')->__('Selected shipping method is no longer available due to order requirements. Please select a new shipping method.');
        Mage::getSingleton('adminhtml/session')->addNotice($notice);
        $this->getLogger()->addNoticeToLog($notice);
    }
}
