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

class PriceWaiter_NYPWidget_ProductinfoController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        // Ensure that we have received POST data
        $requestBody = Mage::app()->getRequest()->getRawBody();
        $postFields = Mage::app()->getRequest()->getPost();
        Mage::helper('nypwidget')->setHeaders();

        if (count($postFields) == 0) {
            $this->norouteAction();
            return;
        }

        // Validate the request
        // - return 400 if signature cannot be verified
        $signature = Mage::app()->getRequest()->getHeader('X-PriceWaiter-Signature');
        if (Mage::helper('nypwidget')->isPriceWaiterRequestValid($signature, $requestBody) == false) {
            Mage::app()->getResponse()->setHeader('HTTP/1.0 400 Bad Request Error', 400, true);
            return false;
        }

        // Process the request
        // - return 404 if the product does not exist (or PriceWaiter is not enabled)
        $productConfiguration = array();
        parse_str(urldecode($postFields['_magento_product_configuration']), $productConfiguration);

        // Create a cart and add the product to it
        // This is necessary to make Magento calculate the cost of the item in the correct context.
        try {
            $cart = Mage::getModel('checkout/cart');

            $product = Mage::getModel('catalog/product')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->load($productConfiguration['product']);

            $cart->addProduct($product, $productConfiguration);
            $cart->save();

            $cartItem = $cart->getQuote()->getAllItems();
            if ($product->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_SIMPLE
                || $product->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_BUNDLE
                || $product->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_GROUPED
            ) {
                $cartItem = $cartItem[0];
            } else {
                $cartItem = $cartItem[1];
            }

            if ($product->getTypeId() != Mage_Catalog_Model_Product_Type::TYPE_GROUPED) {
                $product = Mage::getModel('catalog/product')->load($cartItem->getProduct()->getId());
            }

            // Pull the product information from the cart item.
            if (is_object($product) && $product->getId()) {
                $productInformation = array();

                if (Mage::helper('nypwidget')->isEnabledForStore() &&
                    $product->getData('nypwidget_disabled') == 0
                ) {
                    $productInformation['allow_pricewaiter'] = true;
                } else {
                    $productInformation['allow_pricewaiter'] = false;
                }

                $productType = $product->getTypeId();
                if ($productType == Mage_Catalog_Model_Product_Type::TYPE_SIMPLE
                    || $productType == Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE
                ) {
                    $qty = $product->getStockItem()->getQty();
                    $productFinalPrice = $product->getFinalPrice();
                    $productPrice = $product->getPrice();
                    $msrp = $product->getData('msrp');
                    $cost = $product->getData('cost');
                } elseif ($productType == Mage_Catalog_Model_Product_Type::TYPE_GROUPED) {
                    $qty = Mage::helper('nypwidget')->getGroupedQuantity($productConfiguration);
                    $productFinalPrice = Mage::helper('nypwidget')->getGroupedFinalPrice($productConfiguration);
                    $productPrice = $productFinalPrice;
                    $msrp = false;
                    $cost = Mage::helper('nypwidget')->getGroupedCost($productConfiguration);
                } else {
                    $qty = $cartItem->getProduct()->getStockItem()->getQty();
                    $productFinalPrice = $cartItem->getPrice();
                    $productPrice = $cartItem->getFinalPrice();
                    $msrp = $cartItem->getData('msrp');
                    $cost = $cartItem->getData('cost');
                }

                // Check for backorders set for the site
                $backorder = false;
                if ($product->getStockItem()->getUseConfigBackorders() &&
                    Mage::getStoreConfig('cataloginventory/item_options/backorders')
                ) {
                    $backorder = true;
                } else if ($product->getStockItem()->getBackorders()) {
                    $backorder = true;
                }

                // If the product is returning a '0' quantity, but is "In Stock", set the "backorder" flag to true.
                if ($product->getStockItem()->getIsInStock() == 1 && $qty == 0) {
                    $backorder = true;
                }

                $productInformation['inventory'] = (int)$qty;
                $productInformation['can_backorder'] = $backorder;

                $productInformation['inventory'] = (int)$qty;

                $currency = Mage::app()->getStore()->getCurrentCurrencyCode();

                if ($productFinalPrice != 0) {
                    $productInformation['retail_price'] = (string)$productFinalPrice;
                    $productInformation['retail_price_currency'] = $currency;
                }

                if ($msrp != '') {
                    $productInformation['regular_price'] = (string)$msrp;
                    $productInformation['regular_price_currency'] = $currency;
                } elseif ($productPrice != 0) {
                    $productInformation['regular_price'] = (string)$productPrice;
                    $productInformation['regular_price_currency'] = $currency;
                }

                if ($cost) {
                    $productInformation['cost'] = (string)$cost;
                    $productInformation['cost_currency'] = (string)$productInformation['retail_price_currency'];
                }

                // Sign response and send.
                $json = json_encode($productInformation);
                $signature = Mage::helper('nypwidget')->getResponseSignature($json);

                Mage::app()->getResponse()->setHeader('X-PriceWaiter-Signature', $signature);
                Mage::app()->getResponse()->setBody($json);
            } else {
                Mage::app()->getResponse()->setHeader('HTTP/1.0 404 Not Found', 404, true);
                return;
            }
        } catch (Exception $e) {
            Mage::log("Unable to fulfill PriceWaiter Product Information request for product ID: " . $productConfiguration['product']);
            Mage::log($e->getMessage());
            Mage::app()->getResponse()->setHeader('HTTP/1.0 404 Not Found', 404, true);
            return;
        }
    }
}
