<?php

class IWD_OrderManager_Model_Order_Edit extends Mage_Sales_Model_Order_Item
{
    const XML_PATH_SALES_STATUS_ORDER = 'iwd_ordermanager/edit/order_status';
    const XML_PATH_RETURN_TO_STOCK = 'iwd_ordermanager/edit/return_to_stock';
    const XML_PATH_RECALCULATE_SHIPPING = 'iwd_ordermanager/edit/recalculate_shipping';

    private $addedItems = false;
    private $appliedTaxes = array();
    private $editItems = array();

    protected $baseCurrencyCode = "USD";
    protected $orderCurrencyCode = "USD";
    protected $delta = 0.06;
    protected $removeInvoice = false;
    protected $needUpdateStock = false;

    /**
     * @return IWD_OrderManager_Model_Logger
     */
    public function getLogger()
    {
        return Mage::getSingleton('iwd_ordermanager/logger');
    }

    public function getOrderStatusesForUpdateIds()
    {
        return explode(',', Mage::getStoreConfig(self::XML_PATH_SALES_STATUS_ORDER));
    }

    public function getAllowReturnToStock()
    {
        return Mage::getStoreConfig(self::XML_PATH_RETURN_TO_STOCK);
    }

    public function isRecalculateShipping()
    {
        return Mage::getStoreConfig(self::XML_PATH_RECALCULATE_SHIPPING);
    }

    public function getNeedUpdateStock()
    {
        return $this->needUpdateStock && Mage::helper('iwd_ordermanager')->isMultiInventoryEnable();
    }

    public function editItems($orderId, $items)
    {
        /* event */
        $order = $this->loadOrder($orderId);
        $oldOrder = clone $order;
        Mage::dispatchEvent('iwd_ordermanager_sales_order_edit_before', array('order' => $order, 'order_items' => $order->getItemsCollection()));

        /* check status */
        if (!$this->checkOrderStatusForUpdate($order)) {
            Mage::getSingleton('adminhtml/session')->addError("Sorry... You can't edit order with current status. Check configuration: IWD >> Order Manager >> Edit Order");
            return 0;
        }

        $this->updateOrderItems($items, $orderId);

        $this->collectOrderTotals($orderId);

        $order = $this->loadOrder($orderId);
        if ($this->isRecalculateShipping() && $order->canShip()) {
            Mage::getModel('iwd_ordermanager/shipping')->recollectShippingAmount($orderId);
        }

        $this->collectOrderTotals($orderId);

        $this->updateOrderPayment($orderId, $oldOrder);

        /* event */
        $order = $this->loadOrder($orderId);
        Mage::dispatchEvent('iwd_ordermanager_sales_order_edit_after', array('order' => $order, 'order_items' => $order->getItemsCollection()));

        return 1;
    }

    public function execEditOrderItems($orderId, $params)
    {
        $notify = isset($params['notify']) ? $params['notify'] : null;
        $edited = $this->editItems($orderId, $params['items']);
        $result = true;

        if ($edited && $notify) {
            $message = isset($params['comment_text']) ? $params['comment_text'] : null;
            $email = isset($params['comment_email']) ? $params['comment_email'] : null;
            $result = array('notify' => Mage::getModel('iwd_ordermanager/notify_notification')->sendNotifyEmail($orderId, $email, $message));
        }

        return $result;
    }

    public function checkOrderStatusForUpdate($order)
    {
        $orderStatus = $order->getStatus();
        $allowOrderStatuses = $this->getOrderStatusesForUpdateIds();
        $waitOrderStatus = Mage::getStoreConfig(IWD_OrderManager_Model_Logger::CONFIG_XML_PATH_CONFIRM_STATUS_WAIT, Mage::app()->getStore());

        return in_array($orderStatus, $allowOrderStatuses) || ($waitOrderStatus == $orderStatus);
    }

    public function updateOrderPayment($orderId, $oldOrder)
    {
        $backupId = $this->loadOrder($orderId)->getIwdBackupId();
        if (empty($backupId)) {
            return $this->reauthorizeOrderPayment($orderId, $oldOrder);
        }

        Mage::getSingleton('adminhtml/session')->addNotice(
            Mage::helper('iwd_ordermanager')->__(
                'Payment did not re-authorized automatically. You can manually select when to re-authorize payment.'
            )
        );

        return 0;
    }

    public function reauthorizeOrderPayment($orderId, $oldOrder)
    {
        try {
            /** @var $newOrder Mage_Sales_Model_Order */
            /** @var $oldOrder Mage_Sales_Model_Order */
            $newOrder = $this->loadOrder($orderId);

            $oldTotal = $oldOrder->getGrandTotal() - $oldOrder->getTotalRefunded();
            $newTotal = $newOrder->getGrandTotal() - $newOrder->getTotalRefunded();

            if ($oldTotal != $newTotal) {
                $this->updateCreditMemos($orderId);
                $this->updateInvoice($orderId);
                $this->reauthorizePayment($orderId, $oldOrder);
            }
        } catch (Exception $e) {
            return -1;
        }

        return 1;
    }

    public function updateCreditMemos($orderId)
    {
        try {
            /** @var $order Mage_Sales_Model_Order */
            $order = $this->loadOrder($orderId);
            if ($order->hasCreditmemos()) {
                $creditMemos = $order->getCreditmemosCollection();
                foreach ($creditMemos as $creditMemo) {
                    /** @var $creditmemo IWD_OrderManager_Model_Creditmemo */
                    $creditmemo = Mage::getModel('iwd_ordermanager/creditmemo')->load($creditMemo->getEntityId());
                    $creditmemo->deleteCreditmemoWithoutCheck();
                }
            }
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log($e->getMessage(), true);
            return false;
        }

        return true;
    }

    public function updateInvoice($orderId)
    {
        try {
            /** @var $order Mage_Sales_Model_Order */
            $order = $this->loadOrder($orderId);
            if ($order->getTotalPaid() > 0 || $this->removeInvoice) {
                /** @var $invoice IWD_OrderManager_Model_Invoice */
                $invoice = Mage::getModel('iwd_ordermanager/invoice');
                $invoice->updateInvoice($order);
            }
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log($e->getMessage(), true);
            return false;
        }

        return true;
    }

    protected function reauthorizePayment($orderId, $oldOrder)
    {
        /** @var $payment IWD_OrderManager_Model_Payment_Payment */
        $payment = Mage::getModel('iwd_ordermanager/payment_payment');

        if ($payment->reauthorizePayment($orderId, $oldOrder) === -1) {
            $order = $this->loadOrder($orderId);
            Mage::dispatchEvent(
                'iwd_ordermanager_sales_order_reauthorize_payment_fail',
                array('order' => $order, 'payment' => $payment)
            );
            throw new Exception('IWD Order Manager re-authorization failed');
        }
    }

