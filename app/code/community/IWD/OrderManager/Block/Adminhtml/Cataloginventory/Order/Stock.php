<?php

class IWD_OrderManager_Block_Adminhtml_Cataloginventory_Order_Stock extends Mage_Adminhtml_Block_Widget
{
    protected $stocksForOrderItem = array();
    protected $assignedStocksForOrderItem = array();

    protected $_isOrderView;
    protected $_isReloadPage = false;

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('iwd/ordermanager/cataloginventory/order/stock.phtml');
    }

    public function getSelectionAttributes($item)
    {
        if ($item instanceof Mage_Sales_Model_Order_Item) {
            $options = $item->getProductOptions();
        } else {
            $options = $item->getOrderItem()->getProductOptions();
        }

        if (isset($options['bundle_selection_attributes'])) {
            return unserialize($options['bundle_selection_attributes']);
        }

        return null;
    }

    public function isChildCalculated($item)
    {
        if ($item) {
            if ($parentItem = $item->getParentItem()) {
                if ($options = $parentItem->getProductOptions()) {
                    return (isset($options['product_calculations']) && $options['product_calculations'] == Mage_Catalog_Model_Product_Type_Abstract::CALCULATE_CHILD);
                }
            } else {
                if ($options = $item->getProductOptions()) {
                    return !(isset($options['product_calculations']) && $options['product_calculations'] == Mage_Catalog_Model_Product_Type_Abstract::CALCULATE_CHILD);
                }
            }
        }

        return false;
    }

    public function canShowPriceInfo($item)
    {
        return (($item->getParentItem() && $this->isChildCalculated($item))
            || (!$item->getParentItem() && !$this->isChildCalculated($item)));
    }

    public function getOrderIncrementId()
    {
        return $this->getOrder()->getIncrementId();
    }

    protected function getOrder()
    {
        $orderId = $this->getData('order_id');
        return Mage::getModel('sales/order')->load($orderId);
    }

    protected function getStocksForOrderItem()
    {
        if (!empty($this->stocksForOrderItem)) {
            return $this->stocksForOrderItem;
        }

        $orderId = $this->getData('order_id');
        $coreResource = Mage::getSingleton('core/resource');
        $tableNameCataloginventoryStockItem = $coreResource->getTableName('cataloginventory_stock_item');

        $collection = Mage::getModel('sales/order_item')->getCollection()
            ->addFieldToSelect(array('order_id', 'product_id', 'qty_ordered'))
            ->addFieldToFilter('main_table.order_id', $orderId);

        $collection->getSelect()->joinLeft(array('stock_item' => $tableNameCataloginventoryStockItem),
            "stock_item.product_id = main_table.product_id",
            array(
                'stock_id', 'qty', 'is_in_stock'
            ));

        $data = Mage::getSingleton('core/resource')->getConnection('core_read')->fetchAll($collection->getSelect());

        foreach ($data as $item) {
            $itemId = $item['item_id'];
            $stockId = $item['stock_id'];
            $this->stocksForOrderItem[$itemId][$stockId] = array(
                'qty' => $item['qty'],
                'is_in_stock' => $item['is_in_stock'],
            );

            $this->stocksForOrderItem[$itemId]['qty_ordered'] = $item['qty_ordered'];
        }
        return $this->stocksForOrderItem;
    }

    protected function getAssignedForOrderItem()
    {
        if (!empty($this->assignedStocksForOrderItem)) {
            return $this->assignedStocksForOrderItem;
        }

        $orderId = $this->getData('order_id');
        $coreResource = Mage::getSingleton('core/resource');
        $tableNameIwdCataloginventoryStockOrderItem = $coreResource->getTableName('iwd_cataloginventory_stock_order_item');

        $collection = Mage::getModel('sales/order_item')->getCollection()
            ->addFieldToSelect(array('order_id'))
            ->addFieldToFilter('main_table.order_id', $orderId);

        $collection->getSelect()->joinLeft(array('stock_order_item' => $tableNameIwdCataloginventoryStockOrderItem),
            "main_table.item_id = stock_order_item.order_item_id",
            array(
                'stock_id', 'qty_stock_assigned'
            ));

        $data = Mage::getSingleton('core/resource')->getConnection('core_read')->fetchAll($collection->getSelect());

        foreach ($data as $item) {
            $itemId = $item['item_id'];
            $stockId = $item['stock_id'];

            $this->assignedStocksForOrderItem[$itemId][$stockId] = array(
                'qty_stock_assigned' => $item['qty_stock_assigned'],
            );
        }
        return $this->assignedStocksForOrderItem;
    }

    protected function getOrderedItems()
    {
        return $this->getOrder()->getAllVisibleItems();
    }

    protected function getStockItems()
    {
        return Mage::getModel('cataloginventory/stock')->getCollection();
    }

    protected function getStocks()
    {
        return Mage::getModel('cataloginventory/stock')->getCollection()
            ->addFieldToFilter('stock_id', array('neq' => Mage_CatalogInventory_Model_Stock::DEFAULT_STOCK_ID));
    }

    public function getStocksForOrderItemValue($orderItem, $stock, $index)
    {
        $orderItemId = $orderItem->getItemId();
        $stockId = $stock->getStockId();
        $stock = $this->getStocksForOrderItem();

        if (isset($stock[$orderItemId][$stockId][$index])
            && !empty($stock[$orderItemId][$stockId][$index])) {
            return $stock[$orderItemId][$stockId][$index];
        }

        if (isset($stock[$orderItemId][$index])
            && !empty($stock[$orderItemId][$index])) {
            return $stock[$orderItemId][$index];
        }

        return 0;
    }

    public function getAssignedStocksForOrderItemValue($orderItem, $stock, $index)
    {
        $orderItemId = $orderItem->getItemId();
        $stockId = $stock->getStockId();
        $stock = $this->getAssignedForOrderItem();

        if (isset($stock[$orderItemId][$stockId][$index])
            && !empty($stock[$orderItemId][$stockId][$index])) {
            return $stock[$orderItemId][$stockId][$index];
        }

        return 0;
    }

    /**
     * @return mixed
     */
    public function getIsOrderView()
    {
        return $this->_isOrderView;
    }

    /**
     * @param $isOrderGrid
     * @return $this
     */
    public function setIsOrderView($isOrderGrid)
    {
        $this->_isOrderView = $isOrderGrid;
        return $this;
    }

    /**
     * @param $isReloadPage
     * @return $this
     */
    public function setReloadPage($isReloadPage)
    {
        $this->_isReloadPage = $isReloadPage;
        return $this;
    }

    /**
     * @return string
     */
    public function getReloadPage()
    {
        return $this->_isReloadPage ? '1' : '0';
    }
}