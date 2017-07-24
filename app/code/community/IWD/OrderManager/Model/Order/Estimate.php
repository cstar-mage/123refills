<?php

class IWD_OrderManager_Model_Order_Estimate extends IWD_OrderManager_Model_Order_Edit
{
    protected function estimateEditItem($orderItem, $item)
    {
        $logger = Mage::getSingleton('iwd_ordermanager/logger');

        // product_options
        if (isset($item['product_options']) && !empty($item['product_options'])) {
            $productOptions = $item['product_options'];
            Mage::getModel('iwd_ordermanager/order_edit')->addToLogProductOptions($orderItem, $orderItem->getData('product_options'), $productOptions);
        }

        // description
        if (isset($item['description'])) {
            $logger->addOrderItemEdit($orderItem, 'Description', $orderItem->getDescription(), $item['description']);
        }

        // qty ordered
        if (isset($item['fact_qty'])) {
            $logger->addOrderItemEdit($orderItem, 'Qty', number_format($orderItem->getQtyOrdered() - $orderItem->getQtyRefunded(), 2), number_format($item['fact_qty'], 2));
        }

        // tax amount
        if (isset($item['tax_amount'])) {
            $logger->addOrderItemEdit($orderItem, 'Tax amount', number_format($orderItem->getBaseTaxAmount(), 2), $item['tax_amount']);
        }

        // tax percent
        if (isset($item['tax_percent'])) {
            $logger->addOrderItemEdit($orderItem, 'Tax percent', number_format($orderItem->getTaxPercent(), 2), number_format($item['tax_percent'], 2));
        }

        // price
        if (isset($item['price'])) {
            $logger->addOrderItemEdit($orderItem, 'Price (excl. tax)', number_format($orderItem->getBasePrice(), 2), $item['price'], 'currency');
        }

        // discount amount
        if (isset($item['discount_amount'])) {
            $logger->addOrderItemEdit($orderItem, 'Discount amount', number_format($orderItem->getBaseDiscountAmount(), 2), $item['discount_amount']);
        }

        // discount percent
        if (isset($item['discount_percent'])) {
            $logger->addOrderItemEdit($orderItem, 'Discount percent', number_format($orderItem->getDiscountPercent(), 2), number_format($item['discount_percent'], 2));
        }
    }

    protected function estimateDeleteItem($orderItem)
    {
        $refund = ($orderItem->getQtyInvoiced() != 0);
        Mage::getSingleton('iwd_ordermanager/logger')->addOrderItemRemove($orderItem, $refund);
    }

    protected function estimateAddNewItems($items)
    {
        $newItems = array();

        foreach ($items as $id => $item) {
            if (isset($item['quote_item'])) {
                if (isset($item['remove']) && $item['remove'] == 1) {
                    continue;
                }

                $quoteItem = Mage::getModel('sales/quote_item')->load($item['quote_item']);
                if (!$quoteItem->getId()) {
                    continue;
                }

                Mage::getSingleton('iwd_ordermanager/logger')->addOrderItemAdd($quoteItem);
            } else {
                $newItems[$id] = $item;
            }
        }

        return $newItems;
    }

    public function estimateEditItems($orderId, $items)
    {
        $order = Mage::getModel('sales/order')->load($orderId);

        /* check status */
        if (!$this->checkOrderStatusForUpdate($order)) {
            Mage::getSingleton('adminhtml/session')->addError("Sorry... You can't edit order with current status. Check configuration: IWD >> Order Manager >> Edit Order");
            return;
        }

        $logger = Mage::getSingleton('iwd_ordermanager/logger');

        $baseGrandTotal = 0;
        $qtyOrdered = 0;
        $weight = 0;
        $baseSubtotal = 0;
        $discount = 0;

        /* edit items */
        foreach ($items as $id => $item) {
            $orderItem = $order->getItemById($id);

            if (isset($item['price'])) {
                $item['custom_price'] = $item['price'];
                $item['original_custom_price'] = $item['price'];
            }

            /* add new */
            if (isset($item['quote_item'])) {
                if (isset($item['remove']) && $item['remove'] == 1) {
                    continue;
                }

                $quoteItem = Mage::getModel('sales/quote_item')->load($item['quote_item']);
                if (!$quoteItem->getId()) {
                    continue;
                }

                $weight += $quoteItem->getWeight() * $item['fact_qty'];
                $logger->addOrderItemAdd($quoteItem);
            } else {
                /**** remove item ****/
                if (isset($item['remove']) && $item['remove'] == 1) {
                    if ($orderItem->getProductType() == Mage_Catalog_Model_Product_Type::TYPE_BUNDLE) {
                        foreach ($orderItem->getChildrenItems() as $c_item) {
                            $this->estimateDeleteItem($c_item);
                        }
                    }
                    $this->estimateDeleteItem($orderItem);
                    continue;
                }

                /**** check data ****/
                if (!$this->checkItemData($item)) {
                    Mage::getSingleton('adminhtml/session')->addError(Mage::helper('iwd_ordermanager')->__("Enter the correct data for product with sku [{$orderItem->getSku()}]"));
                    continue;
                }

                $this->estimateEditItem($orderItem, $item);

                if ($orderItem->getParentItemId() == null) {
                    $weight += $orderItem->getWeight() * $item['fact_qty'];
                }
            }

            $baseGrandTotal += $item['row_total'];
            $qtyOrdered += $item['fact_qty'];
            $baseSubtotal += $item['subtotal'];
            $discount += $item['discount_amount'];
        }

        $this->estimateOrderTotals($orderId, $qtyOrdered, $weight, $baseGrandTotal, $baseSubtotal);
    }

    protected function estimateOrderTotals($orderId, $qtyOrdered, $weight, $baseGrandTotal, $baseSubtotal)
    {
        $order = Mage::getModel('sales/order')->load($orderId);

        $baseCurrencyCode = $order->getBaseCurrencyCode();
        $orderCurrencyCode = $order->getOrderCurrencyCode();

        if (!$order->getIsVirtual()) {
            $iwdShipping = Mage::getModel('iwd_ordermanager/shipping');
            $request = $iwdShipping->prepareShippingRequest($order);
            $request
                ->setPackageValue($baseSubtotal)
                ->setPackageValueWithDiscount($baseGrandTotal)
                ->setPackageWeight($weight)
                ->setPackageQty($qtyOrdered);

            $shippingAmount = $iwdShipping->estimateShippingAmount($order, $request, true);

            if (!empty($shippingAmount)) {
                $baseGrandTotal += $shippingAmount;
            } else {
                //TODO: show form with available shipping methods and change method
                $baseGrandTotal += $order->getBaseShippingInclTax();
            }
        }

        $grand_total = Mage::helper('directory')->currencyConvert($baseGrandTotal, $baseCurrencyCode, $orderCurrencyCode);

        $totals = array(
            'grand_total' => $grand_total,
            'base_grand_total' => $baseGrandTotal,
        );

        Mage::getSingleton('iwd_ordermanager/logger')->addNewTotalsToLog($totals);
    }
}