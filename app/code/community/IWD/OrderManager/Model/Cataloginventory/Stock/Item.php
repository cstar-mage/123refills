<?php

/**
 * Class IWD_OrderManager_Model_Cataloginventory_Stock_Item
 */
class IWD_OrderManager_Model_Cataloginventory_Stock_Item extends Mage_CatalogInventory_Model_Stock_Item
{
    /**
     * @return int
     */
    public function getStockId()
    {
        return parent::getStockId();
    }

    /**
     * @param Mage_Catalog_Model_Entity_Product_Collection $productCollection
     * @return $this
     */
    public function addCatalogInventoryToProductCollection($productCollection)
    {
        $this->_getResource()->addCatalogInventoryToProductCollection($productCollection);
        $productCollection->getSelect()->group('e.entity_id');
        return $this;
    }
}