    protected function checkItemData($item)
    {
        $keys = array('price', 'price_incl_tax', 'qty',
            'subtotal', 'subtotal_incl_tax',
            'tax_amount', 'tax_percent',
            'discount_amount', 'discount_percent', 'row_total'
        );

        foreach ($keys as $key) {
            if (isset($item[$key]) && !is_numeric($item[$key])) {
                return false;
            }
        }

        return true;
    }

    protected function updateQty($orderItem, $newQty)
    {
        if ($orderItem->getProductType() == Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE) {
            $collection = Mage::getModel('sales/order_item')->getCollection()
                ->addFieldToFilter('parent_item_id', $orderItem->getItemId());
            if ($collection->getSize() > 0) {
                $simpleOrderItem = $collection->getFirstItem();
                $this->updateQtyProduct($simpleOrderItem, $newQty);
            }
        }

        $this->updateQtyProduct($orderItem, $newQty);
    }

    protected function updateQtyProduct($orderItem, $newQty)
    {
        /**
         *  $newQty is a NOT fact qty for customer NOW !!!
         *  it is the order item ORDERED QTY !!!
         */

        if ($orderItem->getQtyOrdered() > $newQty) {
            // '-' qty
            $this->reduceProduct($orderItem, $newQty);
        } else {
            // '+' qty
            $this->increaseProduct($orderItem, $newQty);
        }

        $orderItem->setQtyOrdered($newQty);
        $orderItem->setRowWeight($orderItem->getWeight() * $newQty - $orderItem->getQtyRefunded());
        $orderItem->save();

        return $newQty;
    }

    protected function reduceProduct($orderItem, $newQty)
    {
        $refund = $orderItem->getQtyOrdered() - $newQty - $orderItem->getQtyRefunded();

        if ($refund > 0 && $this->getAllowReturnToStock()) {
            if ($newQty == 0) {
                Mage::getModel('iwd_ordermanager/cataloginventory_stock_order_item')
                    ->updateStockAfterRemoveItem($orderItem);
            } else {
                $needUpdateStock = Mage::getModel('iwd_ordermanager/cataloginventory_stock_order_item')
                    ->updateStockOrderItemIfOneStockAssignedOnly($orderItem, -1 * $refund);
                $this->needUpdateStock = ($this->needUpdateStock == true) ? true : $needUpdateStock;
            }

            Mage::getSingleton('cataloginventory/stock')->backItemQty($orderItem->getProductId(), $refund);
        }
    }

    protected function increaseProduct($orderItem, $newQty)
    {
        $productId = $orderItem->getProductId();

        if ($productId) {
            $stockItem = Mage::getModel('cataloginventory/stock_item')->loadByProduct($productId);

            if (Mage::helper('cataloginventory')->isQty($stockItem->getTypeId())) {
                if ($orderItem->getStoreId()) {
                    $stockItem->setStoreId($orderItem->getStoreId());
                }

                $qty = $newQty - ($orderItem->getQtyOrdered());
                $qty = $qty < 0 ? 0 : $qty;

                if ($stockItem->checkQty($qty)) {
                    $stockItem->subtractQty($qty)->save();

                    $needUpdateStock = Mage::getModel('iwd_ordermanager/cataloginventory_stock_order_item')
                        ->updateStockOrderItemIfOneStockAssignedOnly($orderItem, $qty);

                    $this->needUpdateStock = ($this->needUpdateStock == true) ? true : $needUpdateStock;
                }
            }
        } else {
            Mage::throwException(
                Mage::helper('iwd_ordermanager')->__('Cannot specify product identifier for the order item.')
            );
        }

        $this->addedItems = true;
    }


    protected function currencyConvert($price)
    {
        if ($this->baseCurrencyCode === $this->orderCurrencyCode) {
            return $price;
        }

        return Mage::helper('directory')->currencyConvert($price, $this->baseCurrencyCode, $this->orderCurrencyCode);
    }

    protected function updateOrderItems($items, $orderId)
    {
        $order = $this->loadOrder($orderId);

        $this->deleteOrderShippingTax($order);

        $this->baseCurrencyCode = $order->getBaseCurrencyCode();
        $this->orderCurrencyCode = $order->getOrderCurrencyCode();
        $this->editItems = array();
        $this->addedItems = false;

        foreach ($items as $id => $item) {
            $orderItem = $order->getItemById($id);

            // remove item
            if (isset($item['remove']) && $item['remove'] == 1) {
                $this->removeOrderItem($orderItem);
                continue;
            }

            // add new item
            if (isset($item['quote_item'])) {
                $orderItem = $this->addNewOrderItem($item['quote_item'], $order);
            }

            // edit item
            $this->editOrderItem($orderItem, $item);
        }
    }

    /**
     * @param Mage_Sales_Model_Order_Item $orderItem
     * @param $item
     */
    protected function editOrderItem($orderItem, $item)
    {
        $logger = $this->getLogger();

        // old order item values
        $old_row_total = $orderItem->getRowTotal();
        $old_base_row_total = $orderItem->getBaseRowTotal();
        $old_tax_amount = $orderItem->getTaxAmount();
        $old_tax_percent = $orderItem->getTaxPercent();
        $old_base_tax_amount = $orderItem->getBaseTaxAmount();
        $old_hidden_tax_amount = $orderItem->getHiddenTaxAmount();
        $old_base_hidden_tax_amount = $orderItem->getBaseHiddenTaxAmount();
        $old_discount_amount = $orderItem->getDiscountAmount();
        $old_base_discount_amount = $orderItem->getBaseDiscountAmount();

        if (isset($item['attribute_value'])) {
            foreach ($item['attribute_value'] as $key => $val) {
                $options = $this->updateItemAttribute($orderItem, $key, $val, 'value');
                $orderItem->setProductOptions($options);
            }
        }

        if (isset($item['attribute_label'])) {
            foreach ($item['attribute_label'] as $key => $val) {
                $options = $this->updateItemAttribute($orderItem, $key, $val, 'label');
                $orderItem->setProductOptions($options);
            }
        }

        if (isset($item['option_value'])) {
            foreach ($item['option_value'] as $key => $val) {
                $options = $this->updateItemOptions($orderItem, $key, $val, 'value');
                $orderItem->setProductOptions($options);
            }
        }

        if (isset($item['option_label'])) {
            foreach ($item['option_label'] as $key => $val) {
                $options = $this->updateItemOptions($orderItem, $key, $val, 'label');
                $orderItem->setProductOptions($options);
            }
        }

        if (isset($item['bundle_option_label'])) {
            $options = $orderItem->getProductOptions();
            $bundleSelectionAttributes = $options['bundle_selection_attributes'];
            $bundleSelectionAttributes = is_array($bundleSelectionAttributes) ? $bundleSelectionAttributes : unserialize($bundleSelectionAttributes);
            if (isset($bundleSelectionAttributes['option_label'])) {
                $this->getLogger()->addOrderItemEdit($orderItem, 'Bundle Option Label', $bundleSelectionAttributes['option_label'], $item['bundle_option_label']);
                $bundleSelectionAttributes['option_label'] = $item['bundle_option_label'];
                $bundleSelectionAttributes = serialize($bundleSelectionAttributes);
                $options['bundle_selection_attributes'] = $bundleSelectionAttributes;
                $orderItem->setProductOptions($options);
            }
        }

        // product_name
        if (isset($item['product_name'])) {
            $logger->addOrderItemEdit($orderItem, 'Product Name', $orderItem->getName(), $item['product_name']);
            $orderItem->setName($item['product_name']);
        }

        // description
        if (isset($item['description'])) {
            $logger->addOrderItemEdit($orderItem, 'Description', $orderItem->getDescription(), $item['description']);
            $orderItem->setDescription($item['description']);
        }

        if (!$this->checkItemData($item)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('iwd_ordermanager')->__("Enter the correct data for product with sku [{$orderItem->getSku()}]")
            );
            return;
        }

