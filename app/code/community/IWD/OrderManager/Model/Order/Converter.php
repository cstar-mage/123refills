<?php

/**
 * Class IWD_OrderManager_Model_Order_Converter
 */
class IWD_OrderManager_Model_Order_Converter extends Mage_Core_Model_Abstract
{
    /**
     * @var Mage_Sales_Model_Quote
     */
    private $quote;

    /**
     * @param $orderId
     * @return false|Mage_Core_Model_Abstract|Mage_Sales_Model_Quote
     * @throws Exception
     */
    public function convertOrderToQuote($orderId)
    {
        $order = $this->getOrder($orderId);

        $this->quote = Mage::getModel('sales/quote');
        $this->assignCustomerToQuote($order);
        $this->assignStoreToQuote($order);

        $this->quote->save();

        $this->assignAddressesToQuote($order);
        $this->quote->setIsActive(0);

        return $this->quote;
    }

    /**
     * @param $orderId
     * @return Mage_Sales_Model_Order
     * @throws Exception
     */
    protected function getOrder($orderId)
    {
        /**
         * @var $order Mage_Sales_Model_Order
         */
        $order = Mage::getModel('sales/order')->load($orderId);
        if (empty($order)) {
            throw new Exception('Order ID is empty');
        }

        $data = $order->getData();
        if (empty($data)) {
            throw new Exception('Order data is empty');
        }

        return $order;
    }

    /**
     * @param $order
     */
    protected function assignCustomerToQuote($order)
    {
        $store = Mage::getModel('core/store')->load($order->getStoreId());
        $websiteId = $store->getWebsiteId();
        $customer = Mage::getModel('customer/customer');
        $customer->setWebsiteId($websiteId);
        $customer->loadByEmail($order->getCustomerEmail());
        $this->quote->assignCustomer($customer);

        if ($order->getCustomerId()) {
            $customer = Mage::getModel('customer/customer')->load($order->getCustomerId());
            $this->quote->assignCustomer($customer);
        } else {
            $this->quote->setIsMultiShipping(false)
                ->setCheckoutMethod('guest')
                ->setCustomerId(null)
                ->setCustomerEmail($order->getCustomerEmail())
                ->setCustomerIsGuest(true)
                ->setCustomerGroupId(Mage_Customer_Model_Group::NOT_LOGGED_IN_ID);
        }
    }

    /**
     * @param $order
     */
    protected function assignAddressesToQuote($order)
    {
        $orderBillingAddress = $order->getBillingAddress();
        $orderShippingAddress = $order->getShippingAddress();

        try {
            $addressForm = Mage::getModel('customer/form');
            $addressForm->setFormCode('customer_address_edit')->setEntityType('customer_address');
            $attributes = $addressForm->getAttributes();
        } catch (Exception $e) {
            $type = Mage::getModel('eav/entity_type')->loadByCode('customer');
            $attributes = Mage::getResourceModel('eav/entity_attribute_collection')->setEntityTypeFilter($type);
        }

        foreach ($attributes as $attribute) {
            if (isset($orderShippingAddress[$attribute->getAttributeCode()])) {
                $this->quote->getShippingAddress()
                    ->setData($attribute->getAttributeCode(), $orderShippingAddress[$attribute->getAttributeCode()]);
            }

            if (isset($orderBillingAddress[$attribute->getAttributeCode()])) {
                $this->quote->getBillingAddress()
                    ->setData($attribute->getAttributeCode(), $orderBillingAddress[$attribute->getAttributeCode()]);
            }
        }

        $this->quote->getShippingAddress()
            ->setShippingMethod($order->getShippingMethod())
            ->setCollectShippingRates(true)
            ->collectShippingRates()
            ->setQuoteId($this->quote->getEntityId());

        $this->quote->getBillingAddress()
            ->setQuoteId($this->quote->getEntityId());

        $this->quote->getShippingAddress()->save();
        $this->quote->getBillingAddress()->save();
    }

    /**
     * @param $order
     */
    protected function assignStoreToQuote($order)
    {
        $storeId = $order->getStoreId();
        $store = Mage::getModel('core/store')->load($storeId);
        $this->quote->setStore($store)->setStoreId($storeId);
    }

