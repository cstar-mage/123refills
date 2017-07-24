<?php

class IWD_OrderManager_Model_Cataloginventory_Stock_Order_Item extends Mage_Core_Model_Abstract
{
    protected $stockItems = array();
    protected $orderItemsAssignedQty = array();
    protected $stockItemsQty = array();
    protected $orderAssignedQty = 0;

    public function updateAssignedStockOrderItems($items, $orderId)
    {
        $this->prepareStockOrderItems($items, $orderId);

        $this->updateStockOrderItems($items);
        $this->updateStockOrder($orderId);

        return $this->orderAssignedQty;
    }

    protected function updateStockOrder($orderId)
    {
        Mage::getModel('iwd_ordermanager/cataloginventory_stock_order')
            ->updateStockOrder($orderId, $this->orderAssignedQty);
    }

    public function updateStocks($params)
    {
        $stockItems = Mage::getModel('cataloginventory/stock_item')->getCollection()
            ->addFieldToFilter('product_id', array('in' => array_keys($params)));

        foreach ($stockItems as $stockItem) {
            $stockId = $stockItem->getData('stock_id');
            $productId = $stockItem->getProductId();

            if (isset($params[$productId][$stockId])) {
                $qty = $params[$productId][$stockId] * 1.0 - $stockItem->getQty() * 1.0;
                if ($qty > 0) {
                    $stockItem->addQty($qty)->save();
                }
                if ($qty < 0) {
                    $qty = abs($qty);
                    $stockItem->subtractQty($qty)->save();
                }
            }
        }
    }

    protected function prepareStockOrderItems($items, $orderId)
    {
        $this->orderAssignedQty = 0;
        $this->orderItemsAssignedQty = array();

        foreach ($items as $orderItemId => $stocks) {
            foreach ($stocks as $stockId => $qty) {
                if (!empty($qty)) {
                    $this->stockItems[] = array(
                        'stock_id' => $stockId,
                        'order_id' => $orderId,
                        'order_item_id' => $orderItemId,
                        'qty_stock_assigned' => $qty
                    );
                }

                $this->stockItemsQty[$orderItemId] = $qty;

                if (isset($this->orderItemsAssignedQty[$orderItemId])) {
                    $this->orderItemsAssignedQty[$orderItemId] += $qty;
                } else {
                    $this->orderItemsAssignedQty[$orderItemId] = $qty;
                }

                $this->orderAssignedQty += $qty;
            }
        }

        return $this->stockItems;
    }

    protected function updateStockOrderItems($items)
    {
        $coreResource = Mage::getSingleton('core/resource');
        $writeAdapter = $coreResource->getConnection('core_write');
        $table = $coreResource->getTableName('iwd_cataloginventory_stock_order_item');

        $where = $writeAdapter->quoteInto('order_item_id IN (?)', array_keys($items));
        $writeAdapter->delete($table, $where);

        foreach ($this->stockItems as $item) {
            $writeAdapter->insert($table, $item);
        }
    }

    protected function orderedProducts($items)
    {
        $products = Mage::getModel('sales/order_item')->getCollection()
            ->addFieldToSelect('product_id')
            ->addFieldToFilter('product_id', array('in' => array_keys($items)));

        $productIds = array();
        foreach ($products as $product) {
            $productIds[$product->getItemId()] = $product->getProductId();
        }

        return $productIds;
    }

    public function getStocksForOrder($orderId)
    {
        $coreResource = Mage::getSingleton('core/resource');
        $readAdapter = $coreResource->getConnection('core_read');
        $table = $coreResource->getTableName('iwd_cataloginventory_stock_order_item');
        $tableStock = $coreResource->getTableName('cataloginventory_stock');

        $select = $readAdapter->select()
            ->from($table)
            ->where('order_id=?', $orderId)
            ->joinLeft($tableStock,
                "{$table}.stock_id = {$tableStock}.stock_id",
                array('stock_name')
            )->group("{$table}.stock_id");

        $data = $readAdapter->fetchAll($select);

        $stocks = array();
        foreach ($data as $item) {
            $stocks[$item["stock_id"]] = $item["stock_name"];
        }

        return $stocks;
    }

    public function getStocksForOrderItem($orderItemId)
    {
        $coreResource = Mage::getSingleton('core/resource');
        $readAdapter = $coreResource->getConnection('core_read');
        $table = $coreResource->getTableName('iwd_cataloginventory_stock_order_item');
        $orderItemsTable = $coreResource->getTableName('sales_flat_order_item');

        $select = $readAdapter->select()
            ->from($table)
            ->joinLeft($orderItemsTable,
                "{$table}.order_item_id = {$orderItemsTable}.item_id",
                array('product_id')
            )
            ->where('order_item_id=?', $orderItemId);

        return $data = $readAdapter->fetchAll($select);
    }

