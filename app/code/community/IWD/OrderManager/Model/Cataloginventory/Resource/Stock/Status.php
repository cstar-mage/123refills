<?php

class IWD_OrderManager_Model_Cataloginventory_Resource_Stock_Status extends Mage_CatalogInventory_Model_Resource_Stock_Status
{
    /**
     * Add stock status limitation to catalog product price index select object
     *
     * @param Varien_Db_Select $select
     * @param string|Zend_Db_Expr $entityField
     * @param string|Zend_Db_Expr $websiteField
     * @return Mage_CatalogInventory_Model_Resource_Stock_Status
     */
    public function prepareCatalogProductIndexSelect(Varien_Db_Select $select, $entityField, $websiteField)
    {
        //reason for rewrite
        $select->distinct(true);

        $select->join(
            array('ciss' => $this->getMainTable()),
            "ciss.product_id = {$entityField} AND ciss.website_id = {$websiteField}",
            array()
        );
        $select->where('ciss.stock_status = ?', Mage_CatalogInventory_Model_Stock_Status::STATUS_IN_STOCK);

        return $this;
    }
}