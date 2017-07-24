<?php

/**
 * @package     BlueAcorn\Reporting
 * @version     1.1
 * @author      Magento, Inc. <eeadmin@magentocommerce.com>
 * @copyright   Copyright © 2014 Magento, Inc.
 */

class BlueAcorn_NewRelicReporting_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Get customer count
     * @return int
     */
    public function getCustomerCount()
    {
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        $tableName = $resource->getTableName('customer/entity');
        $select = $readConnection->select()
            ->from($tableName, 'count(*)');

        $count = $readConnection->fetchOne($select);

        return (int)$count;
    }

    /**
     * Get count of all products, no conditions
     * @return int
     */
    public function getAllProductsCount()
    {
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        $tableName = $resource->getTableName('catalog/product');
        $select = $readConnection->select()
            ->from($tableName, 'count(*)');

        $count = $readConnection->fetchOne($select);
        return (int)$count;
    }

    /**
     * Get count of configurable products
     * @return int
     */
    public function getConfigurableCount()
    {
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        $tableName = $resource->getTableName('catalog/product');
        $typeId = Mage_Catalog_Model_Product_Type_Configurable::TYPE_CODE;


        $select = $readConnection->select()
            ->from($tableName, 'count(*)')->where('type_id = :type_id');

        $count = $readConnection->fetchOne($select, array(':type_id' => $typeId));

        return (int)$count;
    }

    /**
     * Get count of products which are active
     * @return int
     */
    public function getActiveCatalogSize()
    {
        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addFieldToFilter('status', array('eq' => Mage_Catalog_Model_Product_Status::STATUS_ENABLED));

        $countSQL = $collection->getSelectCountSql();
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        $count = $readConnection->fetchOne($countSQL);
        return (int)$count;
    }

    /**
     * Get count of categories, minus one which is the root category
     * @return int
     */
    public function getCategoryCount()
    {
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        $tableName = $resource->getTableName('catalog/category');
        $select = $readConnection->select()
            ->from($tableName, 'count(*)');

        $count = $readConnection->fetchOne($select)
            - 1; //Subtract one to account for the base category.
        return (int)$count;
    }

    /**
     * Get count of websites, minus one to exclude admin website
     * @return int
     */
    public function getWebsiteCount()
    {
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        $tableName = $resource->getTableName('core/website');
        $select = $readConnection->select()
            ->from($tableName, 'count(*)');

        $count = $readConnection->fetchOne($select)
            - 1; //Subtract 1 to account for Admin which is a website.
        return (int)$count;
    }

    /**
     * Get count of store views
     * @return int
     */
    public function getStoreViewsCount()
    {
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        $tableName = $resource->getTableName('core/store');
        $select = $readConnection->select()
            ->from($tableName, 'count(*)');

        $count = $readConnection->fetchOne($select)
            - 1; //Subtract 1 to account for Admin which is a store.
        return (int)$count;
    }
}