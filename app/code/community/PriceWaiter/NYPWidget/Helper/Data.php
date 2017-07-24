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

class PriceWaiter_NYPWidget_Helper_Data extends Mage_Core_Helper_Abstract
{
    private $_product = false;
    private $_testing = false;
    private $_buttonEnabled = null;
    private $_conversionToolsEnabled = null;

    private $_widgetUrl = 'https://widget.pricewaiter.com';
    private $_manageUrl = 'https://manage.pricewaiter.com';
    private $_apiUrl = 'https://api.pricewaiter.com';

    public function __construct()
    {
        if (!!getenv('PRICEWAITER_WIDGET_URL')) {
            $this->_widgetUrl = getenv('PRICEWAITER_WIDGET_URL');
        }

        if (!!getenv('PRICEWAITER_MANAGE_URL')) {
            $this->_manageUrl = getenv('PRICEWAITER_MANAGE_URL');
        }

        if (!!getenv('PRICEWAITER_API_URL')) {
            $this->_apiUrl = getenv('PRICEWAITER_API_URL');
        }
    }

    public function isTesting()
    {
        return $this->_testing;
    }

    public function isEnabledForStore()
    {
        // Is the pricewaiter widget enabled for this store and an API Key has been set.
        if (Mage::getStoreConfig('pricewaiter/configuration/enabled')
            && Mage::getStoreConfig('pricewaiter/configuration/api_key')
        ) {
            return true;
        }

        return false;
    }

    // Set the values of $_buttonEnabled and $_conversionToolsEnabled
    private function _setEnabledStatus()
    {
        if ($this->_buttonEnabled != null && $this->_conversionToolsEnabled != null) {
            return true;
        }

        if (Mage::getStoreConfig('pricewaiter/configuration/enabled')) {
            $this->_buttonEnabled = true;
        }

        if (Mage::getStoreConfig('pricewaiter/conversion_tools/enabled')) {
            $this->_conversionToolsEnabled = true;
        }

        // Is the pricewaiter widget enabled for this product
        $product = $this->_getProduct();
        if (!is_object($product) or ($product->getId() and $product->getData('nypwidget_disabled'))) {
            $this->_buttonEnabled = false;
        }

        if (!is_object($product) or ($product->getId() and $product->getData('nypwidget_ct_disabled'))) {
            $this->_conversionToolsEnabled = false;
        }

        // Is the PriceWaiter widget enabled for this category
        $category = Mage::registry('current_category');
        if (is_object($category)) {
            $nypcategory = Mage::getModel('nypwidget/category')->loadByCategory($category);
            if (!$nypcategory->isActive()) {
                $this->_buttonEnabled = false;
            }
            if (!$nypcategory->isConversionToolsEnabled()) {
                $this->_conversionToolsEnabled = false;
            }
        } else {
            // We end up here if we are visiting the product page without being
            // "in a category". Basically, we arrived via a search page.
            // The logic here checks to see if there are any categories that this
            // product belongs to that enable the PriceWaiter widget. If not, return false.
            $categories = $product->getCategoryIds();
            $categoryActive = false;
            $categoryCTActive = false;
            foreach ($categories as $categoryId) {
                unset($currentCategory);
                unset($nypcategory);
                $currentCategory = Mage::getModel('catalog/category')->load($categoryId);
                $nypcategory = Mage::getModel('nypwidget/category')->loadByCategory($currentCategory);
                if ($nypcategory->isActive()) {
                    if ($nypcategory->isConversionToolsEnabled()) {
                        $categoryCTActive = true;
                    }
                    $categoryActive = true;
                    break;
                }
            }
            if (!$categoryActive) {
                $this->_buttonEnabled = false;
            }

            if (!$categoryCTActive) {
                $this->_conversionToolsEnabled = false;
            }

        }

        // Is PriceWaiter enabled for this Customer Group
        $disable = Mage::getStoreConfig('pricewaiter/customer_groups/disable');
        if ($disable) {
            // An admin has chosen to disable the PriceWaiter widget by customer group.
            $customerGroupId = Mage::getSingleton('customer/session')->getCustomerGroupId();
            $customerGroups = Mage::getStoreConfig('pricewaiter/customer_groups/group_select');
            $customerGroups = preg_split('/,/', $customerGroups);

            if (in_array($customerGroupId, $customerGroups)) {
                $this->_buttonEnabled = false;
            }
        }

        // Are Conversion Tools  enabled for this Customer Group
        $disableCT = Mage::getStoreConfig('pricewaiter/conversion_tools/customer_group_disable');
        if ($disableCT) {
            // An admin has chosen to disable the Conversion Tools by customer group.
            $customerGroupId = Mage::getSingleton('customer/session')->getCustomerGroupId();
            $customerGroups = Mage::getStoreConfig('pricewaiter/conversion_tools/group_select');
            $customerGroups = preg_split('/,/', $customerGroups);

            if (in_array($customerGroupId, $customerGroups)) {
                $this->_conversionToolsEnabled = false;
            }
        }
    }