        // qty ordered
        $old_qty_ordered = $orderItem->getQtyOrdered() - $orderItem->getQtyRefunded();
        $fact_qty = isset($item['fact_qty']) ? $item['fact_qty'] : $old_qty_ordered;

        $this->updateQty($orderItem, $fact_qty);
        $logger->addOrderItemEdit($orderItem, 'Qty', number_format($old_qty_ordered, 2), number_format($fact_qty, 2));

        $this->updateAmounts($orderItem, $item);

        // product options
        $this->updateProductOptions($orderItem, $item);

        // support_date
        $this->updateSupportDate($orderItem, $item);

        $orderItem->save();
        $this->updateOrderTaxItemTable($orderItem, $old_tax_amount, $old_base_tax_amount, $old_tax_percent);

        $new_row_total = $this->getOrderItemRowTotal($orderItem);

        if (abs($old_row_total - $new_row_total) >= $this->delta) {
            $this->editItems[$orderItem->getId()] = array(
                'row_total' => $old_row_total - $orderItem->getRowTotal(),
                'base_row_total' => $old_base_row_total - $orderItem->getBaseRowTotal(),
                'tax_refunded' => $old_tax_amount - $orderItem->getTaxAmount(),
                'base_tax_amount' => $old_base_tax_amount - $orderItem->getBaseTaxAmount(),
                'hidden_tax_amount' => $old_hidden_tax_amount - $orderItem->getHiddenTaxAmount(),
                'base_hidden_tax_amount' => $old_base_hidden_tax_amount - $orderItem->getBaseHiddenTaxAmount(),
                'discount_amount' => $old_discount_amount - $orderItem->getDiscountAmount(),
                'base_discount_amount' => $old_base_discount_amount - $orderItem->getBaseDiscountAmount()
            );
        }

