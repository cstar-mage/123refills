<?php

/**
 * @package     BlueAcorn\Reporting
 * @version     1.1
 * @author      Magento, Inc. <eeadmin@magentocommerce.com>
 * @copyright   Copyright © 2014 Magento, Inc.
 */
class BlueAcorn_NewRelicReporting_Model_Cron
{
    /**
     * Flag for stopping cron from running more than once if multiple have been queued by Mage cron
     * @var bool
     */
    static $HAS_RUN = false;

    /**
     * Fires the event to report the system modules.
     */
    protected function _reportSystemModules()
    {
        Mage::dispatchEvent(
            'reporting_system_module_data',
            array('module_data' => Mage::helper('blueacorn_newrelicreporting/module')->getModuleData())
        );
    }

    /**
     * Fires the event to report the Catalog Product Count
     */
    protected function _reportCatalogProductsCount()
    {
        Mage::dispatchEvent(
            'reporting_catalog_products_count',
            array('product_count' => Mage::helper('blueacorn_newrelicreporting')->getAllProductsCount())
        );
    }

    /**
     * Fires the event to report the Catalog Product Configurable Count
     */
    protected function _reportCatalogProductConfigurableCount()
    {
        Mage::dispatchEvent(
            'reporting_catalog_products_configurable_count',
            array('configurable_count' => Mage::helper('blueacorn_newrelicreporting')->getConfigurableCount())
        );
    }

    /**
     * Fires the event to report the Number of Active Products
     */
    protected function _reportCatalogProductsActive()
    {
        Mage::dispatchEvent(
            'reporting_catalog_products_active',
            array('active_products_count' => Mage::helper('blueacorn_newrelicreporting')->getActiveCatalogSize())
        );
    }

    /**
     * Fires the event to report the Catalog Category Count
     */
    protected function _reportCatalogCategoryCount()
    {
        Mage::dispatchEvent(
            'reporting_catalog_category_count',
            array('category_count' => Mage::helper('blueacorn_newrelicreporting')->getCategoryCount())
        );
    }

    /**
     * Fires the event to report the Website Count
     */
    protected function _reportWebsiteCount()
    {
        Mage::dispatchEvent(
            'reporting_website_count', array('website_count' => Mage::helper('blueacorn_newrelicreporting')->getWebsiteCount())
        );
    }

    /**
     * Fires the event to report the Store View Count
     */
    protected function _reportStoreViewsCount()
    {
        Mage::dispatchEvent(
            'reporting_store_views_count',
            array('store_views_count' => Mage::helper('blueacorn_newrelicreporting')->getStoreViewsCount())
        );
    }

    /**
     * Fires the event to report the Concurrent Users
     */
    protected function _reportConcurrentUsers()
    {
        Mage::dispatchEvent(
            'reporting_user_concurrent_users',
            array('concurrent_users_count' => Mage::helper('blueacorn_newrelicreporting')->getConcurrentUsers())
        );
    }

    /**
     * Fires the event to report the Customer Count
     */
    protected function _reportCustomerCount()
    {
        Mage::dispatchEvent(
            'reporting_customer_count',
            array('customer_count' => Mage::helper('blueacorn_newrelicreporting')->getCustomerCount())
        );
    }

    /**
     * The method run by the cron that fires all required events.
     */
    public function runCron()
    {
        if (!self::$HAS_RUN && Mage::helper('blueacorn_newrelicreporting/config')->isCronEnabled()) {
            $this->_reportCatalogCategoryCount();
            $this->_reportCatalogProductConfigurableCount();
            $this->_reportCatalogProductsActive();
            $this->_reportCatalogProductsCount();
            $this->_reportSystemModules();
            $this->_reportWebsiteCount();
            $this->_reportStoreViewsCount();
            $this->_reportCustomerCount();

            Mage::dispatchEvent('reporting_cron_after');

            self::$HAS_RUN = true;
        }
    }
}