    public function isConversionToolsEnabled()
    {
        $this->_setEnabledStatus();

        return $this->_conversionToolsEnabled;
    }

    public function isButtonEnabled()
    {
        $this->_setEnabledStatus();

        return $this->_buttonEnabled;
    }

    public function getButtonSettingsUrl()
    {
        $apiKey = Mage::getStoreConfig('pricewaiter/configuration/api_key');

        return sprintf("%s/stores/%s/button", $this->_manageUrl, $apiKey);
    }

    public function getWidgetUrl()
    {
        if ($this->isEnabledForStore()) {
            return $this->_widgetUrl . '/script/'
                . Mage::getStoreConfig('pricewaiter/configuration/api_key')
                . ".js";
        }

        return $this->_widgetUrl . '/nyp/script/widget.js';
    }

    public function getApiUrl()
    {
        return $this->_apiUrl . '/1/order/verify?api_key='
            . Mage::getStoreConfig('pricewaiter/configuration/api_key');
    }

    public function getProductPrice($product)
    {
        $productPrice = 0;

        if ($product->getId()) {
            if ($product->getTypeId() != 'grouped') {
                $productPrice = $product->getFinalPrice();
            }
        }

        return $productPrice;
    }

    private function _getProduct()
    {
        if (!$this->_product) {
            $this->_product = Mage::registry('current_product');
        }

        return $this->_product;
    }

    public function getGroupedProductInfo()
    {
        $product = $this->_getProduct();
        $javascript = "var PriceWaiterGroupedProductInfo =  new Array();\n";

        $associatedProducts = $product->getTypeInstance(true)->getAssociatedProducts($product);
        foreach ($associatedProducts as $simpleProduct) {
            $javascript .= "PriceWaiterGroupedProductInfo[" . $simpleProduct->getId() . "] = ";
            $javascript .= "new Array('" . htmlentities($simpleProduct->getName()) . "', '"
                . number_format($simpleProduct->getPrice(), 2) . "')\n";
        }

        return $javascript;
    }

    public function getStoreByApiKey($apiKey)
    {
        $stores = Mage::app()->getStores();

        // Find the store with the matching API key by checking the key for each store
        // in Magento
        foreach ($stores as $store) {
            if ($apiKey == Mage::getStoreConfig('pricewaiter/configuration/api_key', $store->getId())) {
                return $store;
            }
        }

        return Mage::app()->getStore();
    }

    /**
     * Returns the secret token used when communicating with PriceWaiter.
     * @return {String} Secret token
     */
    public function getSecret()
    {
        $token = Mage::getStoreConfig('pricewaiter/configuration/api_secret');

        if (is_null($token) || $token == '') {
            $token = bin2hex(openssl_random_pseudo_bytes(24));
            $config = Mage::getModel('core/config');

            $config->saveConfig('pricewaiter/configuration/api_secret', $token);
        }

        return $token;
    }

    /**
     * Returns a signature that can be added to the head of a PriceWaiter API response.
     * @param {String} $responseBody The full body of the request to sign.
     * @return {String} Signature that should be set as the X-PriceWaiter-Signature header.
     */
    public function getResponseSignature($responseBody)
    {
        $signature = 'sha256=' . hash_hmac('sha256', $responseBody, $this->getSecret(), false);
        return $signature;
    }

    /**
     * Validates that the current request came from PriceWaiter.
     * @param {String} $signatureHeader Full value of the X-PriceWaiter-Signature header.
     * @param {String} $requestBody Complete body of incoming request.
     * @return {Boolean} Wehther the request actually came from PriceWaiter.
     */
    public function isPriceWaiterRequestValid($signatureHeader = null, $requestBody = null)
    {
        if ($signatureHeader === null || $requestBody === null) {
            return false;
        }

        $detected = 'sha256=' . hash_hmac('sha256', $requestBody, $this->getSecret(), false);

        if (function_exists('hash_equals')) {
            // Favor PHP's secure hash comparison function in 5.6 and up.
            // For a robust drop-in compatibility shim, see: https://github.com/indigophp/hash-compat
            return hash_equals($detected, $signatureHeader);
        }

        return $detected === $signatureHeader;
    }

