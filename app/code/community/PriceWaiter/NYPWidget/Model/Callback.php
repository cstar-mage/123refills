<?php

/*
 * Copyright 2013-2015 Price Waiter, LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */

class PriceWaiter_NYPWidget_Model_Callback
{

    private $_store;
    private $_product;

    private $_test = false;

    public function processRequest($request)
    {
        if ($request['test'] == 1) {
            $this->_test = true;
        }

        // Build URL to check validity of order notification.
        $url = Mage::helper('nypwidget')->getApiUrl();

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);

        try {
            // If PriceWaiter returns an invalid response
            if (curl_exec($ch) == "1") {
                $message = "The Name Your Price Widget has received a valid order notification.";
                if ($this->_test) {
                    $message .= ' This is a TEST order that will be created and canceled.';
                }
                Mage::log($message);
                $this->_log($message);
            } else {
                $message = "An invalid PriceWaiter order notification has been received.";
                throw(new Exception($message));
            }

            // Verify that we have not already received this callback based on the `pricewaiter_id` field
            $pricewaiterOrder = Mage::getModel('nypwidget/order');
            $pricewaiterOrder->loadByPriceWaiterId($request['pricewaiter_id']);
            if ($pricewaiterOrder->getId()) {
                $message = "Received a duplicate order from the PriceWaiter Callback API. Ignoring.";
                throw(new Exception($message));
            }


            // First, determine the store that this order corresponds to.
            // This is a new feature as of 1.2.2, so we need to make sure the API
            // is compatible first.
            if (array_key_exists('api_key', $request)
                && $request['api_key'] != ''
            ) {
                $store = Mage::helper('nypwidget')->getStoreByApiKey($request['api_key']);
                $this->_store = $store;
            } else {
                // Fallback for when the API key isn't found
                $this->_store = Mage::app()->getStore();
            }

            // Is this an existing customer?
            $customer = Mage::getModel('customer/customer')
                ->setWebsiteId($this->_store->getWebsiteId());
            $customer->loadByEmail($request['buyer_email']);

            if (!$customer->getId()) {
                // Create a new customer with this email
                $customer->reset();
                $passwordLength = 10;
                $passwordCharacters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $password = '';
                for ($p = 0; $p < $passwordLength; $p++) {
                    $password .= $passwordCharacters[mt_rand(0, strlen($passwordCharacters))];
                }

                $customer->setEmail($request['buyer_email']);
                $customer->setFirstname($request['buyer_first_name']);
                $customer->setLastname($request['buyer_last_name']);
                $customer->setPassword($password);
                $customer->setConfirmation(null);
                $customer->setWebsiteId($this->_store->getWebsiteId());
                $customer->save();
                if (Mage::getStoreConfig('pricewaiter/customer_interaction/send_welcome_email')) {
                    $customer->sendNewAccountEmail('registered', '', $this->_store->getId());
                }
                $customer->load($customer->getId());
            }

            $transaction = Mage::getModel('core/resource_transaction');
            $reservedOrderId = Mage::getSingleton('eav/config')->getEntityType('order')->fetchNewIncrementId($this->_store->getId());

            // Grab the currency code from the request, if one is set.
            // Otherwise, use the store's default currency code.
            if ($request['currency']) {
                $currencyCode = $request['currency'];
            } else {
                $currencyCode = $this->_store->getDefaultCurrencyCode();
            }

            $order = Mage::getModel('sales/order')
                ->setIncrementId($reservedOrderId)
                ->setStoreId($this->_store->getId())
                ->setQuoteId(0)
                ->setGlobal_currency_code($currencyCode)
                ->setBase_currency_code($currencyCode)
                ->setStore_currency_code($currencyCode)
                ->setOrder_currency_code($currencyCode);

            // set Customer data
            $order->setCustomer_email($customer->getEmail())
                ->setCustomerFirstname($customer->getFirstname())
                ->setCustomerLastname($customer->getLastname())
                ->setCustomerGroupId($customer->getGroupId())
                ->setCustomer_is_guest(0)
                ->setCustomer($customer);

            // Find billing Region ID
            $regionModel = Mage::getModel('directory/region')->loadByCode($request['buyer_billing_state'], $request['buyer_billing_country']);

            //Get a phone number, or make a dummy one
            if ($request['buyer_billing_phone']) {
                $telephone = $request['buyer_billing_phone'];
            } else {
                $telephone = "000-000-0000";
            }

            // set Billing Address
            $billing = $customer->getDefaultBillingAddress();
            $billingAddress = Mage::getModel('sales/order_address')
                ->setStoreId($this->_store->getId())
                ->setAddressType(Mage_Sales_Model_Quote_Address::TYPE_BILLING)
                ->setCustomerId($customer->getId())
                ->setPrefix('')
                ->setFirstname($request['buyer_billing_first_name'])
                ->setMiddlename('')
                ->setLastname($request['buyer_billing_last_name'])
                ->setSuffix('')
                ->setCompany('')
                ->setStreet(array($request['buyer_billing_address'], $request['buyer_billing_address2']))
                ->setCity($request['buyer_billing_city'])
                ->setCountry_id($request['buyer_billing_country'])
                ->setRegion($request['buyer_billing_state'])
                ->setRegion_id($regionModel->getId())
                ->setPostcode($request['buyer_billing_zip'])
                ->setTelephone($telephone)
                ->setFax('');
            $order->setBillingAddress($billingAddress);

            // Find shipping Region ID
            $regionModel = Mage::getModel('directory/region')->loadByCode($request['buyer_shipping_state'], $request['buyer_shipping_country']);

            //Get a phone number, or make a dummy one
            if ($request['buyer_shipping_phone']) {
                $telephone = $request['buyer_shipping_phone'];
            } else {
                $telephone = "000-000-0000";
            }

            // set Shipping Address
            $shipping = $customer->getDefaultShippingAddress();
            $shippingAddress = Mage::getModel('sales/order_address')
                ->setStoreId($this->_store->getId())
                ->setAddressType(Mage_Sales_Model_Quote_Address::TYPE_BILLING)
                ->setCustomerId($customer->getId())
                ->setPrefix('')
                ->setFirstname($request['buyer_shipping_first_name'])
                ->setMiddlename('')
                ->setLastname($request['buyer_shipping_last_name'])
                ->setSuffix('')
                ->setCompany('')
                ->setStreet(array($request['buyer_shipping_address'], $request['buyer_shipping_address2']))
                ->setCity($request['buyer_shipping_city'])
                ->setCountry_id($request['buyer_shipping_country'])
                ->setRegion($request['buyer_shipping_state'])
                ->setRegion_id($regionModel->getId())
                ->setPostcode($request['buyer_shipping_zip'])
                ->setTelephone($telephone)
                ->setFax('');

            // Apply shipping address to order, add PriceWaiter shipping method
            $order->setShippingAddress($shippingAddress)
                ->setShipping_method('nypwidget_nypwidget')
                ->setShipping_amount($request['shipping'])
                ->setShippingDescription('PriceWaiter');

            // Add PriceWaiter payment method
            $orderPayment = Mage::getModel('sales/order_payment')
                ->setStoreId($this->_store->getId())
                ->setCustomerPaymentId(0)
                ->setMethod('nypwidget');
            $order->setPayment($orderPayment);

            // Find the Product from the request
            $requestOptions = array();

            for ($i = $request['product_option_count']; $i > 0; $i--) {
                $requestOptions[$request['product_option_name' . $i]] = $request['product_option_value' . $i];
            }

            $this->_product = Mage::helper('nypwidget')->getProductWithOptions($request['product_sku'], $requestOptions);

            // Build the pricing information of the product
            $subTotal = 0;
            $rowTotal = ($request['unit_price'] * $request['quantity']) + $request['tax'];
            $itemDiscount = ($this->_product->getPrice() - $request['unit_price']);

            $orderItem = Mage::getModel('sales/order_item')
                ->setStoreId($this->_store->getId())
                ->setQuoteItemId(0)
                ->setQuoteParentItemId(NULL)
                ->setProductId($this->_product->getId())
                ->setProductType($this->_product->getTypeId())
                ->setQtyBackordered(NULL)
                ->setTotalQtyOrdered($request['quantity'])
                ->setQtyOrdered($request['quantity'])
                ->setName($this->_product->getName())
                ->setSku($this->_product->getSku())
                ->setPrice($request['unit_price'])
                ->setBasePrice($request['unit_price'])
                ->setOriginalPrice($this->_product->getPrice())
                // ->setDiscountAmount($itemDiscount)
                ->setTaxAmount($request['tax'])
                ->setRowTotal($rowTotal)
                ->setBaseRowTotal($rowTotal);

            // Do we have a simple product with custom options, a bundle product, or a grouped product?
            if (($this->_product->getTypeId() == 'simple'
                    || $this->_product->getTypeId() == 'bundle'
                    || $this->_product->getTypeId() == 'grouped')
                && $request['product_option_count'] > 0
            ) {
                // Grab the options from the request, build $additionalOptions array
                $additionalOptions = array();
                for ($i = $request['product_option_count']; $i > 0; $i--) {
                    $additionalOptions[] = array(
                        'label' => $request['product_option_name' . $i],
                        'value' => $request['product_option_value' . $i]
                    );
                }

                // Apply the $additionalOptions array to the simple product
                $orderItem->setProductOptions(array('additional_options' => $additionalOptions));
            }

            // Build and apply the order totals
            $subTotal += $rowTotal;
            $order->addItem($orderItem);

            $order->setSubtotal($subTotal)
                ->setBaseSubtotal($subTotal)
                ->setGrandTotal($subTotal + $request['shipping'])
                ->setBaseGrandTotal($subTotal + $request['shipping']);

            $order->addStatusHistoryComment("This order has been programmatically created by the PriceWaiter Name Your Price Widget.");

            // Ok, done with the order.
            $transaction->addObject($order);
            $transaction->addCommitCallback(array($order, 'place'));
            $transaction->addCommitCallback(array($order, 'save'));
            $transaction->save();

            // Add this order to the list of received callback orders
            $pricewaiterOrder->setData(array(
                'store_id' => $order->getStoreId(),
                'pricewaiter_id' => $request['pricewaiter_id'],
                'order_id' => $order->getId()
            ));
            $pricewaiterOrder->save();

            if (Mage::getStoreConfig('pricewaiter/customer_interaction/send_new_order_email')) {
                $order->sendNewOrderEmail();
            }

            // Add order Increment ID to response
            Mage::app()->getResponse()->setHeader('X-Platform-Order-Id', $order->getIncrementId());

            // If this is a test order, cancel it to prevent it from any further processing.
            if ($this->_test) {
                $order->cancel();
                $order->save();
                return;
            }

            // Capture the invoice
            $invoiceId = Mage::getModel('sales/order_invoice_api')
                ->create($order->getIncrementId(), array());
            $invoice = Mage::getModel('sales/order_invoice')
                ->loadByIncrementId($invoiceId);
            $invoice->capture()->save();


            Mage::log("The Name Your Price Widget has created order #"
                . $order->getIncrementId() . " with order ID " . $order->getId());
            $this->_log("The Name Your Price Widget has created order #"
                . $order->getIncrementId() . " with order ID " . $order->getId());
        } catch (Exception $e) {
            Mage::app()->getResponse()->setHeader('HTTP/1.0 500 Internal Server Error', 500, true);
            Mage::app()->getResponse()->setHeader('X-Platform-Error', $e->getMessage(), true);
            $this->_log("PriceWaiter Name Your Price Widget was unable to create order. Check log for details.");
            $this->_log($e->getMessage());
        }

    }

    private function _log($message)
    {
        if (Mage::getStoreConfig('pricewaiter/configuration/log')) {
            Mage::log($message, null, "PriceWaiter_Callback.log");
        }
    }
}
