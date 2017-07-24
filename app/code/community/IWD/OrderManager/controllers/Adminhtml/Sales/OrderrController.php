<?php

/**
 * Class IWD_OrderManager_Adminhtml_Sales_OrderrController
 */
class IWD_OrderManager_Adminhtml_Sales_OrderrController extends IWD_OrderManager_Controller_Abstract
{
    /**
     * edit: edit form
     */
    public function editOrderedItemsFormAction()
    {
        $result = array('status' => 1);

        try {
            $orderId = $this->getOrderId();
            $order = $this->getOrder();
            $orderedItems = $order->getItemsCollection();

            Mage::getModel('iwd_ordermanager/order_converter')->syncQuote($order);

            $result['form'] = $this->getLayout()
                ->createBlock('iwd_ordermanager/adminhtml_sales_order_items_form')
                ->setTemplate('iwd/ordermanager/items/form.phtml')
                ->setData('ordered', $orderedItems)
                ->setData('order_id', $orderId)
                ->toHtml();
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log($e->getMessage());
            $result = array('status' => 0, 'error' => $e->getMessage());
        }

        $this->prepareResponse($result);
    }

    /**
     * edit: edit ordered items
     */
    public function editOrderedItemsAction()
    {
        $result = array('status' => 1);

        Mage::dispatchEvent(
            'iwd_ordermanager_update_order_before',
            array('order_id' => $this->getRequest()->getParam('order_id', 0))
        );

        try {
            $params = $this->getRequest()->getParams();

            /**
             * @var $orderItems IWD_OrderManager_Model_Order_Items
             */
            $orderItems = Mage::getModel('iwd_ordermanager/order_items');
            $orderItems->updateOrderItems($params);

            $needUpdateStock = $orderItems->getNeedUpdateStock();
            $result['form'] = $this->logicAfterEditOrderItems($needUpdateStock);
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log($e->getMessage());
            $result = array('status' => 0, 'error' => $e->getMessage());
        }

        Mage::dispatchEvent(
            'iwd_ordermanager_update_order_after',
            array('order_id' => $this->getRequest()->getParam('order_id', 0))
        );

        $this->prepareResponse($result);
    }

    /**
     * @param $needUpdateStock
     * @return bool
     */
    protected function logicAfterEditOrderItems($needUpdateStock)
    {
        if ($needUpdateStock) {
            $orderId = $this->getRequest()->getPost('order_id');

            return $this->getLayout()
                ->createBlock('iwd_ordermanager/adminhtml_cataloginventory_order_stock')
                ->setData('order_id', $orderId)
                ->setIsOrderView(1)
                ->setReloadPage(true)
                ->toHtml();
        } else {
            return false;
        }
    }

    /**
     * add: search items form
     */
    public function addOrderedItemsFormAction()
    {
        try {
            $orderId = $this->getRequest()->getPost('order_id');
            $order = Mage::getModel('sales/order')->load($orderId);
            $this->_setQuoteSession($orderId);

            $result['form'] = $this->getLayout()
                    ->createBlock('adminhtml/sales_order_create_search_grid')
                    ->setData('order', $order)
                    ->toHtml() . '<div id="order-billing_method"></div><div id="order-shipping_method"></div>';

            $result['configure_form'] = $this->getLayout()
                ->createBlock('adminhtml/catalog_product_composite_configure')
                ->toHtml();

            $result['url_configure_js'] = Mage::helper('core/js')
                ->getJsUrl('mage/adminhtml/product/composite/configure.js');

            $result['status'] = 1;
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log($e->getMessage());
            $result = array('status' => 0, 'error' => $e->getMessage());
        }

        $this->prepareResponse($result);
    }

    /**
     * add: add new items
     */
    public function addOrderedItemsAction()
    {
        try {
            $options = $this->getRequest()->getParam('options');
            $options = Mage::helper('core')->jsonDecode($options);
            $items = $this->getRequest()->getParam('items');
            $items = Mage::helper('core')->jsonDecode($items);
            $orderId = $this->getRequest()->getParam('order_id');
            $selectedItems = $this->_parseProductsConfig($items, $options);

            $quoteItems = Mage::getModel('iwd_ordermanager/order_converter')
                ->createNewQuoteItems($orderId, $selectedItems);
            $result['form'] = $this->getLayout()
                ->createBlock('iwd_ordermanager/adminhtml_sales_order_items_form')
                ->setTemplate('iwd/ordermanager/items/new_items.phtml')
                ->setData('items', $quoteItems)
                ->setData('order_id', $orderId)
                ->toHtml();

            $result['status'] = 1;
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log($e->getMessage());
            $result = array('status' => 0, 'error_message' => $e->getMessage());
        }

        $this->prepareResponse($result);
    }