    /**
     * Finds the Product that matches the given options and SKU
     * @param {String} $sku SKU of the product
     * @param {Array} $productOptions An array of options for the product, name => value
     * @return {Object} Returns Mage_Catalog_Model_Product of product that matches options.
     */
    public function getProductWithOptions($sku, $productOptions)
    {
        $product = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToFilter('sku', $sku)
            ->addAttributeToSelect('*')
            ->getFirstItem();

        $additionalCost = null;

        if ($product->getTypeId() == 'configurable') {
            // Do configurable product specific stuff
            $attrs = $product->getTypeInstance(true)->getConfigurableAttributesAsArray($product);

            // Find our product based on attributes
            foreach ($attrs as $attr) {
                if (array_key_exists($attr['label'], $productOptions)) {
                    foreach ($attr['values'] as $value) {
                        if ($value['label'] == $productOptions[$attr['label']]) {
                            $valueIndex = $value['value_index'];
                            // If this attribute has a price assosciated with it, add it to the price later
                            if ($value['pricing_value'] != '') {
                                $additionalCost += $value['pricing_value'];
                            }
                            break;
                        }
                    }
                    unset($productOptions[$attr['label']]);
                    $productOptions[$attr['attribute_id']] = $valueIndex;
                }
            }

            $parentProduct = $product;
            $product = $product->getTypeInstance()->getProductByAttributes($productOptions, $product);
            $product->load($product->getId());
        }

        if ($additionalCost) {
            $product->setPrice($product->getPrice() + $additionalCost);
        }

        return $product;
    }

    public function getGroupedQuantity($productConfiguration)
    {
        $associatedProductIds = array_keys($productConfiguration['super_group']);
        $quantities = array();
        foreach ($associatedProductIds as $associatedProductId) {
            $associatedProduct = Mage::getModel('catalog/product')->load($associatedProductId);
            $quantities[] = $associatedProduct->getStockItem()->getQty();
        }

        return min($quantities);
    }

    public function getGroupedFinalPrice($productConfiguration)
    {
        $associatedProductIds = array_keys($productConfiguration['super_group']);
        $finalPrice = 0;
        foreach ($associatedProductIds as $associatedProductId) {
            $associatedProduct = Mage::getModel('catalog/product')->load($associatedProductId);
            $finalPrice += ($associatedProduct->getFinalPrice() * $productConfiguration['super_group'][$associatedProductId]);
        }
        return $finalPrice;
    }

    public function getGroupedCost($productConfiguration)
    {
        $associatedProductIds = array_keys($productConfiguration['super_group']);
        $costs = array();
        foreach ($associatedProductIds as $associatedProductId) {
            $associatedProduct = Mage::getModel('catalog/product')->load($associatedProductId);
            $costs[] = $associatedProduct->getData('cost');
        }

        return min($costs);
    }

    public function setHeaders()
    {
        $magentoEdition = 'Magento ' . Mage::getEdition();
        $magentoVersion = Mage::getVersion();
        $extensionVersion = Mage::getConfig()->getNode()->modules->PriceWaiter_NYPWidget->version;
        Mage::app()->getResponse()->setHeader('X-Platform', $magentoEdition, true);
        Mage::app()->getResponse()->setHeader('X-Platform-Version', $magentoVersion, true);
        Mage::app()->getResponse()->setHeader('X-Platform-Extension-Version', $extensionVersion, true);

        return true;
    }

    public function getCategoriesAsJSON($product)
    {
        $categorization = array();
        $assignedCategories = $product->getCategoryCollection()
            ->addAttributeToSelect('name');

        $baseUrl = Mage::app()->getStore()->getBaseUrl();

        // Find the path (parents) of each category, and add their information
        // to the categorization array
        foreach ($assignedCategories as $assignedCategory) {
            $parentCategories = array();
            $path = $assignedCategory->getPath();
            $parentIds = explode('/', $path);
            array_shift($parentIds); // We don't care about the root category

            $categoryModel = Mage::getModel('catalog/category');
            foreach($parentIds as $parentCategoryId) {
                $parentCategory = $categoryModel->load($parentCategoryId);
                $parentCategoryUrl = preg_replace('/^\//', '', $parentCategory->getUrlPath());

                $parentCategories[] = array(
                    'name' => $parentCategory->getName(),
                    'url' => $baseUrl . '/' . $parentCategoryUrl
                );
            }

            $categorization[] = $parentCategories;
        }

        return json_encode($categorization);
    }
}