    /**
     * @param $orderId
     * @param $items
     * @return array
     */
    public function createNewQuoteItems($orderId, $items)
    {
        $quote = $this->getQuoteForOrder($orderId);

        $itemsBefore = array();
        $itemsBeforeAddNew = $quote->getAllItems();
        foreach ($itemsBeforeAddNew as $item) {
            $itemsBefore[] = $item->getItemId();
        }

        $quote = $this->addItemsToQuote($quote, $items);
        $quote = $this->collectQuote($quote);

        $quoteItems = array();
        $itemsAfterAddNew = $quote->getAllItems();
        foreach ($itemsAfterAddNew as $item) {
            if (!in_array($item->getItemId(), $itemsBefore)) {
                $quoteItems[] = $item;
            }
        }

        return $quoteItems;
    }

    /**
     * @param Mage_Sales_Model_Quote $quote
     * @param $items
     * @return mixed
     */
    protected function addItemsToQuote($quote, $items)
    {
        foreach ($items as $productId => $item) {
            $params = new Varien_Object($item);
            $this->addProductToQuote($quote, $productId, $params);
        }

        return $quote;
    }

    /**
     * @param Mage_Sales_Model_Quote $quote
     * @return mixed
     */
    protected function collectQuote($quote)
    {
        $quote->setTotalsCollectedFlag(false)->collectTotals();
        $quote->setIsActive(0);
        $quote->save();

        return $quote;
    }

    /**
     * @param $quote
     * @return mixed
     */
    public function removeAllQuoteItems($quote)
    {
        $allQuoteItems = $quote->getAllItems();
        foreach ($allQuoteItems as $item) {
            $quote->removeItem($item->getId())->save();
        }

        return $quote;
    }

    /**
     * @param $order
     * @return Mage_Sales_Model_Quote
     */
    public function createQuote($order)
    {
        $billingAddress = $order->getBillingAddress();
        $shippingAddress = $order->getShippingAddress();

        $storeId = $order->getStoreId();
        $store = Mage::getModel('core/store')->load($order->getStoreId());
        $websiteId = $store->getWebsiteId();

        $customer = Mage::getModel('customer/customer');
        $customer->setWebsiteId($websiteId);
        $customer->loadByEmail($order->getCustomerEmail());

        $quote = Mage::getModel('sales/quote')->assignCustomer($customer);
        $quote = $quote->setStore($store)->setStoreId($storeId);

        if ($order->getCustomerId()) {
            $customer = Mage::getModel('customer/customer')->load($order->getCustomerId());
            $quote->assignCustomer($customer);
        } else {
            $quote->setIsMultiShipping(false);
            $quote->setCheckoutMethod('guest');
            $quote->setCustomerId(null);
            $quote->setCustomerEmail($order->getCustomerEmail());
            $quote->setCustomerIsGuest(true);
            $quote->setCustomerGroupId(Mage_Customer_Model_Group::NOT_LOGGED_IN_ID);
        }

        try {
            $addressForm = Mage::getModel('customer/form');
            $addressForm->setFormCode('customer_address_edit')->setEntityType('customer_address');
            $attributes = $addressForm->getAttributes();
        } catch (Exception $e) {
            $type = Mage::getModel('eav/entity_type')->loadByCode('customer_address');
            $attributes = Mage::getResourceModel('eav/entity_attribute_collection')->setEntityTypeFilter($type);
        }

        foreach ($attributes as $attribute) {
            if (isset($shippingAddress[$attribute->getAttributeCode()])) {
                $quote->getShippingAddress()
                    ->setData($attribute->getAttributeCode(), $shippingAddress[$attribute->getAttributeCode()]);
            }

            if (isset($billingAddress[$attribute->getAttributeCode()])) {
                $quote->getBillingAddress()
                    ->setData($attribute->getAttributeCode(), $billingAddress[$attribute->getAttributeCode()]);
            }
        }

        $quote->getShippingAddress()
            ->setShippingMethod($order->getShippingMethod())
            ->setCollectShippingRates(true)
            ->collectShippingRates();

        return $quote;
    }