        Mage::dispatchEvent('iwd_sales_order_item_updated', array('order_item' => $orderItem));
    }

    protected function updateItemAttribute($orderItem, $key, $val, $attributeKey)
    {
        $options = $orderItem->getProductOptions();
        $options = is_string($options) ? unserialize($options) : $options;
        if (isset($options['attributes_info'])) {
            foreach ($options['attributes_info'] as $id => $attribute) {
                if ($attribute['label'] == $key) {
                    $this->getLogger()->addOrderItemEdit($orderItem, 'Attribute ' . $attributeKey, $options['attributes_info'][$id][$attributeKey], $val);
                    $options['attributes_info'][$id][$attributeKey] = $val;
                }
            }
        }

        return $options;
    }

    protected function updateItemOptions($orderItem, $optionId, $val, $attributeKey)
    {
        $options = $orderItem->getProductOptions();
        $options = is_string($options) ? unserialize($options) : $options;
        if (isset($options['options'])) {
            foreach ($options['options'] as $id => $option) {
                if ($option['option_id'] == $optionId) {
                    $this->getLogger()->addOrderItemEdit($orderItem, 'Option ' . $attributeKey, $options['options'][$id][$attributeKey], $val);
                    $options['options'][$id][$attributeKey] = $val;
                }
            }
        }

        return $options;
    }

    protected function getOrderItemRowTotal($item)
    {
        return $item->getRowTotal() + $item->getTaxAmount() + $item->getHiddenTaxAmount() + $item->getWeeeTaxAppliedRowAmount() - $item->getDiscountAmount();
    }

    protected function editDownloadItem($orderItem, $item)
    {
        $new = $item['product_options'];
        $old = $orderItem->getData('product_options');

        $old = is_string($old) ? unserialize($old) : $old;
        $new = is_string($new) ? unserialize($new) : $new;

        if ($orderItem->getProductType() == Mage_Downloadable_Model_Product_Type::TYPE_DOWNLOADABLE) {
            $oldLinks = isset($old["links"]) ? $old["links"] : array();
            $newLinks = isset($new["links"]) ? $new["links"] : array();

            $added = array_diff($newLinks, $oldLinks);
            foreach ($added as $link_id) {
                $this->addDownloadableLink($orderItem, $link_id);
            }

            $removed = array_diff($oldLinks, $newLinks);
            foreach ($removed as $link_id) {
                $this->removeDownloadableLink($orderItem->getId(), $link_id);
            }
        }
    }

    protected function addDownloadableLink($orderItem, $link_id)
    {
        $order_item_id = $orderItem->getId();
        $link_purchased_id = $this->getLinkPurchasedIdForOrderItem($order_item_id);

        $linkPurchasedItem = Mage::getModel('downloadable/link_purchased_item')
            ->setPurchasedId($link_purchased_id)
            ->setOrderItemId($order_item_id);

        Mage::helper('core')->copyFieldset(
            'downloadable_sales_copy_link',
            'to_purchased',
            $link_id,
            $linkPurchasedItem
        );

        $linkHash = strtr(base64_encode(microtime() . $link_purchased_id . $order_item_id . $orderItem->getProductId()), '+/=', '-_,');

        $link = Mage::getModel('downloadable/link')
            ->getCollection()
            ->addTitleToResult()
            ->addFieldToFilter('main_table.link_id', array('eq' => $link_id))
            ->getFirstItem();

        $numberOfDownloads = $link->getNumberOfDownloads() * $orderItem->getQtyOrdered();
        $linkPurchasedItem->setLinkHash($linkHash)
            ->setNumberOfDownloadsBought($numberOfDownloads)
            ->setStatus(Mage_Downloadable_Model_Link_Purchased_Item::LINK_STATUS_PENDING)
            ->setCreatedAt($orderItem->getCreatedAt())
            ->setUpdatedAt($orderItem->getUpdatedAt())
            ->setProductId($orderItem->getProductId())
            ->setLinkId($link->getLinkId())
            ->setIsShareable($link->getIsShareable())
            ->setLinkUrl($link->getLinkUrl())
            ->setLinkFile($link->getLinkFile())
            ->setLinkType($link->getLinkType())
            ->setLinkTitle($link->getDefaultTitle())
            ->save();
    }

    protected function getLinkPurchasedIdForOrderItem($order_item_id)
    {
        $collection = Mage::getModel('downloadable/link_purchased')->getCollection()
            ->addFieldToFilter('order_item_id', $order_item_id);

        if ($collection->getSize() > 0) {
            return $collection->getFirstItem()->getId();
        }

        return 0;
    }

    protected function removeDownloadableLink($order_item_id, $link_id)
    {
        try {
            $collection = Mage::getModel('downloadable/link_purchased_item')->getCollection()
                ->addFieldToFilter('order_item_id', $order_item_id)
                ->addFieldToFilter('link_id', $link_id);

            foreach ($collection as $link_purchased_item) {
                $link_purchased_item->delete();
            }
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log($e->getMessage());
        }
    }

    protected function updateProductOptions($orderItem, $item)
    {
        if (isset($item['product_options']) && !empty($item['product_options'])) {
            // edit download product
            $this->editDownloadItem($orderItem, $item);

            $product_options = $item['product_options'];
            $this->addToLogProductOptions($orderItem, $orderItem->getData('product_options'), $product_options);
            $orderItem->setData('product_options', $product_options);

            $old_sku = $orderItem->getSku();
            $options = unserialize($product_options);
            if (isset($options['simple_sku']) && !empty($options['simple_sku'])) {
                $orderItem->setSku($options['simple_sku']);
            }
            if (isset($options['simple_name']) && !empty($options['simple_name'])) {
                $orderItem->setName($options['simple_name']);
            }
            $new_sku = $orderItem->getSku();

            //update inventory
            if ($old_sku != $new_sku) {
                // prepare qty
                $qty = $orderItem->getQtyOrdered() - $orderItem->getQtyRefunded() - $orderItem->getQtyCanceled();
                $qty = $qty < 0 ? 0 : $qty;

                // prepare id
                $_catalog = Mage::getModel('catalog/product');
                $oldProductId = $_catalog->getIdBySku($old_sku);
                $newProductId = $_catalog->getIdBySku($new_sku);

                // update product id for simple product
                try {
                    if ($orderItem->getProductType() == 'configurable') {
                        $simpleOrderItem = Mage::getModel('sales/order_item')->getCollection()->addFieldToFilter('parent_item_id', $orderItem->getItemId());
                        if ($simpleOrderItem->getSize() > 0) {
                            $simpleOrderItem->getFirstItem()
                                ->setProductId($oldProductId)
                                ->setSku($new_sku)
                                ->setName($orderItem->getName())
                                ->setProductId($newProductId)
                                ->save();
                        }
                    } elseif ($orderItem->getProductType() == 'simple') {
                        $orderItem->setProductId($oldProductId);
                    }
                } catch (Exception $e) {
                    IWD_OrderManager_Model_Logger::log($e->getMessage());
                }

                // push to inventory
                Mage::getSingleton('cataloginventory/stock')->backItemQty($oldProductId, $qty);

                // pull from inventory
                $stockItem = Mage::getModel('cataloginventory/stock_item')->loadByProduct($newProductId);
                if (Mage::helper('cataloginventory')->isQty($stockItem->getTypeId())) {
                    if ($orderItem->getStoreId()) {
                        $stockItem->setStoreId($orderItem->getStoreId());
                    }
                    if ($stockItem->checkQty($qty)) {
                        $stockItem->subtractQty($qty)->save();
                    }
                }
            }

            $orderItem->save();
        }

        return $orderItem;
    }

    protected function addToLogProductOptions($orderItem, $old, $new)
    {
        $logger =  $this->getLogger();
        $old = unserialize($old);
        $new = unserialize($new);

        /* attributes */
        $oldAttributesArray = isset($old["attributes_info"]) ? $old["attributes_info"] : array();
        $newAttributes = isset($new["attributes_info"]) ? $new["attributes_info"] : array();
        $oldAttributes = array();
        foreach ($oldAttributesArray as $attribute) {
            if (isset($attribute["label"]) && isset($attribute["value"])) {
                $oldAttributes[$attribute["label"]] = $attribute["value"];
            }
        }
        foreach ($newAttributes as $attribute) {
            if (isset($attribute["label"]) && isset($attribute["value"])) {
                $attributeId = $attribute["label"];
                if (isset($oldAttributes[$attributeId])) {
                    $oldAttribute = $oldAttributes[$attributeId];
                } else {
                    $oldAttribute = "";
                }
                unset($oldAttributes[$attributeId]);

                $logger->addOrderItemEdit($orderItem, $attribute["label"], $oldAttribute, $attribute['value']);
            }
        }
        foreach ($oldAttributes as $attribute) {
            if (isset($attribute["label"]) && isset($attribute["value"])) {
                $logger->addOrderItemEdit($orderItem, $attribute["label"], $attribute["value"], "");
            }
        }

        /* options */
        $oldOptionsArray = isset($old["options"]) ? $old["options"] : array();
        $newOptions = isset($new["options"]) ? $new["options"] : array();
        $oldOptions = array();
        foreach ($oldOptionsArray as $option) {
            if (isset($option["option_id"])) {
                $oldOptions[$option["option_id"]] = $option;
            }
        }
        foreach ($newOptions as $option) {
            if (isset($option["option_id"]) && isset($option["label"]) && isset($option["print_value"])) {
                $optionId = $option["option_id"];
                $label = $option['label'];
                if (isset($oldOptions[$optionId])) {
                    $oldOption = $oldOptions[$optionId]['print_value'];
                } else {
                    $oldOption = "";
                }

                unset($oldOptions[$optionId]);
                $logger->addOrderItemEdit($orderItem, $label, $oldOption, $option['print_value']);
            }
        }
        foreach ($oldOptions as $option) {
            if (isset($option["option_id"]) && isset($option["label"]) && isset($option["print_value"])) {
                $logger->addOrderItemEdit($orderItem, $option["label"], $option['print_value'], "");
            }
        }

        /* links */
        $oldLinks = isset($old["links"]) ? $old["links"] : array();
        $newLinks = isset($new["links"]) ? $new["links"] : array();
        $added = array_diff($newLinks, $oldLinks);
        foreach ($added as $link) {
            $title = $this->getDownloadTitle($link, $orderItem->getId());
            $logger->addOrderItemEdit($orderItem, 'Added link', $title, null);
        }
        $removed = array_diff($oldLinks, $newLinks);
        foreach ($removed as $link) {
            $title = $this->getDownloadTitle($link, $orderItem->getId());
            $logger->addOrderItemEdit($orderItem, 'Removed link', $title, null);
        }

        /* name/sku */
        $new_name = isset($new["simple_name"]) ? $new["simple_name"] : "";
        $old_name = isset($old["simple_name"]) ? $old["simple_name"] : "";
        $new_sku = isset($new["simple_sku"]) ? " (" . $new["simple_sku"] . ")" : "";
        $old_sku = isset($old["simple_sku"]) ? " (" . $old["simple_sku"] . ")" : "";
        $logger->addOrderItemEdit($orderItem, 'Product', $new_name . $new_sku, $old_name . $old_sku);
    }

    protected function getDownloadTitle($link_id, $order_item_id)
    {
        $collection = Mage::getModel('downloadable/link_purchased_item')->getCollection()
            ->addFieldToFilter('link_id', $link_id)
            ->addFieldToFilter('order_item_id', $order_item_id);

        if ($collection->getSize() > 0) {
            return $collection->getFirstItem()->getLinkTitle();
        }

        try {
            $link = Mage::getModel('downloadable/link')
                ->getCollection()
                ->addTitleToResult()
                ->addFieldToFilter('main_table.link_id', array('eq' => $link_id));
            return $link->getFirstItem()->getTitle();
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log($e->getMessage());
        }

        return "Link ID #" . $link_id;
    }

    protected function updateSupportDate($orderItem, $item)
    {
        if (isset($item['support_date']) && Mage::getConfig()->getModuleConfig('IWD_Downloadable')->is('active', 'true')) {
            Mage::helper('iwd_ordermanager/downloadable')->updateSupportPeriod($orderItem->getId(), $item['support_date']);
        }
    }

    protected function updateAmounts($orderItem, $item)
    {
        $logger = $this->getLogger();

        // tax amount
        if (isset($item['tax_amount'])) {
            $logger->addOrderItemEdit($orderItem, 'Tax amount', number_format($orderItem->getBaseTaxAmount(), 2), number_format($item['tax_amount'], 2));
            $taxAmount = $this->currencyConvert($item['tax_amount']);
            $orderItem->setBaseTaxAmount($item['tax_amount'])->setTaxAmount($taxAmount);
        }

        // hidden tax amount
        if (isset($item['hidden_tax_amount'])) {
            $hiddenTaxAmount = $this->currencyConvert($item['hidden_tax_amount']);
            $orderItem->setBaseHiddenTaxAmount($item['hidden_tax_amount'])->setHiddenTaxAmount($hiddenTaxAmount);
        }

        // tax percent
        if (isset($item['tax_percent'])) {
            $logger->addOrderItemEdit($orderItem, 'Tax percent', number_format($orderItem->getTaxPercent(), 2), number_format($item['tax_percent'], 2));
            $orderItem->setTaxPercent($item['tax_percent']);
        }

        // price
        if (isset($item['price'])) {
            $logger->addOrderItemEdit($orderItem, 'Price (excl. tax)', number_format($orderItem->getBasePrice(), 2), number_format($item['price'], 2));
            $price = $this->currencyConvert($item['price']);
            $orderItem->setBasePrice($item['price'])->setPrice($price);
        }

        // price include tax
        if (isset($item['price_incl_tax'])) {
            $price_incl_tax = $this->currencyConvert($item['price_incl_tax']);
            $orderItem->setBasePriceInclTax($item['price_incl_tax'])->setPriceInclTax($price_incl_tax);
        }

        // discount amount
        if (isset($item['discount_amount'])) {
            $logger->addOrderItemEdit($orderItem, 'Discount amount', number_format($orderItem->getBaseDiscountAmount(), 2), number_format($item['discount_amount'], 2));
            $discountAmount = $this->currencyConvert($item['discount_amount']);
            $orderItem->setBaseDiscountAmount($item['discount_amount'])->setDiscountAmount($discountAmount);
        }

        // discount percent
        if (isset($item['discount_percent'])) {
            $logger->addOrderItemEdit($orderItem, 'Discount percent', number_format($orderItem->getDiscountPercent(), 2), number_format($item['discount_percent'], 2));
            $orderItem->setDiscountPercent($item['discount_percent']);
        }

        // subtotal (row total)
        if (isset($item['subtotal'])) {
            $subtotal = $this->currencyConvert($item['subtotal']);
            $orderItem->setBaseRowTotal($item['subtotal'])->setRowTotal($subtotal);
        }

        // subtotal include tax
        if (isset($item['subtotal_incl_tax'])) {
            $subtotalInclTax = $this->currencyConvert($item['subtotal_incl_tax']);
            $orderItem->setBaseRowTotalInclTax($item['subtotal_incl_tax'])->setRowTotalInclTax($subtotalInclTax);
        }

        $orderItem->save();

        return $orderItem;
    }

    protected function addNewOrderItem($quote_item_id, $order)
    {
        $quote_item = Mage::getModel('sales/quote_item')->load($quote_item_id);
        if (!$quote_item->getId()) {
            return null;
        }

        $this->needUpdateStock = true;

        $quote = Mage::getModel('sales/quote')->loadByIdWithoutStore($quote_item->getQuoteId());
        $quote_item->setQuote($quote);

        $orderItem = $this->addItemToOrder($order, $quote_item);
        $orderItem->save();

        $this->addChildrenItems($quote_item_id, $quote, $orderItem, $order);

        $this->getLogger()->addOrderItemAdd($orderItem);

        return $orderItem;
    }

    public function addItemToOrder($order, $quote_item)
    {
        try {
            $optionCollection = Mage::getModel('sales/quote_item_option')->getCollection()
                ->addItemFilter(array($quote_item->getId()));
            $quote_item->setOptions($optionCollection->getOptionsByItem($quote_item));

            if ($simpleOption = $quote_item->getProduct()->getCustomOption('simple_product')) {
                $simple_product = Mage::getModel('catalog/product')->load($simpleOption->getProductId());
                $simpleOption->setProduct($simple_product);
            }
            $orderItem = Mage::getModel('sales/convert_quote')->itemToOrderItem($quote_item);
            $orderItem->setOrderId($order->getId());

            if ($quote_item->getParentItemId()) {
                $orderItem->setParentItem($order->getItemByQuoteItemId($quote_item->getParentItemId()));
            }

            if (Mage::getModel("tax/config")->priceIncludesTax()) {
                $orderItem->setOriginalPrice($orderItem->getPriceInclTax());
                $orderItem->setBaseOriginalPrice($orderItem->getBasePriceInclTax());
            } else {
                $orderItem->setOriginalPrice($orderItem->getPrice());
                $orderItem->setBaseOriginalPrice($orderItem->getBasePrice());
            }
            if (isset($simple_product)) {
                $new_sku = $simple_product->getData('sku');
                if (isset($new_sku)) {
                    $orderItem->setSku($new_sku);
                }
            }
            $orderItem->save($order->getId());

            //from inventory
            $stockItem = Mage::getModel('cataloginventory/stock_item')->loadByProduct($orderItem->getProductId());
            if ($stockItem->checkQty($orderItem->getQtyOrdered()) || Mage::app()->getStore()->isAdmin()) {
                $stockItem->subtractQty($orderItem->getQtyOrdered());
                $stockItem->save();
                $this->addedItems = true;
            }

            $this->addOrderTaxItemTable($orderItem, $quote_item);
        } catch (Exception $e) {
            Mage::log($e->getMessage(), null, 'iwd_order_manager.log');
            return null;
        }

        Mage::dispatchEvent('iwd_sales_order_item_added', array('order_item' => $orderItem));

        return $orderItem;
    }

    protected function addChildrenItems($quote_item_id, $quote, $orderItem, $order)
    {
        $id = $orderItem->getId();
        $qty = $orderItem->getQtyOrdered();

        // children
        $quote_children_items = Mage::getModel("sales/quote_item")
            ->getCollection()->setQuote($quote)
            ->addFieldToFilter("parent_item_id", $quote_item_id);

        foreach ($quote_children_items as $quote_children_item) {
            $quote_children_item->setQuote($quote);
            $orderItem = $this->addItemToOrder($order, $quote_children_item);
            $order_item_qty = $orderItem->getQtyOrdered() * $qty;
            $orderItem->setQtyOrdered($order_item_qty)
                ->setParentItemId($id)
                ->save();
        }
    }

    protected function removeOrderItem($orderItem)
    {
        $product_type = $orderItem->getProductType();

        /* return to stock */
        $this->reduceProduct($orderItem, 0);

        /* delete children items */
        if ($product_type == Mage_Catalog_Model_Product_Type::TYPE_BUNDLE || $product_type == Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE) {
            $children_items = $orderItem->getChildrenItems();
            foreach ($children_items as $children_item) {
                $this->deleteItem($children_item);
            }
        }

        /* delete download items */
        if ($product_type == Mage_Downloadable_Model_Product_Type::TYPE_DOWNLOADABLE) {
            $collection = Mage::getModel('downloadable/link_purchased_item')->getCollection()->addFieldToFilter('order_item_id', $orderItem->getId());
            foreach ($collection as $item) {
                $item->delete();
            }
        }

        /* delete shipping items */
        $shipment_items = Mage::getModel('sales/order_shipment_item')->getCollection()
            ->addFieldToFilter('order_item_id', $orderItem->getItemId());
        foreach ($shipment_items as $shipment_item) {
            $shipment = Mage::getModel('sales/order_shipment')->load($shipment_item->getParentId());
            $qty = $shipment->getTotalQty() - $shipment_item->getQty();
            $shipment->setTotalQty($qty)->save();
            $shipment_item->delete();
        }

        /* delete creditmemo items */
        $creditmemo_items = Mage::getModel('sales/order_creditmemo_item')->getCollection()
            ->addFieldToFilter('order_item_id', $orderItem->getItemId());
        foreach ($creditmemo_items as $creditmemo_item) {
            $creditmemo_item->delete();
        }

        /* delete from tax table */
        $this->deleteItemFromOrderTaxItemTable($orderItem);

        $this->deleteItem($orderItem);
        $this->addToLogAboutDeleteOrderItem($orderItem);
    }

    /**
     * @param $orderItem Mage_Sales_Model_Order_Item
     */
    protected function deleteItem($orderItem)
    {
        Mage::dispatchEvent('iwd_sales_order_item_removed', array('order_item' => $orderItem));

        if (!$this->removeInvoice) {
            /** @var $invoice IWD_OrderManager_Model_Invoice */
            $invoice = Mage::getModel('iwd_ordermanager/invoice');
            $this->removeInvoice = $invoice->cancelInvoices($orderItem->getOrder());
        }

        try {
            $quoteItemId = $orderItem->getQuoteItemId();
            Mage::getModel('sales/quote_item')->load($quoteItemId)->delete();
        } catch (Exception $e) {

        }

        $orderItem->delete();
    }

    protected function addToLogAboutDeleteOrderItem($orderItem)
    {
        $is_refunded = ($orderItem->getQtyInvoiced() != 0);
        $this->getLogger()->addOrderItemRemove($orderItem, $is_refunded);
    }

    public function addOrderTaxItemTable($order_item, $quote_item)
    {
        if (in_array(round($order_item->getTaxPercent(), 2), $this->appliedTaxes)) {
            return;
        }

        $result = Mage::getModel('tax/sales_order_tax')->getCollection()
            ->addFieldToFilter('order_id', $order_item->getOrderId())
            ->addFieldToFilter('percent', $order_item->getTaxPercent());

        if (count($result) > 0) {
            $tax = $result->getFirstItem();
            $tax_amount = $this->currencyConvert($order_item->getTaxAmount());
            $base_tax_amount = $order_item->getTaxAmount();
            $tax->setBaseAmount($tax->getBaseAmount() + $base_tax_amount)
                ->setAmount($tax->getAmount() + $tax_amount)
                ->setBaseRealAmount($tax->getBaseRealAmount() + $base_tax_amount);
            $tax->save();

            $orderTaxItem = Mage::getModel('tax/sales_order_tax_item')->getCollection()
                ->addFieldToFilter('tax_id', $tax->getTaxId())
                ->addFieldToFilter('item_id',  $order_item->getItemId());

            if ($orderTaxItem->getSize() == 0) {
                $data = array(
                    'item_id'     => $order_item->getItemId(),
                    'tax_id'      => $tax->getTaxId(),
                    'tax_percent' => $tax->getPercent()
                );
                Mage::getModel('tax/sales_order_tax_item')->setData($data)->save();
            }
        } else {
            $address = $quote_item->getQuote()->getShippingAddress();
            $address = $address->collectTotals();
            $getTaxesForItems   = $address->getQuote()->getTaxesForItems();
            $taxes = $address->getAppliedTaxes();
            $order = Mage::getModel('sales/order')->load($order_item->getOrderId());
            $ratesIdQuoteItemId = array();
            if (!is_array($getTaxesForItems)) {
                $getTaxesForItems = array();
            }

            foreach ($getTaxesForItems as $quoteItemId => $taxesArray) {
                if ($quoteItemId != $quote_item->getId()) {
                    continue;
                }
                foreach ($taxesArray as $rates) {
                    if (count($rates['rates']) == 1) {
                        $ratesIdQuoteItemId[$rates['id']][] = array(
                            'id'        => $quoteItemId,
                            'percent'   => $rates['percent'],
                            'code'      => $rates['rates'][0]['code']
                        );
                    } else {
                        $percentDelta   = $rates['percent'];
                        $percentSum     = 0;
                        foreach ($rates['rates'] as $rate) {
                            $ratesIdQuoteItemId[$rates['id']][] = array(
                                'id'        => $quoteItemId,
                                'percent'   => $rate['percent'],
                                'code'      => $rate['code']
                            );
                            $percentSum += $rate['percent'];
                        }

                        if ($percentDelta != $percentSum) {
                            $delta = $percentDelta - $percentSum;
                            foreach ($ratesIdQuoteItemId[$rates['id']] as &$rateTax) {
                                if ($rateTax['id'] == $quoteItemId) {
                                    $rateTax['percent'] = (($rateTax['percent'] / $percentSum) * $delta)
                                        + $rateTax['percent'];
                                }
                            }
                        }
                    }
                }
            }
            foreach ($ratesIdQuoteItemId as $id => $arr) {
                $row = $taxes[$id];
                foreach ($taxes[$id]['rates'] as $tax) {
                    if (is_null($row['percent'])) {
                        $baseRealAmount = $row['base_amount'];
                    } else {
                        if ($row['percent'] == 0 || $tax['percent'] == 0) {
                            continue;
                        }
                        $baseRealAmount = $row['base_amount'] / $row['percent'] * $tax['percent'];
                    }
                    $hidden = (isset($row['hidden']) ? $row['hidden'] : 0);
                    $data = array(
                        'order_id'          => $order_item->getOrderId(),
                        'code'              => $tax['code'],
                        'title'             => $tax['title'],
                        'hidden'            => $hidden,
                        'percent'           => $tax['percent'],
                        'priority'          => $tax['priority'],
                        'position'          => $tax['position'],
                        'amount'            => $row['amount'],
                        'base_amount'       => $row['base_amount'],
                        'process'           => $row['process'],
                        'base_real_amount'  => $baseRealAmount,
                    );
                    $result = Mage::getModel('tax/sales_order_tax')->setData($data)->save();
                    foreach ($ratesIdQuoteItemId[$id] as $quoteItemId) {
                        if ($quoteItemId['code'] == $tax['code']) {
                            $item = $order->getItemByQuoteItemId($quoteItemId['id']);
                            if ($item) {
                                $data = array(
                                    'item_id'       => $item->getId(),
                                    'tax_id'        => $result->getTaxId(),
                                    'tax_percent'   => $quoteItemId['percent']
                                );
                                Mage::getModel('tax/sales_order_tax_item')->setData($data)->save();
                                $this->appliedTaxes[] = round($quoteItemId['percent'], 2);
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * @param $orderItem Mage_Sales_Model_Order_Item
     * @param $oldTaxAmount
     * @param $oldBaseTaxAmount
     * @param $oldTaxPercent
     */
    protected function updateOrderTaxItemTable($orderItem, $oldTaxAmount, $oldBaseTaxAmount, $oldTaxPercent)
    {
        if ((float)$orderItem->getTaxAmount() == (float)$oldTaxAmount) {
            return;
        }

        $tax = Mage::getModel('tax/sales_order_tax')->getCollection()
            ->addFieldToFilter('order_id', $orderItem->getOrderId())
            ->addFieldToFilter('percent', $oldTaxPercent)
            ->getFirstItem();

        $taxId = $tax->getTaxId();
        if (!empty($taxId)) {
            $taxItem = Mage::getModel('tax/sales_order_tax_item')->getCollection()
                ->addFieldToFilter('item_id', $orderItem->getId())
                ->getFirstItem();

            $taxItem->setData('item_id', $orderItem->getId());
            $taxItem->setData('tax_id', $taxId);
            $taxItem->setData('tax_percent', $orderItem->getTaxPercent());
            $taxItem->save();
        }

        if (round($oldTaxAmount, 2) != round($orderItem->getTaxAmount(), 2)) {
            $amount = $tax->getAmount() - $oldTaxAmount + $orderItem->getTaxAmount();
            $baseAmount = $tax->getBaseAmount() - $oldBaseTaxAmount + $orderItem->getBaseTaxAmount();
            $baseRealAmount = $tax->getBaseRealAmount() - $oldBaseTaxAmount + $orderItem->getBaseTaxAmount();

            $tax->setPercent($orderItem->getTaxPercent());
            $tax->setAmount($amount);
            $tax->setBaseAmount($baseAmount);
            $tax->setBaseRealAmount($baseRealAmount);

            $tax->save();
        }
    }

    /**
     * @param $orderItem
     */
    protected function deleteItemFromOrderTaxItemTable($orderItem)
    {
        $taxItems = Mage::getModel('tax/sales_order_tax_item')->getCollection()
            ->addFieldToFilter('item_id', $orderItem->getId());

        foreach ($taxItems as $taxItem) {
            $orderTaxes = Mage::getModel('tax/sales_order_tax')->getCollection()
                ->addFieldToFilter('tax_id', $taxItem->getTaxId());
            foreach ($orderTaxes as $orderTax) {
                $orderTax->delete();
            }

            $taxItem->delete();
        }
    }

    public function updateOrderTaxTable($order_id)
    {
        $source = Mage::getModel('sales/order')->load($order_id);

        $this->deleteOrderShippingTax($source);

        $orderItems = $source->getItemsCollection();
        $taxes = array();
        $redundantTaxes = array();

        foreach ($orderItems as $item) {
            $id = $item->getTaxPercent();
            if (!isset($taxes[$id])) {
                $taxes[$id] = array('amount' => 0, 'base_amount' => 0);
            }

            $taxes[$id]['amount'] += $item->getTaxAmount();
            $taxes[$id]['base_amount'] += $item->getBaseTaxAmount();
        }

        $rates = Mage::getModel('sales/order_tax')->getCollection()->loadByOrder($source);
        $itemTaxes = array();
        foreach ($rates as $rate) {
            $id = $rate->getPercent();
            if (isset($taxes[$id])) {
                $rate->setAmount($taxes[$id]['amount'])
                    ->setBaseAmount($taxes[$id]['base_amount'])
                    ->save();
                $itemTaxes[] = $rate->getTaxId();
                unset($taxes[$id]);
            } else {
                $redundantTaxes[$rate->getTaxId()] = $rate;
            }
        }

        $shippingOrderTaxId = $this->updateShippingOrderTaxes($source, $itemTaxes);
        unset($redundantTaxes[$shippingOrderTaxId]);
        foreach ($redundantTaxes as $redundantTax) {
            $redundantTax->delete();
        }
    }

    /**
     * @param $order
     * @param $itemTaxes
     * @return int
     */
    protected function updateShippingOrderTaxes($order, $itemTaxes)
    {
        $taxClassId = $this->getShippingTaxClass($order);
        if ($taxClassId != 0) {
            $orderTax = $this->getOrderTaxForShipping($order);

            $amount = $order->getShippingTaxAmount();
            $baseAmount = $order->getBaseShippingTaxAmount();

            if (in_array($orderTax->getTaxId(), $itemTaxes)) {
                $amount = $orderTax->getAmount() + $order->getShippingTaxAmount();
                $baseAmount = $orderTax->getBaseAmount() + $order->getBaseShippingTaxAmount();
            }

            $orderTax->setAmount($amount)
                ->setBaseAmount($baseAmount)
                ->setBaseRealAmount($baseAmount)
                ->save();

            return $orderTax->getId();
        }

        return 0;
    }

    /**
     * @param $order
     * @return float|int
     */
    protected function getShippingPercent($order)
    {
        $exclPrice = $order->getBaseShippingAmount();
        $inclPrice = $order->getBaseShippingInclTax();

        return Mage::helper('iwd_ordermanager')->getRoundPercent($exclPrice, $inclPrice);
    }

    /**
     * @param $order
     * @return mixed
     */
    protected function getOrderTaxForShipping($order)
    {
        $percent = $this->getShippingPercent($order);

        $orderTaxCollection = Mage::getModel('sales/order_tax')->getCollection()
            ->addFieldToFilter('order_id', $order->getId())
            ->addFieldToFilter('percent', $percent);

        $orderTax = $orderTaxCollection->getFirstItem();

        if (!$orderTax->getTaxId()) {
            $orderTax->setOrderId($order->getId())
                ->setCode('iwd_om_shipping')
                ->setTitle('Shipping')
                ->setAmount(0)
                ->setBaseAmount(0)
                ->setPercent($percent);
        }

        return $orderTax;
    }

    protected function deleteOrderShippingTax($order)
    {
        $orderTaxCollection = Mage::getModel('sales/order_tax')->getCollection()
            ->addFieldToFilter('order_id', $order->getId())
            ->addFieldToFilter('code', 'iwd_om_shipping');
        foreach ($orderTaxCollection as $item) {
            $item->delete();
        }
    }

    /**
     * @param $order Mage_Sales_Model_Order
     * @return int
     */
    protected function getShippingTaxClass($order)
    {
        /** @var $taxConfig Mage_Tax_Model_Config */
        $taxConfig = Mage::getModel('tax/config');
        return $taxConfig->getShippingTaxClass($order->getStore());
    }

    public function collectOrderTotals($orderId)
    {
        /** @var $order Mage_Sales_Model_Order */
        $order = $this->loadOrder($orderId);

        $totalQtyOrdered = 0;
        $weight = 0;
        $totalItemCount = 0;
        $baseTaxAmount = 0;
        $baseHiddenTaxAmount = 0;
        $baseDiscountAmount = 0;
        $baseTotalWeeeDiscount = 0;
        $baseSubtotal = 0;
        $baseSubtotalInclTax = 0;

        /** @var $orderItem Mage_Sales_Model_Order_Item */
        foreach ($order->getItemsCollection() as $orderItem) {
            $baseDiscountAmount += $orderItem->getBaseDiscountAmount();

            //bundle part
            if ($orderItem->getParentItem()) {
                continue;
            }

            $baseTaxAmount += $orderItem->getBaseTaxAmount();
            $baseHiddenTaxAmount += $orderItem->getBaseHiddenTaxAmount();

            $totalQtyOrdered += $orderItem->getQtyOrdered();
            $totalItemCount++;
            $weight += $orderItem->getRowWeight();
            $baseSubtotal += $orderItem->getBaseRowTotal(); /* RowTotal for item is a subtotal */
            $baseSubtotalInclTax += $orderItem->getBaseRowTotalInclTax();
            $baseTotalWeeeDiscount += $orderItem->getBaseDiscountAppliedForWeeeTax();
        }

        //$baseSubtotalInclTax = $baseSubtotal + $baseHiddenTaxAmount + $baseTotalWeeeDiscount + $baseTaxAmount;

        /** convert currency **/
        $baseCurrencyCode = $order->getBaseCurrencyCode();
        $orderCurrencyCode = $order->getOrderCurrencyCode();

        /** @var $directory Mage_Directory_Helper_Data */
        $directory = Mage::helper('directory');
        if ($baseCurrencyCode === $orderCurrencyCode) {
            $discountAmount = $baseDiscountAmount;
            $taxAmount = $baseTaxAmount;
            $hiddenTaxAmount = $baseHiddenTaxAmount;
            $subtotal = $baseSubtotal;
            $subtotalInclTax = $baseSubtotalInclTax;
        } else {
            $discountAmount = $directory->currencyConvert($baseDiscountAmount, $baseCurrencyCode, $orderCurrencyCode);
            $taxAmount = $directory->currencyConvert($baseTaxAmount, $baseCurrencyCode, $orderCurrencyCode);
            $hiddenTaxAmount = $directory->currencyConvert($baseHiddenTaxAmount, $baseCurrencyCode, $orderCurrencyCode);
            $subtotal = $directory->currencyConvert($baseSubtotal, $baseCurrencyCode, $orderCurrencyCode);
            $subtotalInclTax = $directory->currencyConvert($baseSubtotalInclTax, $baseCurrencyCode, $orderCurrencyCode);
        }

        $order->setTotalQtyOrdered($totalQtyOrdered)
            ->setWeight($weight)
            ->setSubtotal($subtotal)->setBaseSubtotal($baseSubtotal)
            ->setSubtotalInclTax($subtotalInclTax)->setBaseSubtotalInclTax($baseSubtotalInclTax)
            ->setTaxAmount($taxAmount)->setBaseTaxAmount($baseTaxAmount)
            ->setHiddenTaxAmount($hiddenTaxAmount)->setBaseHiddenTaxAmount($baseHiddenTaxAmount)
            ->setDiscountAmount('-' . $discountAmount)->setBaseDiscountAmount('-' . $baseDiscountAmount)
            ->setTotalItemCount($totalItemCount);

        $order->save();

        $this->calculateGrandTotal($order);

        $this->updateOrderTaxTable($orderId);
    }

    /**
     * @param $order Mage_Sales_Model_Order
     */
    protected function calculateGrandTotal($order)
    {
        $feeTaxAmount = $order->getIwdOmFeeAmountInclTax() - $order->getIwdOmFeeAmount();
        $baseFeeTaxAmount = $order->getIwdOmFeeBaseAmountInclTax() - $order->getIwdOmFeeBaseAmount();

        // shipping tax
        $tax = $order->getTaxAmount() + $order->getShippingTaxAmount() + $feeTaxAmount;
        $baseTax = $order->getBaseTaxAmount() + $order->getBaseShippingTaxAmount() + $baseFeeTaxAmount;

        $order->setTaxAmount($tax)->setBaseTaxAmount($baseTax)->save();

        // Order GrandTotal include tax
        $grandTotal = $order->getSubtotal() + $order->getTaxAmount() + $order->getShippingAmount() - abs($order->getDiscountAmount()) + $order->getHiddenTaxAmount();
        $baseGrandTotal = $order->getBaseSubtotal() + $order->getBaseTaxAmount() + $order->getBaseShippingAmount() - abs($order->getBaseDiscountAmount()) + $order->getBaseHiddenTaxAmount();

        // Custom Amount
        $grandTotal += $order->getIwdOmFeeAmount();
        $baseGrandTotal += $order->getIwdOmFeeBaseAmount();

        $order->setGrandTotal($grandTotal)
            ->setBaseGrandTotal($baseGrandTotal)
            ->save();

        $this->addCustomPriceToOrderGrandTotal($order);
    }

    protected function loadOrder($orderId)
    {
        return Mage::getModel('sales/order')->load($orderId);
    }

    protected function addCustomPriceToOrderGrandTotal($order)
    {
        //TODO: add custom logic if you need add custom price to order
        return;

        /*
        $additionalTotal = 0.0;       // add custom amount
        $additionalBaseTotal = 0.0;   // add custom base amount

        $grandTotal = $order->getGrandTotal();
        $baseGrandTotal = $order->getBaseGrandTotal();
        $order->setGrandTotal($grandTotal + $additionalTotal)
            ->setBaseGrandTotal($baseGrandTotal + $additionalBaseTotal)
            ->save();
        */
    }
}
