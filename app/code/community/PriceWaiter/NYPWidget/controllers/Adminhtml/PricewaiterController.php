<?php

/*
 * Copyright 2013-2015 Price Waiter, LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 *
 */

class PriceWaiter_NYPWidget_Adminhtml_PriceWaiterController extends Mage_Adminhtml_Controller_Action
{

    private $_tokenUrl = 'https://api.pricewaiter.com/store-signups';

    public function tokenAction()
    {
        try {
            $user = Mage::getSingleton('admin/session')->getUser();
            $scope = Mage::app()->getRequest()->getParam('scope');


            // Determine store from scope
            if (preg_match('/^store/', $scope)) {
                $store = Mage::getModel('core/store')->load(substr($scope, 6));
                $website = Mage::getModel('core/website')->load($store->getWebsiteId());
            } else if (preg_match('/^website/', $scope)) {
                $website = Mage::getModel('core/website')->load(substr($scope, 8));
                $store = $website->getStoreCollection()->getFirstItem();
            } else {
                // Load the defaults
                $storeId = Mage::app()->getWebsite(true)->getDefaultGroup()
                    ->getDefaultStoreId();
                $store = Mage::getModel('core/store')->load($storeId);
                $website = Mage::getModel('core/website')->load($store->getWebsiteId());
            }

            // Get the name of the store from the group.
            $storeName = $store->getGroup()->getName();

            // Build post request and send information to PriceWaiter to assist in signup process.
            $postFields = array(
                'platform' => 'magento',
                'admin_email' => $user->getEmail(),
                'admin_first_name' => $user->getFirstname(),
                'admin_last_name' => $user->getLastname(),
                'store_name' => $storeName,
                'store_url' => $store->getBaseUrl(),
                'customer_service_name' => Mage::getStoreConfig('trans_email/ident_support/name'),
                'customer_service_email' => Mage::getStoreConfig('trans_email/ident_support/email'),
                'store_country' => Mage::getStoreConfig('general/country/default'),
                'store_shipping_countries' => Mage::getStoreConfig('general/country/allow'),
                'store_currency' => Mage::getStoreConfig('currency/options/base'),
                'store_languages' => Mage::getStoreConfig('general/locale/code'),
                'store_paypal_email' => Mage::getStoreConfig('paypal/general/business_account'),
                'store_order_callback_url' => Mage::getUrl('pricewaiter/callback'),
                'product_data_secret' => Mage::helper('nypwidget')->getSecret(),
                'product_data_url' => Mage::getUrl('pricewaiter/productinfo')
            );

            // Make a string from the POST fields
            $postString = '';
            foreach ($postFields as $k => $v) {
                if ($v != '') {
                    $postString .= $k . '=' . urlencode($v) . '&';
                }
            }
            $postString = rtrim($postString, '&');

            $ch = curl_init($this->_tokenUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);

            $response = curl_exec($ch);
            $response = json_decode($response);

            if ($response->status == '200') {
                Mage::app()->getResponse()->setBody($response->body->token);
                $config = Mage::getModel('core/config');
                $config->saveConfig('pricewaiter/configuration/sign_up_token', $response->body->token);
            }
        } catch (Exception $e) {
            Mage::log('Unable to generate PriceWaiter signup token.');
        }

        return;
    }

    public function secretAction()
    {
        $secret = Mage::helper('nypwidget')->getSecret();

        $this->getResponse()->clearHeaders()->setHeader(
            'Content-type', 'application/json', true
        );

        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode(array(
            'secret' => $secret
        )));
    }
}
