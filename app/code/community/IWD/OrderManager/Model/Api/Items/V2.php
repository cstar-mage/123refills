<?php

class IWD_OrderManager_Model_Api_Items_v2 extends IWD_OrderManager_Model_Api_Abstract_Api
{
    protected $item;
    private $taxModel;

    protected function _checkFactQty()
    {
        $cataloginventory = Mage::getModel('cataloginventory/stock_item');
        $stock = $cataloginventory->loadByProduct($this->item['product_id']);
        $stockQtyIncrements = $stock->getQtyIncrements();
        $stockQty = array();
        if ($this->item['item_obj']->getProductType() == Mage_Catalog_Model_Product_Type::TYPE_BUNDLE) {
            foreach ($this->item['item_obj']->getChildrenItems() as $childrenItem) {
                $childrenItemQty = $childrenItem->getQtyOrdered() - $childrenItem->getQtyRefunded() - $childrenItem->getQtyCancelled();
                $stockQty[] = $cataloginventory->loadByProduct($childrenItem->getProduct())->getQty() + $childrenItemQty;
            }
            $stockQty = min($stockQty);
        } else {
            $block = Mage::getSingleton('core/layout')->createBlock('iwd_ordermanager/adminhtml_sales_order_items_form');
            $stock = $block->getStockObjectForOrderItem($this->item['item_obj']);
            $itemQty = $this->item['item_obj']->getQtyOrdered() - $this->item['item_obj']->getQtyRefunded() - $this->item['item_obj']->getQtyCancelled();
            $itemQty = $itemQty < 0 ? 0 : $itemQty;
            $stockQty = $stock->getQty() + $itemQty;
        }

        $stockMinSaleQty = $stock->getMinSaleQty();
        $stockMaxSaleQty = $stock->getMaxSaleQty();
        $stockQtyIncrement = $stockQtyIncrements ? $stockQtyIncrements : 1;
        $stockQty = $stockQty ? $stockQty : 1;
        $stockMinSaleQty = $stockMinSaleQty ? $stockMinSaleQty : 1;
        $stockMaxSaleQty = $stockMaxSaleQty ? $stockMaxSaleQty : 1;

        $factQty = $this->item['fact_qty'];
        if ($factQty <= 0) {
            $factQty = 1;
        }
        if (Mage::helper("iwd_ordermanager")->isValidateInventory()) {
            if ($factQty > $stockMaxSaleQty) {
                $factQty = $stockMaxSaleQty;
            }
            if ($factQty < $stockMinSaleQty) {
                $factQty = $stockMinSaleQty;
            }
            if ($stockQty < $factQty) {
                $factQty = $stockQty;
            }
        }

        if ($factQty % $stockQtyIncrement) {
            $factQty = round(($this->item['fact_qty'] / $stockQtyIncrement)) * $stockQtyIncrement;
        }

        $this->item['fact_qty'] = $factQty;
    }

    protected function _calculateRowTotal()
    {
        $this->item['row_total'] = $this->item['subtotal']
            + $this->item['tax_amount']
            + $this->item['hidden_tax_amount']
            + $this->item['weee_tax_applied_row_amount']
            - $this->item['discount_amount'];
    }

    protected function _baseCalculation()
    {
        $taxType = $this->getTaxModel()->getAlgorithm();
        switch ($taxType) {
            case 'UNIT_BASE_CALCULATION':
                $this->_unitBaseCalculation();
                break;
            case 'ROW_BASE_CALCULATION':
                $this->_rowBaseCalculation();
                break;
            case 'TOTAL_BASE_CALCULATION':
                $this->_totalBaseCalculation();
                break;
        }
    }

