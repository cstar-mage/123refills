<?php

class IWD_OrderManager_Model_Cataloginventory_Stock_Order extends Mage_Core_Model_Abstract
{
    /**
     * @param $orderId
     * @param int $qtyAssigned
     * @param null $qtyOrdered
     */
    public function updateStockOrder($orderId, $qtyAssigned=0, $qtyOrdered=null)
    {
        $coreResource = Mage::getSingleton('core/resource');
        $writeAdapter = $coreResource->getConnection('core_write');
        $table = $coreResource->getTableName('iwd_cataloginventory_stock_order');

        $where = $writeAdapter->quoteInto('order_id IN (?)', $orderId);
        $writeAdapter->delete($table, $where);

        $qtyOrdered = is_null($qtyOrdered) ? $this->getQtyOrdered($orderId) : $qtyOrdered;
        $assigned = ($qtyAssigned == $qtyOrdered) ? ($qtyAssigned == 0 && $qtyOrdered == 0) ? -1 : 1 : 0;

        $row = array (
            'order_id' => $orderId,
            'qty_assigned' => $qtyAssigned,
            'qty_ordered' => $qtyOrdered,
            'assigned' => $assigned
        );

        $writeAdapter->insert($table, $row);
    }

    /**
     * @param $orderId
     * @return int
     */
    public function getQtyOrdered($orderId)
    {
        $qtyOrdered = 0;

        $order = Mage::getModel('sales/order')->load($orderId);

        $items = $order->getAllItems();
        foreach ($items as $item) {
            $type = $item->getProductType();
            $isComplex = in_array($type, array(Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE, Mage_Catalog_Model_Product_Type::TYPE_BUNDLE));
            if (!$item->getIsVirtual() && !$isComplex) {
                $qtyOrdered += $item['qty_ordered'] - $item['qty_refunded'] - $item['qty_canceled'];
            }
        }

        return $qtyOrdered;
    }

    public function getQtyAssigned($orderId)
    {
        $coreResource = Mage::getSingleton('core/resource');
        $readAdapter = $coreResource->getConnection('core_read');
        $table = $coreResource->getTableName('iwd_cataloginventory_stock_order');

        $select = $readAdapter->select()
            ->from($table, array('qty_assigned'))
            ->where('order_id=?', $orderId);

        $data = $readAdapter->fetchRow($select);

        return isset($data['qty_assigned']) ? $data['qty_assigned'] : 0;
    }

    /**
     * @param $orderId
     * @return mixed
     */
    public function getStockOrderData($orderId)
    {
        $coreResource = Mage::getSingleton('core/resource');
        $readAdapter = $coreResource->getConnection('core_read');
        $table = $coreResource->getTableName('iwd_cataloginventory_stock_order');

        $select = $readAdapter->select()
            ->from($table)
            ->where('order_id=?', $orderId);

        return $data = $readAdapter->fetchRow($select);
    }
}