    /**
     * @param Mage_Sales_Model_Quote $quote
     * @param $productId
     * @param $params
     * @return null
     */
    public function addProductToQuote($quote, $productId, $params)
    {
        $product = Mage::getModel('catalog/product')
            ->setStoreId($quote->getStoreId())
            ->load($productId);
        if ($product->getId()) {
            $product->setSkipCheckRequiredOption(true);
        }

        try {
            return $quote->addProduct($product, $params);
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log($e->getMessage());
            return null;
        }
    }

    /**
     * @param $orderItemId
     * @param $options
     * @return null
     */
    public function createNewOrderItem($orderItemId, $options)
    {
        if (!isset($options['item'][$orderItemId])) {
            return null;
        }

        $options = $options['item'][$orderItemId];

        $orderItem = Mage::getModel('sales/order_item')->load($orderItemId);
        $options['product'] = $orderItem->getProductId();

        $processingParams = new Varien_Object();
        $processingParams->setData('files_prefix', 'item_' . $orderItemId . '_');
        $options['_processing_params'] = $processingParams;

        $this->_processFiles($options, $orderItemId);

        $quoteItemId = $orderItem->getQuoteItemId();
        $quoteItem = Mage::getModel('sales/quote_item')->load($quoteItemId);
        $store = Mage::app()->getStore($quoteItem->getStoreId());
        $quoteId = $quoteItem->getData('quote_id');
        $quote = Mage::getModel('sales/quote')->setStore($store)->load($quoteId);
        $quoteItem->setQuote($quote);

        $quoteItem = $quote->updateItem($quoteItemId, $options);

        $quoteItem->save();
        $quote->collectTotals();

        $orderItem->setQuoteItemId($quoteItem->getId())->save();

        return Mage::getModel('sales/convert_quote')->itemToOrderItem($quoteItem);
    }

    /**
     * @param $options
     * @param $id
     * @return mixed
     */
    protected function _processFiles($options, $id)
    {
        $buyRequest = new Varien_Object($options);
        $params = array('files_prefix' => 'item_' . $id . '_');
        $buyRequest = Mage::helper('catalog/product')->addParamsToBuyRequest($buyRequest, $params);

        if ($buyRequest->hasData()) {
            $product = Mage::getModel('catalog/product')->load($options['product']);
            $product->getTypeInstance(true)->processFileQueue();
            return $buyRequest->getData();
        }

        return $options;
    }

    /**
     * @param $orderId
     * @return false|Mage_Core_Model_Abstract|Mage_Sales_Model_Quote|null
     * @throws Exception
     */
    public function getQuoteForOrder($orderId)
    {
        $order = $this->getOrder($orderId);

        $quote = $this->loadQuote($order);
        if (!empty($quote)) {
            return $quote;
        }

        $quote = $this->convertOrderToQuote($orderId);
        if (!empty($quote)) {
            $quote->setBaseSubtotal($order->getBaseSubtotal());
            return $quote;
        }

        $quote = $this->createQuote($order);
        $items = $order->getAllItems();
        foreach ($items as $item) {
            $params = new Varien_Object(unserialize($item->getProductOptions()));
            $productId = $item->getProductId();
            $this->addProductToQuote($quote, $productId, $params);
        }

        $quote = $this->collectQuote($quote);
        return $quote;
    }

    /**
     * @param $order Mage_Sales_Model_Order
     * @return Mage_Sales_Model_Quote|null
     */
    protected function loadQuote($order)
    {
        /**
         * @var Mage_Sales_Model_Quote $quote
         */
        $quote = Mage::getModel('sales/quote')
            ->setStore($order->getStore())
            ->load($order->getQuoteId());

        if (!empty($quote)) {
            $entityId = $quote->getEntityId();
            if (!empty($entityId)) {
                return $quote;
            }
        }

        return null;
    }

    /**
     * @param $order
     */
    public function syncQuote($order)
    {
        $quoteItemsInUse = array();
        $orderedItems = $order->getAllItems();
        foreach ($orderedItems as $item) {
            $quoteItemsInUse[] = $item->getQuoteItemId();
        }

        $quote = $this->loadQuote($order);
        if ($quote) {
            $quoteItems = $quote->getAllItems();
            foreach ($quoteItems as $item) {
                $quoteItemId = $item->getItemId();
                if (!in_array($quoteItemId, $quoteItemsInUse)) {
                    $item->delete();
                }
            }
        }
    }
}