    protected function _unitBaseCalculation()
    {
        switch ($this->_getCalculationSequence()) {
            case '0_0':
                $this->item['tax_amount'] = $this->_calcTaxAmount($this->item['subtotal'], $this->item['tax_percent'], 0);
                $this->_calculateDiscountAmount($this->item['subtotal']);
                break;
            case '0_1':
                $this->item['tax_amount'] = $this->_calcTaxAmount($this->item['subtotal_incl_tax'], $this->item['tax_percent'], 1);
                $this->_calculateDiscountAmount($this->item['subtotal_incl_tax']);
                break;
            case '1_0':
                $this->_calculateDiscountAmount($this->item['subtotal']);
                if ($this->taxModel->priceIncludesTax()) {
                    $unitTax = $this->_calcTaxAmount($this->item['price_incl_tax'], $this->item['tax_percent'], 1);
                    $unitTaxDiscount = $this->_calcTaxAmount($this->item['discount_amount'], ($unitTax / $this->item['price_incl_tax']) * 100, 0);
                    $this->item['hidden_tax_amount'] = $this->_calcTaxAmount($this->item['discount_amount'], $this->item['tax_percent'], 1);
                } else {
                    $unitTax = $this->_calcTaxAmount($this->item['price'], $this->item['tax_percent'], 0);
                    $unitTaxDiscount = $this->_calcTaxAmount($this->item['discount_amount'], $this->item['tax_percent'], 0);
                }
                $unitTax = max($unitTax - $unitTaxDiscount, 0);
                $this->item['tax_amount'] = max($this->item['fact_qty'] * $unitTax, 0);
                $this->item['hidden_tax_amount'] = max($this->item['fact_qty'] * $this->item['hidden_tax_amount'], 0);
                break;
            case '1_1':
                $this->_calculateDiscountAmount($this->item['subtotal_incl_tax']);
                if ($this->taxModel->priceIncludesTax()) {
                    $unitTax = $this->_calcTaxAmount($this->item['price_incl_tax'], $this->item['tax_percent'], 1);
                    $unitTaxDiscount = $this->_calcTaxAmount($this->item['discount_amount'], ($unitTax / $this->item['price_incl_tax']) * 100, 0);
                    $this->item['hidden_tax_amount'] = $this->_calcTaxAmount($this->item['discount_amount'], $this->item['tax_percent'], 1);
                } else {
                    $unitTax = $this->_calcTaxAmount($this->item['price'], $this->item['tax_percent'], 0);
                    $unitTaxDiscount = $this->_calcTaxAmount($this->item['discount_amount'], $this->item['tax_percent'], 0);
                }
                $unitTax = max($unitTax - $unitTaxDiscount, 0);
                $this->item['tax_amount'] = max($this->item['fact_qty'] * $unitTax, 0);
                $this->item['hidden_tax_amount'] = max($this->item['fact_qty'] * $this->item['hidden_tax_amount'], 0);
                break;
        }
    }

    protected function _rowBaseCalculation()
    {
        switch ($this->_getCalculationSequence()) {
            case '0_0':
                $this->item['tax_amount'] = $this->_calcTaxAmount($this->item['subtotal'], $this->item['tax_percent'], 0);
                $this->_calculateDiscountAmount($this->item['subtotal']);
                break;
            case '0_1':
                $this->item['tax_amount'] = $this->_calcTaxAmount($this->item['subtotal_incl_tax'], $this->item['tax_percent'], 1);
                $this->_calculateDiscountAmount($this->item['subtotal_incl_tax']);
                break;
            case '1_0':
                $this->_calculateDiscountAmount($this->item['subtotal']);
                if ($this->taxModel->priceIncludesTax()) {
                    $this->item['hidden_tax_amount'] = $this->_calcTaxAmount($this->item['discount_amount'], $this->item['tax_percent'], 1);
                    $this->item['tax_amount'] = $this->_calcTaxAmount($this->item['subtotal'], $this->item['tax_percent'], 0);
                    $this->item['tax_amount'] -= $this->item['hidden_tax_amount'];
                } else {
                    $this->item['tax_amount'] = $this->_calcTaxAmount($this->item['subtotal'] - $this->item['discount_amount'], $this->item['tax_percent'], 0);
                }
                break;
            case '1_1':
                $this->_calculateDiscountAmount($this->item['subtotal_incl_tax']);
                if ($this->taxModel->priceIncludesTax()) {
                    $this->item['hidden_tax_amount'] = $this->_calcTaxAmount($this->item['discount_amount'], $this->item['tax_percent'], 1);
                    $this->item['tax_amount'] = $this->_calcTaxAmount($this->item['subtotal'], $this->item['tax_percent'], 0);
                    $this->item['tax_amount'] -= $this->item['hidden_tax_amount'];
                } else {
                    $this->item['tax_amount'] = $this->_calcTaxAmount($this->item['subtotal'] - $this->item['discount_amount'], $this->item['tax_percent'], 0);
                }
                break;
        }
    }