    public function getOrderItemQtyAssigned($orderItemId)
    {
        $coreResource = Mage::getSingleton('core/resource');
        $readAdapter = $coreResource->getConnection('core_read');
        $table = $coreResource->getTableName('iwd_cataloginventory_stock_order_item');

        $select = $readAdapter->select()
            ->from(
                $table,
                array('qty_assigned' => new Zend_Db_Expr("sum({$table}.qty_stock_assigned)"))
            )
            ->where('order_item_id=?', $orderItemId)
            ->group("{$table}.order_item_id");

        $data = $readAdapter->fetchRow($select);

        return isset($data['qty_assigned']) ? $data['qty_assigned'] : 0;
    }

    public function getOrderQtyAssigned($orderId)
    {
        $coreResource = Mage::getSingleton('core/resource');
        $readAdapter = $coreResource->getConnection('core_read');
        $table = $coreResource->getTableName('iwd_cataloginventory_stock_order_item');

        $select = $readAdapter->select()
            ->from(
                $table,
                array('qty_assigned' => new Zend_Db_Expr("sum({$table}.qty_stock_assigned)"))
            )
            ->where('order_id=?', $orderId)
            ->group("{$table}.order_id");

        $data = $readAdapter->fetchRow($select);

        return isset($data['qty_assigned']) ? $data['qty_assigned'] : 0;
    }

    /**
     * @param $orderItem
     * @param $qty
     * @return bool
     */
    public function updateStockOrderItemIfOneStockAssignedOnly($orderItem, $qty)
    {
        if (!Mage::helper('iwd_ordermanager')->isMultiInventoryEnable() || $qty == 0) {
            return false;
        }

        if ($orderItem->getParentItem() && $orderItem->getParentItem()->getProductType() == Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE) {
            return false;
        }

        if ($orderItem->getProductType() == Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE) {
            $childrenItems = $orderItem->getChildrenItems();
            $simpleOrderItem = $childrenItems[0];
        } else {
            $simpleOrderItem = $orderItem;
        }

        $orderItemId = $simpleOrderItem->getItemId();
        $coreResource = Mage::getSingleton('core/resource');
        $readAdapter = $coreResource->getConnection('core_read');
        $writeAdapter = $coreResource->getConnection('core_write');
        $table = $coreResource->getTableName('iwd_cataloginventory_stock_order_item');

        $select = $readAdapter->select()
            ->from($table, array('qty_stock_assigned', 'stock_id'))
            ->where('order_item_id=?', $orderItemId);
        $stmt = $readAdapter->query($select);

        if ($stmt->rowCount() == 1) {
            $data = $readAdapter->fetchRow($select);
            $stockItem = Mage::getModel('cataloginventory/stock_item')->getCollection()
                ->addFieldToFilter('product_id', $simpleOrderItem->getProductId())
                ->addFieldToFilter('stock_id', $data['stock_id'])
                ->getFirstItem();

            $stockItem->setQty($stockItem->getQty() - $qty)->save();

            $qtyAssigned = $data['qty_stock_assigned'];
            $qtyOrdered = $orderItem->getQtyOrdered() - $orderItem->getQtyRefunded() - $orderItem->getQtyCanceled();
            $qtyNotAssigned = $qtyOrdered - $qtyAssigned;

            if ($qty < 0) {
                if ($qtyNotAssigned + $qty > 0) {
                    return false;
                }

                if ($qtyAssigned + $qty < 0) {
                    $where = $writeAdapter->quoteInto('order_item_id IN (?)', $orderItemId);
                    $writeAdapter->delete($table, $where);
                } else {
                    $qtyNotAssigned = $qtyNotAssigned < 0 ? 0 : $qtyNotAssigned;
                    $row = array('qty_stock_assigned' => $qtyAssigned + $qtyNotAssigned + $qty);
                    $where = $writeAdapter->quoteInto('order_item_id=?', $orderItemId);
                    $writeAdapter->update($table, $row, $where);
                }

            } else {
                $row = array('qty_stock_assigned' => $qtyAssigned + $qty);
                $where = $writeAdapter->quoteInto('order_item_id=?', $orderItemId);
                $writeAdapter->update($table, $row, $where);
            }
            return false;
        }

        return true;
    }

    /**
     * @param $orderItem
     * @return void
     */
    public function updateStockAfterRemoveItem($orderItem)
    {
        if (!Mage::helper('iwd_ordermanager')->isMultiInventoryEnable()) {
            return;
        }

        $coreResource = Mage::getSingleton('core/resource');
        $readAdapter = $coreResource->getConnection('core_read');
        $table = $coreResource->getTableName('iwd_cataloginventory_stock_order_item');

        $select = $readAdapter->select()
            ->from($table, array('qty_stock_assigned', 'stock_id'))
            ->where('order_item_id=?', $orderItem->getItemId());

        $data = $readAdapter->fetchAll($select);
        foreach ($data as $item) {
            $stockItem = Mage::getModel('cataloginventory/stock_item')->getCollection()
                ->addFieldToFilter('product_id', $orderItem->getProductId())
                ->addFieldToFilter('stock_id', $item['stock_id'])
                ->getFirstItem();

            $stockItem->setQty($stockItem->getQty() + $item['qty_stock_assigned'])->save();
        }
    }
}