    /**
     * edit order items options
     */
    public function editOrderedItemsOptionsAction()
    {
        try {
            $params = $this->getRequest()->getParams();
            $itemId = $this->getRequest()->getParam('item_id');

            $orderItem = Mage::getModel('iwd_ordermanager/order_converter')->createNewOrderItem($itemId, $params);
            $optionsHtml = $this->getLayout()
                ->createBlock('iwd_ordermanager/adminhtml_sales_order_items_form')
                ->setTemplate('iwd/ordermanager/items/options.phtml')
                ->setData('new_order_item', $orderItem)
                ->toHtml();

            $result = array(
                'price' => $orderItem->getData('base_price'),
                'name' => $orderItem->getData('name'),
                'sku' => $orderItem->getData('sku'),
                'product_options' => $orderItem->getData('product_options'),
                'options_html' => $optionsHtml
            );

            $result['status'] = 1;
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log($e->getMessage());
            $result = array('status' => 0, 'error_message' => $e->getMessage());
        }

        $this->getResponse()->setHeader('Content-type', 'application/json', true);
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    /**
     * add: Loading page block (for pagination in search form)
     */
    public function loadBlockAction()
    {
        $request = $this->getRequest();

        $asJson = $request->getParam('json');
        $block = $request->getParam('block');

        $update = $this->getLayout()->getUpdate();
        if ($asJson) {
            $update->addHandle('adminhtml_sales_order_create_load_block_json');
        } else {
            $update->addHandle('adminhtml_sales_order_create_load_block_plain');
        }

        if ($block) {
            $blocks = explode(',', $block);
            if ($asJson && !in_array('message', $blocks)) {
                $blocks[] = 'message';
            }

            foreach ($blocks as $block) {
                $update->addHandle('adminhtml_sales_order_create_load_block_' . $block);
            }
        }

        $this->loadLayoutUpdates()->generateLayoutXml()->generateLayoutBlocks();
        $result = $this->getLayout()->getBlock('content')->toHtml();
        if ($request->getParam('as_js_varname')) {
            Mage::getSingleton('adminhtml/session')->setUpdateResult($result);
            $this->_redirect('*/*/showUpdateResult');
        } else {
            $this->getResponse()->setBody($result);
        }
    }

    /**
     * @return $this
     */
    public function configureProductAction()
    {
        $result = array('status' => 1);

        $configureResult = new Varien_Object();
        try {
            $orderItemId = (int)$this->getRequest()->getParam('id');
            if (!$orderItemId) {
                Mage::throwException($this->__('Order item id is not received.'));
            }

            $orderItem = Mage::getModel('sales/order_item')->load($orderItemId);
            if (!$orderItem->getId()) {
                Mage::throwException($this->__('Order item is not loaded.'));
            }

            $order = Mage::getModel('sales/order')->load($orderItem->getOrderId());

            $buyRequest = $orderItem->getBuyRequest();

            $configureResult->setBuyRequest($buyRequest);
            $configureResult->setCurrentStoreId($orderItem->getStoreId());
            $configureResult->setProductId($orderItem->getProductId());
            $configureResult->setCurrentCustomerId($order->getCustomerId());
            $configureResult->setOk(true);
        } catch (Exception $e) {
            $result['status'] = 0;
            $result['error'] = $e->getMessage();
            $configureResult->setError(true);
            $configureResult->setMessage($e->getMessage());
        }

        // Render page
        /** @var $helper IWD_OrderManager_Helper_Composite */
        $helper = Mage::helper('iwd_ordermanager/composite');
        Mage::helper('catalog/product')->setSkipSaleableCheck(true);
        $helper->renderConfigureResult($this, $configureResult);
        return $this;
    }

    /**
     * @param $options
     * @param $productId
     * @param $type
     * @return array
     */
    private function _parseProductConfig($options, $productId, $type)
    {
        $optionsArray = array();
        if (isset($options[$productId])) {
            foreach ($options[$productId] as $option) {
                $result = preg_match("/$type\[(\d*)\].*/", $option["name"], $found);
                if ($result == 1 && isset($found[1])) {
                    $i = $found[1];
                    if (!isset($optionsArray[$i])) {
                        $optionsArray[$i] = $option["value"];
                    } else {
                        if (is_array($optionsArray[$i])) {
                            $optionsArray[$i][] = $option["value"];
                        } else {
                            $optionsArray[$i] = array($optionsArray[$i], $option["value"]);
                        }
                    }
                }
            }
        }

        return $optionsArray;
    }

    /**
     * @param $items
     * @param $options
     * @return array
     */
    private function _parseProductsConfig($items, $options)
    {
        $selectedItems = array();

        $allowedOptions = array(
            'bundle_option',
            'bundle_option_qty',
            'super_group',
            'super_attribute',
            'links',
            'options'
        );
        $giftcardOptions = array(
            'giftcard_amount',
            'giftcard_sender_name',
            'giftcard_sender_email',
            'giftcard_recipient_name',
            'giftcard_recipient_email',
            'giftcard_message'
        );
        foreach ($items as $id => $val) {
            $optionsArray = array(
                'qty' => $val['qty'],
                'product' => $id,
            );

            foreach ($allowedOptions as $allowedOption) {
                $opt = $this->_parseProductConfig($options, $id, $allowedOption);
                if (!empty($opt)) {
                    $optionsArray[$allowedOption] = $opt;
                }
            }

            if (isset($options[$id])) {
                $optionsItem = $options[$id];
                foreach ($optionsItem as $optionItem) {
                    if (isset($optionItem['name']) && isset($optionItem['value']) && !empty($optionItem['name'])) {
                        $name = $optionItem['name'];
                        if (in_array($name, $giftcardOptions)) {
                            $optionsArray[$name] = $optionItem['value'];
                        }
                    }
                }
            }

            $selectedItems[$id] = $optionsArray;
        }

        return $selectedItems;
    }

    /**
     * @param $orderId
     */
    public function _setQuoteSession($orderId)
    {
        $order = Mage::getModel('sales/order')->load($orderId);

        $quoteSession = Mage::getSingleton('adminhtml/session_quote');
        if (!$order->getReordered()) {
            $quoteSession->setOrderId($order->getId());
        } else {
            $quoteSession->setReordered($order->getId());
        }

        $quoteSession->setCurrencyId($order->getOrderCurrencyCode());
        if ($order->getCustomerId()) {
            $quoteSession->setCustomerId($order->getCustomerId());
        } else {
            $quoteSession->setCustomerId(false);
        }

        $quoteSession->setStoreId($order->getStoreId());
    }

    /**
     * @return $this|Mage_Core_Controller_Varien_Action
     */
    public function pdfordersAction()
    {
        $orderIds = $this->getRequest()->getPost('order_ids');
        if (!empty($orderIds)) {
            foreach ($orderIds as $orderId) {
                $order = Mage::getModel('sales/order')->load($orderId);
                $order->setOrder($order);
                if (!isset($pdf)) {
                    $pdf = Mage::getModel('iwd_ordermanager/order_pdf_order')->getPdf(array($order));
                } else {
                    $pages = Mage::getModel('iwd_ordermanager/order_pdf_order')->getPdf(array($order));
                    $pdf->pages = array_merge($pdf->pages, $pages->pages);
                }
            }

            return $this->_prepareDownloadResponse(
                'order' . Mage::getSingleton('core/date')->date('Y-m-d_H-i-s') . '.pdf',
                $pdf->render(),
                'application/pdf'
            );
        }

        return $this->_redirect('*/*/');
    }


    /**
     * @return $this|Mage_Core_Controller_Varien_Action
     */
    public function printAction()
    {
        $order = $this->_initOrder();
        if (!empty($order)) {
            $order->setOrder($order);
            $pdf = Mage::getModel('iwd_ordermanager/order_pdf_order')->getPdf(array($order));
            return $this->_prepareDownloadResponse(
                'order' . Mage::getSingleton('core/date')->date('Y-m-d_H-i-s') . '.pdf',
                $pdf->render(),
                'application/pdf'
            );
        }

        return $this->_redirect('*/*/');
    }

    /**
     * @return Mage_Sales_Model_Order || false
     */
    protected function _initOrder()
    {
        $id = $this->getRequest()->getParam('order_id');
        $order = Mage::getModel('sales/order')->load($id);

        if (!$order->getId()) {
            $this->_getSession()->addError($this->__('This order no longer exists.'));
            $this->_redirect('*/*/');
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
            return false;
        }

        Mage::register('sales_order', $order);
        Mage::register('current_order', $order);

        return $order;
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return true;
    }
}