    protected function _totalBaseCalculation()
    {
        switch ($this->_getCalculationSequence()) {
            case '0_0':
                $this->item['tax_amount'] = $this->_calcTaxAmount($this->item['subtotal'], $this->item['tax_percent'], 0);
                $this->_calculateDiscountAmount($this->item['subtotal']);
                break;
            case '0_1':
                $this->item['tax_amount'] = $this->_calcTaxAmount($this->item['subtotal_incl_tax'], $this->item['tax_percent'], 1);
                $this->_calculateDiscountAmount($this->item['subtotal_incl_tax']);
                break;
            case '1_0':
                $this->_calculateDiscountAmount($this->item['subtotal']);
                $this->item['hidden_tax_amount'] = $this->_calcTaxAmount($this->item['discount_amount'], $this->item['tax_percent'], 0);
                if ($this->taxModel->priceIncludesTax()) {
                    $price = $this->item['subtotal'] - $this->item['discount_amount'];
                } else {
                    $price = $this->item['subtotal'] - $this->item['discount_amount'] - $this->item['hidden_tax_amount'];
                    $this->item['hidden_tax_amount'] = 0;
                }
                $this->item['tax_amount'] = $this->_calcTaxAmount($price, $this->item['tax_percent'], 0);
                break;
            case '1_1':
                $this->_calculateDiscountAmount($this->item['subtotal_incl_tax']);
                if ($this->taxModel->priceIncludesTax()) {
                    $this->item['hidden_tax_amount'] = $this->_calcTaxAmount($this->item['discount_amount'], $this->item['tax_percent'], 1);
                    $price = $this->item['subtotal'] - $this->item['discount_amount'] + $this->item['hidden_tax_amount'];
                } else {
                    $this->item['hidden_tax_amount'] = 0;
                    $price = $this->item['subtotal'] - $this->item['discount_amount'];
                }
                $this->item['tax_amount'] = $this->_calcTaxAmount($price, $this->item['tax_percent'], 0);
                break;
        }
    }

    protected function _calculateDiscountAmount($price)
    {
        $this->item['discount_amount'] = $price * ($this->item['discount_percent'] / 100);
    }

    protected function _calcTaxAmount($price, $taxPercent, $inclTax)
    {
        $tax_rate = $taxPercent / 100;
        if ($inclTax) {
            return $price * (1 - 1 / (1 + $tax_rate));
        } else {
            return $price * $tax_rate;
        }
    }

    private function getTaxModel()
    {
        if ($this->taxModel) {
            return $this->taxModel;
        }
        $this->taxModel = Mage::getModel('tax/config');
        return $this->taxModel;
    }

    protected function _getCalculationSequence()
    {
        $apply_after_discount = $this->getTaxModel()->applyTaxAfterDiscount();
        $discount_tax = $this->getTaxModel()->discountTax();
        if ($apply_after_discount) {
            return ($discount_tax) ? '1_1' : '1_0';
        } else {
            return ($discount_tax) ? '0_1' : '0_0';
        }
    }

    protected function _calculateSubtotal()
    {
        $this->item['subtotal'] = $this->item['price'] * $this->item['fact_qty'];
        $this->item['subtotal_incl_tax'] = $this->item['price_incl_tax'] * $this->item['fact_qty'];
    }

    protected function _calculatePriceInclTax()
    {
        $taxPercent = $this->item['tax_percent'];
        $price_excl_tax = $this->item['price_incl_tax'] / (1 + $taxPercent / 100);
        $this->item['price'] = $price_excl_tax;
    }

    protected function _calculatePriceExclTax()
    {
        $taxPercent = $this->item['tax_percent'];
        $price_incl_tax = $this->item['price'] * (1 + $taxPercent / 100);
        $this->item['price_incl_tax'] = $price_incl_tax;
    }

