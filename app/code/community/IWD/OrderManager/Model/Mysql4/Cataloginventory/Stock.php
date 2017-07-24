<?php

class IWD_OrderManager_Model_Mysql4_Cataloginventory_Stock extends Mage_CatalogInventory_Model_Mysql4_Stock
{

    public function loadStoreIds(IWD_OrderManager_Model_Cataloginventory_Stock $object)
    {
        $stockId   = $object->getId();
        $storeIds = array();
        if ($stockId) {
            $storeIds = $this->lookupStoreIds($stockId);
        }
        $object->setStoreIds($storeIds);
    }

    /**
     * Get store ids to which specified item is assigned
     *
     * @param int $id
     * @return array
     */
    public function lookupStoreIds($id)
    {
        $tableStockStore = Mage::getSingleton('core/resource')->getTableName('iwd_cataloginventory_stock_store');

        return $this->_getReadAdapter()->fetchCol(
            $this->_getReadAdapter()->select()
                ->from($tableStockStore, 'store_id')
                ->where("stock_id = :id_field"),
            array(':id_field' => $id)
        );
    }

    public function _afterSave(Mage_Core_Model_Abstract $object)
    {
        $tableStockStore = Mage::getSingleton('core/resource')->getTableName('iwd_cataloginventory_stock_store');

        $deleteWhere = $this->_getWriteAdapter()->quoteInto('stock_id = ?', $object->getId());
        $this->_getWriteAdapter()->delete($tableStockStore, $deleteWhere);

        foreach ($object->getStoreIds() as $storeId) {
            $stockStoreData = array(
                'stock_id'   => $object->getId(),
                'store_id'  => $storeId
            );
            $this->_getWriteAdapter()->insert($tableStockStore, $stockStoreData);
        }
    }

}