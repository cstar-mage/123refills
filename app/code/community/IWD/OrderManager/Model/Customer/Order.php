<?php

class IWD_OrderManager_Model_Customer_Order extends Mage_Sales_Model_Order
{
    const XML_PATH_CUSTOMER_ORDERS_RESENT_ORDER_GRID_COLUMN = 'iwd_ordermanager/customer_orders/resent_orders_grid_columns';
    const XML_PATH_CUSTOMER_ORDERS_ORDER_GRID_COLUMN = 'iwd_ordermanager/customer_orders/orders_grid_columns';

    public function getSelectedColumnsForRecentOrderGrid()
    {
        $selectedColumns = Mage::getStoreConfig(self::XML_PATH_CUSTOMER_ORDERS_RESENT_ORDER_GRID_COLUMN);
        return explode(",", $selectedColumns);
    }

    public function getSelectedColumnsForOrderGrid()
    {
        $selectedColumns = Mage::getStoreConfig(self::XML_PATH_CUSTOMER_ORDERS_ORDER_GRID_COLUMN);
        return explode(",", $selectedColumns);
    }

    public function getRecentOrdersCollectionForCurrentCustomer()
    {
        $selectedColumns = $this->getSelectedColumnsForRecentOrderGrid();

        $collection = Mage::getResourceModel('sales/order_grid_collection')
            ->addFieldToFilter('customer_id', Mage::registry('current_customer')->getId());

        $collection->addFieldToSelect(array('status', 'store_id', 'store_name', 'customer_id',
                'base_grand_total', 'base_total_paid', 'grand_total', 'total_paid', 'increment_id', 'base_currency_code',
                'order_currency_code', 'created_at', 'updated_at')
        );

        return Mage::getModel('iwd_ordermanager/order_grid')->getOrdersCollection($selectedColumns, $collection);
    }

    public function getOrdersCollectionForCurrentCustomer()
    {
        $selectedColumns = $this->getSelectedColumnsForOrderGrid();
        $selectedColumns[] = 'archived';

        $collection = Mage::getResourceModel('sales/order_collection')
            ->addFieldToFilter('customer_id', Mage::registry('current_customer')->getId());

        $collection->addFieldToSelect(
            array('status', 'store_id', 'store_name', 'customer_id',
            'base_grand_total', 'base_total_paid', 'grand_total', 'total_paid', 'increment_id',
            'base_currency_code', 'order_currency_code', 'created_at', 'updated_at')
        );

        return Mage::getModel('iwd_ordermanager/order_grid')->getOrdersCollection($selectedColumns, $collection);
    }
}