    protected function _initOrderInputs($item)
    {
        $block = Mage::getSingleton('core/layout')->createBlock('iwd_ordermanager/adminhtml_sales_order_items_form');
        $this->item['description'] = $item->getDescription();
        $this->item['original_price'] = number_format($item->getBaseOriginalPrice(), 2, '.', '');
        $this->item['price'] = number_format($item->getBasePrice(), 2, '.', '');
        $this->item['price_incl_tax'] = number_format($item->getBasePriceInclTax(), 2, '.', '');
        $itemQty = $item->getQtyOrdered() - $item->getQtyRefunded() - $item->getQtyCancelled();
        $itemQty = $itemQty < 0 ? 0 : $itemQty;
        $this->item['fact_qty'] = $itemQty * 1;
        $this->item['subtotal'] = number_format($item->getBaseRowTotal(), 2, '.', '');
        $this->item['subtotal_incl_tax'] = number_format($item->getBaseRowTotalInclTax(), 2, '.', '');
        $this->item['row_total'] = number_format($block->getBaseRowTotal($item), 2, '.', '');
        $this->item['discount_percent'] = number_format($item->getDiscountPercent(), 2, '.', '');
        $this->item['discount_amount'] = number_format($item->getBaseDiscountAmount(), 2, '.', '');
        $this->item['tax_percent'] = number_format($item->getTaxPercent(), 2, '.', '');

        if ($item->getProductType() == Mage_Catalog_Model_Product_Type::TYPE_BUNDLE) {
            $this->item['tax_amount'] = number_format($item->getBaseTaxAmount(), 2, '.', '');
            $this->item['hidden_tax_amount'] = number_format($item->getBaseHiddenTaxAmount(), 2, '.', '');
            $this->item['weee_tax_applied_row_amount'] = number_format($item->getBaseWeeeTaxAppliedRowAmount(), 2, '.', '');
        } else {
            $this->item['tax_amount'] = number_format($item->getTaxAmount(), 2, '.', '');
            $this->item['hidden_tax_amount'] = number_format($item->getHiddenTaxAmount(), 2, '.', '');
            $this->item['weee_tax_applied_row_amount'] = number_format($item->getWeeeTaxAppliedRowAmount(), 2, '.', '');
        }

        $this->item['product_id'] = $item->getProductId();
        $this->item['item_obj'] = $item;
    }

    protected function _validateQuote($quote, &$message)
    {
        $helper = Mage::helper('iwd_ordermanager');
        $validate_inventory = $helper->isValidateInventory();
        if ($validate_inventory && $quote->getHasError()) {
            $errorInfos = $quote->getErrorInfos();
            if (!empty($errorInfos)) {
                foreach ($errorInfos as $errorInfo) {
                    $message .= $errorInfo['message'] . '</br>';
                }
            }
            return false;
        }
        return true;
    }

    protected function _prepareProductOptions($params, $options)
    {
        $options = Mage::helper('core')->jsonDecode($options);
        foreach ($params as $id => $arr) {
            $bundleOption = $this->_prepareProductOption($options, $id, 'bundle_option');
            if (!empty($bundleOption)) {
                $params[$id]['bundle_option'] = $bundleOption;
            }

            $bundleOptionQty = $this->_prepareProductOption($options, $id, 'bundle_option_qty');
            if (!empty($bundleOptionQty)) {
                $params[$id]['bundle_option_qty'] = $bundleOptionQty;
            }

            $superGroup = $this->_prepareProductOption($options, $id, 'super_group');
            if (!empty($superGroup)) {
                $params[$id]['super_group'] = $superGroup;
            }

            $superAttribute = $this->_prepareProductOption($options, $id, 'super_attribute');
            if (!empty($superAttribute)) {
                $params[$id]['super_attribute'] = $superAttribute;
            }

            $links = $this->_prepareProductOption($options, $id, 'links');
            if (!empty($links)) {
                $params[$id]['links'] = $links;
            }

            $_options = $this->_prepareProductOption($options, $id, 'options');
            if (!empty($_options)) {
                $params[$id]['options'] = $_options;
            }
        }
        return $params;
    }

