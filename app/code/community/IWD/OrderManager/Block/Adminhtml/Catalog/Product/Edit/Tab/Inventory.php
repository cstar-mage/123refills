<?php

class IWD_OrderManager_Block_Adminhtml_Catalog_Product_Edit_Tab_Inventory extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Inventory
{
    public function __construct()
    {
        parent::__construct();

        if (Mage::helper('iwd_ordermanager')->isMultiInventoryEnable()) {
            $this->setTemplate('iwd/ordermanager/catalog/product/tab/inventory.phtml');
        }
    }

    /**
     * @return bool
     */
    public function isWebsiteInventory()
    {
        return Mage::app()->getRequest()->getParam('store', null)
            && Mage::helper('iwd_ordermanager')->isMultiInventoryEnable();
    }

    /**
     * @return Mage_CatalogInventory_Model_Stock []
     */
    public function getStocks()
    {
        return Mage::getModel('cataloginventory/stock')->getCollection()
            ->setOrder('stock_id', 'ASC');
    }

    /**
     * @param $stockId
     * @return Mage_CatalogInventory_Model_Stock_Item
     */
    public function getStockItemForProduct($stockId)
    {
        $stockItem = Mage::getModel('cataloginventory/stock_item')->getCollection()
            ->addFieldToFilter('stock_id', $stockId)
            ->addFieldToFilter('product_id', $this->getProduct()->getId());

        return $stockItem->getFirstItem();
    }


    public function getDefaultStockItem()
    {
        return $this->getStockItemForProduct(Mage_CatalogInventory_Model_Stock::DEFAULT_STOCK_ID);
    }

    /**
     * @param Mage_CatalogInventory_Model_Stock_Item $stockItem
     * @param $field
     * @return mixed
     */
    public function getStockItemValue($stockItem, $field)
    {
        if ($stockItem->getId()) {
            return $stockItem->getDataUsingMethod($field);
        }

        return Mage::getStoreConfig(Mage_CatalogInventory_Model_Stock_Item::XML_PATH_ITEM . $field);
    }
}
