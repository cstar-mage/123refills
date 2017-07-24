<?php

class IWD_OrderManager_Block_Adminhtml_Sales_Order_Grid_Renderer_Inventory extends IWD_OrderManager_Block_Adminhtml_Sales_Order_Grid_Renderer_Abstract
{
    protected $_orderId;
    protected $_itemId;
    protected $isStockAssigned;
    protected $qtyAssigned;
    protected $qtyOrdered;

    protected function Export()
    {
        $this->_getValue($this->row);
    }

    protected function Grid()
    {
        $this->_orderId = $this->row["entity_id"];
        $this->_itemId = 0;
        $this->qtyAssigned = $this->row["stock_qty_assigned"];
        $this->qtyOrdered = $this->row["stock_qty_ordered"];
        $this->isStockAssigned = $this->row["stock_assigned"];

        return $this->getStockMessage();
    }

    public function getStockMessageForOrder($orderId, $isOrderViewPage)
    {
        if ($isOrderViewPage) {
            return $this->getStockMessageForOrderView($orderId);
        } else {
            return $this->getStockMessageForOrderGrid($orderId);
        }
    }

    protected function getStockMessageForOrderView($orderId)
    {
        $items = array();
        $orderItems = Mage::getModel('sales/order')->load($orderId)->getAllItems();

        foreach ($orderItems as $orderItem) {
            $items[$orderItem->getItemId()] = $this->getStockMessageForOrderItem($orderItem);
        }

        return $items;
    }

    protected function getStockMessageForOrderGrid($orderId)
    {
        $row = Mage::getModel('iwd_ordermanager/cataloginventory_stock_order')->getStockOrderData($orderId);

        $this->_orderId = $row["order_id"];
        $this->_itemId = 0;
        $this->qtyAssigned = $row["qty_assigned"];
        $this->qtyOrdered = $row["qty_ordered"];
        $this->isStockAssigned = $row["assigned"];

        return $this->getStockMessage();
    }

    protected function getStockMessage($jsAction = "IWD.OrderManager.Stock.showAssignStockForm")
    {
        $id = $this->_itemId ? $this->_itemId : $this->_orderId;
        $notAssigned = $this->qtyOrdered - $this->qtyAssigned;

        if (is_null($this->isStockAssigned)) {
            $message = $this->getMessage("Order Placed Before Multiple Sources Created", 'fa-ban', $this->getOrderedQty());
        } elseif ($this->qtyOrdered == 0) {
            if ($this->qtyAssigned == 0) {
                return '<div>NA</div>';
            }
            $message = $this->getMessage("Some Items Were Refunded After Assign Stock", 'fa-arrow-down', $notAssigned);
        } else {
            $message = ($this->qtyAssigned != 0) ? $this->getMessage("Stock Source Assigned", 'fa-check', $this->qtyAssigned) : '';

            if (!empty($notAssigned)) {
                $message .= ($notAssigned > 0)
                    ? $this->getMessage("Stock Needs Source Assignment", 'fa-times', $notAssigned)
                    : $this->getMessage("Some Items Were Refunded After Assign Stock", 'fa-arrow-down', $notAssigned);
            }
        }

        return sprintf("<div class='inventory_order_item_%s'><a class='iwd-om-inventory' href='javascript:void(0)' onclick='%s'>%s</a></div>",
            $id,
            "{$jsAction}({$this->_orderId});",
            $message
        );
    }

    protected function getOrderedQty()
    {
        $order = Mage::getModel('sales/order')->loadByIncrementId($this->row['increment_id']);
        $items = $order->getAllVisibleItems();

        $qtyOrdered = 0;
        foreach ($items as $item) {
            $qtyOrdered += $item['qty_ordered'];
        }

        return $qtyOrdered;
    }

    protected function getMessage($title, $class, $qty)
    {
        $title = Mage::helper('iwd_ordermanager')->__($title);
        return '<span class="iwd_om_stock_tooltip2" title=""><i class="fa marker ' . $class . '" aria-hidden="true"></i>' . $qty * 1 . '<span class="hint"><i class="fa marker ' . $class . '" aria-hidden="true"></i>' . $title . '</span></span><br/>';
    }

    /**
     * @param Mage_Sales_Model_Order_Item $orderItem
     * @return string
     */
    public function getStockMessageForOrderItem($orderItem)
    {
        if ($orderItem->getProductType() == Mage_Catalog_Model_Product_Type::TYPE_BUNDLE) {
            return '';
        }

        if ($orderItem->getParentItemId() && $orderItem->getParentItem()->getProductType() == Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE) {
            $orderItem = $orderItem->getParentItem();
            $this->qtyOrdered = $orderItem->getQtyOrdered() - $orderItem->getQtyRefunded() - $orderItem->getQtyCanceled();
        }

        if ($orderItem->getProductType() == Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE) {
            $this->qtyOrdered = $orderItem->getQtyOrdered() - $orderItem->getQtyRefunded() - $orderItem->getQtyCanceled();
            $childrenItems = $orderItem->getChildrenItems();
            $orderItem = $childrenItems [0];
        } else {
            if ($orderItem->getIsVirtual()) {
                $this->qtyOrdered = 0;
            } else {
                $this->qtyOrdered = $orderItem->getQtyOrdered() - $orderItem->getQtyRefunded() - $orderItem->getQtyCanceled();
            }
        }

        $this->_itemId = $orderItem->getItemId();
        $this->_orderId = $orderItem->getOrderId();

        $row = Mage::getModel('iwd_ordermanager/cataloginventory_stock_order')->getStockOrderData($this->_orderId);
        $this->isStockAssigned = $row["assigned"];

        $this->qtyAssigned = Mage::getModel('iwd_ordermanager/cataloginventory_stock_order_item')
            ->getOrderItemQtyAssigned($this->_itemId);

        return $this->getStockMessage("IWD.OrderManager.Stock.Order.showAssignStockForm");
    }
}