    protected function _prepareProductOption($options, $product_id, $type)
    {
        $optionsArray = array();
        if (isset($options[$product_id])) {
            foreach ($options[$product_id] as $option) {
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

    public function updateItemQty(array $data)
    {
        $response = array();
        $id = md5(time());
        $this->log('updateItemQty api request ' . date('d-m-Y H:i:s') . ' ' . $id);
        $this->log($data);
        foreach ($data as $key => $obj) {
            try {
                $item_id = $obj->item_id;
                $orderId = $obj->order_id;
                $qty = $obj->qty;
                $response[$key]['order_id'] = $orderId;
                $response[$key]['item_id'] = $item_id;
                $response[$key]['qty'] = $qty;
                $order = Mage::getModel('sales/order')->load($orderId);
                $order_item = $order->getItemById($item_id);
                if (!$order_item) {
                    Mage::throwException('Invalid order item');
                }
                $this->_initOrderInputs($order_item);
                $this->item['fact_qty'] = $qty;
                $this->_checkFactQty();
                $this->_calculateSubtotal();
                $this->_baseCalculation();
                $this->_calculateRowTotal();
                unset($this->item['item_obj']);
                Mage::getModel('iwd_ordermanager/order_api_items')->updateOrderItems(array(
                    'items' => array($item_id => $this->item),
                    'order_id' => $orderId
                ));
                Mage::unregister('_singleton/iwd_ordermanager/api_logger');
                $response[$key]['status'] = 1;
                $response[$key]['message'] = 'Qty was updated';
            } catch (Exception $e) {
                $response[$key]['status'] = 0;
                $response[$key]['message'] = $e->getMessage();
            }
        }
        $this->log('updateItemQty api response ' . date('d-m-Y H:i:s') . ' ' . $id);
        $this->log($response);
        return array('result' => $response);
    }

    public function deleteItem(array $data)
    {
        $response = array();
        $id = md5(time());
        $this->log('deleteItem api request ' . date('d-m-Y H:i:s') . ' ' . $id);
        $this->log($data);
        foreach ($data as $key => $obj) {
            try {
                $response[$key]['order_id'] = $obj->order_id;
                $response[$key]['item_id'] = $obj->item_id;
                $params = array(
                    'order_id' => $obj->order_id,
                    'items' => array(
                        $obj->item_id => array('remove' => 1)
                    ),
                );
                Mage::getModel('iwd_ordermanager/order_api_items')->updateOrderItems($params);
                Mage::unregister('_singleton/iwd_ordermanager/api_logger');
                $response[$key]['status'] = 1;
                $response[$key]['message'] = 'Item was successfully deleted';
            } catch (Exception $e) {
                $response[$key]['status'] = 0;
                $response[$key]['message'] = $e->getMessage();
            }
        }
        $this->log('deleteItem api response ' . date('d-m-Y H:i:s') . ' ' . $id);
        $this->log($response);
        return array('result' => $response);
    }

    public function updateItemPrice(array $data)
    {
        $response = array();
        $id = md5(time());
        $this->log('UpdateItemPrice api request ' . date('d-m-Y H:i:s') . ' ' . $id);
        $this->log($data);
        foreach ($data as $key => $obj) {
            try {
                $item_id = $obj->item_id;
                $orderId = $obj->order_id;
                if (!isset($obj->type)) {
                    $type = 'excl_tax';
                } else {
                    $type = $obj->type;
                }
                $price = $obj->price;
                $response[$key]['order_id'] = $orderId;
                $response[$key]['item_id'] = $item_id;
                if (!is_numeric($price)) {
                    Mage::throwException('Error while updating price');
                }
                $order = Mage::getModel('sales/order')->load($orderId);
                $order_item = $order->getItemById($item_id);
                if (!$order_item) {
                    Mage::throwException('Invalid order item');
                }
                $this->_initOrderInputs($order_item);
                if ($type == 'incl_tax') {
                    $this->item['price_incl_tax'] = number_format($price, 2, '.', '');
                    $this->_calculatePriceInclTax();
                } else {
                    $this->item['price'] = $price;
                    $this->_calculatePriceExclTax();
                }
                $this->_calculateSubtotal();
                $this->_baseCalculation();
                $this->_calculateRowTotal();
                unset($this->item['item_obj']);
                Mage::getModel('iwd_ordermanager/order_api_items')->updateOrderItems(array(
                    'items' => array($item_id => $this->item),
                    'order_id' => $orderId
                ));
                Mage::unregister('_singleton/iwd_ordermanager/api_logger');
                $response[$key]['status'] = 1;
                $response[$key]['message'] = 'Price was updated';
            } catch (Exception $e) {
                $response[$key]['status'] = 0;
                $response[$key]['message'] = $e->getMessage();
            }
        }
        $this->log('UpdateItemPrice api response ' . date('d-m-Y H:i:s') . ' ' . $id);
        $this->log($response);
        return array('result' => $response);
    }

    public function addItem(array $data)
    {
        $response = array();
        $id = md5(time());
        $this->log('addItem api request ' . date('d-m-Y H:i:s') . ' ' . $id);
        $this->log($data);
        foreach ($data as $key => $obj) {
            try {
                $params = array();
                $product_id = $obj->product_id;
                $orderId = $obj->order_id;
                $qty = $obj->qty;
                $response[$key]['order_id'] = $orderId;
                $response[$key]['product_id'] = $product_id;
                $response[$key]['qty'] = $qty;
                $params[$product_id] = array(
                    'qty' => $qty,
                    'product' => $product_id
                );
                if (!empty($obj->options)) {
                    $response[$key]['options'] = $obj->options;
                    $params = $this->_prepareProductOptions($params, $obj->options);
                }
                $quote_items = Mage::getModel('iwd_ordermanager/order_api_converter')->createNewQuoteItems($orderId, $params);
                $items = array();
                $message = '';
                $block = Mage::getSingleton('core/layout')->createBlock('iwd_ordermanager/adminhtml_sales_order_items_form');
                foreach ($quote_items as $id => $quotItem) {
                    if (!$quotItem->getParentItem() && $this->_validateQuote($quotItem, $message)) {
                        $items[$quotItem->getId()]['description'] = $quotItem->getDescription();
                        $items[$quotItem->getId()]['original_price'] = number_format($quotItem->getBaseOriginalPrice(), 2, '.', '');
                        if ($quotItem->getProductType() == Mage_Catalog_Model_Product_Type::TYPE_BUNDLE) {
                            $items[$quotItem->getId()]['price'] = number_format($quotItem->getPrice(), 2, '.', '');
                        } else {
                            $items[$quotItem->getId()]['price'] = number_format($quotItem->getBasePrice(), 2, '.', '');
                        }
                        $items[$quotItem->getId()]['price_incl_tax'] = number_format($quotItem->getBasePriceInclTax(), 2, '.', '');
                        $items[$quotItem->getId()]['fact_qty'] = $quotItem->getQty() * 1;
                        $items[$quotItem->getId()]['subtotal'] = number_format($quotItem->getBaseRowTotal(), 2, '.', '');
                        $items[$quotItem->getId()]['subtotal_incl_tax'] = number_format($quotItem->getBaseRowTotalInclTax(), 2, '.', '');
                        $items[$quotItem->getId()]['row_total'] = number_format($block->getBaseRowTotal($quotItem), 2, '.', '');
                        $items[$quotItem->getId()]['discount_percent'] = number_format($quotItem->getDiscountPercent(), 2, '.', '');
                        $items[$quotItem->getId()]['discount_amount'] = number_format($quotItem->getBaseDiscountAmount(), 2, '.', '');
                        $items[$quotItem->getId()]['tax_percent'] = number_format($quotItem->getTaxPercent(), 2, '.', '');
                        $items[$quotItem->getId()]['tax_amount'] = number_format($quotItem->getBaseTaxAmount(), 2, '.', '');
                        $items[$quotItem->getId()]['hidden_tax_amount'] = number_format($quotItem->getBaseHiddenTaxAmount(), 2, '.', '');
                        $items[$quotItem->getId()]['weee_tax_applied_row_amount'] = number_format($quotItem->getBaseWeeeTaxAppliedRowAmount(), 2, '.', '');
                        $items[$quotItem->getId()]['product_id'] = $quotItem->getProductId();
                        $items[$quotItem->getId()]['quote_item'] = $quotItem->getId();
                    }
                }
                if ($items && !$message) {
                    $itemsParams = array(
                        'order_id' => $orderId,
                        'items' => $items
                    );
                    Mage::getModel('iwd_ordermanager/order_api_items')->updateOrderItems($itemsParams);
                    Mage::unregister('_singleton/iwd_ordermanager/api_logger');
                    if (Mage::registry('om_api_new_order_item_id')) {
                        $response[$key]['item_id'] = Mage::registry('om_api_new_order_item_id');
                    } else {
                        $response[$key]['item_id'] = 0;
                        Mage::throwException('Can\'t find new order item id');
                    }
                    Mage::unregister('om_api_new_order_item_id');
                    $response[$key]['status'] = 1;
                    $response[$key]['message'] = 'Item was successfully added';
                } else {
                    $response[$key]['status'] = 0;
                    $response[$key]['message'] = $message;
                }
            } catch (Exception $e) {
                $response[$key]['status'] = 0;
                $response[$key]['message'] = $e->getMessage();
            }
        }
        $this->log('addItem api response ' . date('d-m-Y H:i:s') . ' ' . $id);
        $this->log($response);
        return array('result' => $response);
    }
}