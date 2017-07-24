<?php

/**
 * @package     BlueAcorn\Reporting
 * @version     1.1
 * @author      Magento, Inc. <eeadmin@magentocommerce.com>
 * @copyright   Copyright © 2014 Magento, Inc.
 */
class BlueAcorn_NewRelicReporting_Model_NewRelic_Observer
{
    /**#@+
     * Names of parameters to be sent to Insights
     */
    const ORDER_ITEMS = 'LineItemCount';
    const ORDER_VALUE = 'OrderValue';
    const ORDER_PLACED = 'Order';
    const ADMIN_USER_ID = 'AdminId';
    const ADMIN_USER = 'AdminUser';
    const ADMIN_NAME = 'AdminName';
    const CUSTOMER_ID = 'CustomerId';
    const CUSTOMER_NAME = 'CustomerName';
    const CUSTOMER_COUNT = 'CustomerCount';
    const STORE = 'StoreName';
    const STORE_VIEW_COUNT = 'StoreViewCount';
    const WEBSITE = 'WebsiteName';
    const WEBSITE_COUNT = 'WebsiteCount';
    const PRODUCT_CHANGE = 'AdminProductChange';
    const PRODUCT_COUNT = 'CatalogProductCount';
    const CONFIGURABLE_COUNT = 'CatalogProductConfigurableCount';
    const ACTIVE_COUNT = 'CatalogProductActiveCount';
    const CATEGORY_COUNT = 'CatalogCategoryCount';
    const MODULES_DISABLED = 'ModulesDisabled';
    const MODULES_ENABLED = 'ModulesEnabled';
    const MODULES_INSTALLED = 'ModulesInstalled';
    /**#@-*/

    /**#@+
     * Text flags for deployments
     */
    const INSTALLED = 'installed';
    const UNINSTALLED = 'uninstalled';
    const ENABLED = 'enabled';
    const DISABLED = 'disabled';
    /**#@-*/

    /**
     * Determines if API or direct call to New Relic via php module is used. Hard coded to be true as
     * there are issues with using php module with a custom New Relic event
     *
     * @var bool
     */
    protected $_useEventApi = true;

    /**
     * Parameters to be sent to Insights
     * @var array
     */
    protected $_customParameters = array();

    /**
     * Generic method to add custom parameters either through event API or PHP module's method
     *
     * @param array $data
     */
    public function setCustomParameters(array $data)
    {
        if ($this->_useEventApi) {
            $this->addCustomParametersApi($data);
        } else {
            $this->addCustomParameters($data);
        }
    }

    /**
     * Add custom New Relic parameters immediately to this transaction
     *
     * @param array $data
     */
    public function addCustomParameters(array $data)
    {
        foreach ($data as $key => $value) {
            newrelic_add_custom_parameter($key, $value);
        }
    }

    /**
     * Queue up custom parameters to send in API call to Insights Events
     *
     * @param array $data
     */
    public function addCustomParametersApi(array $data)
    {
        foreach ($data as $key => $value) {
            $this->_customParameters[$key] = $value;
        }
    }

    /**
     * Reporting for when system cache is flushed
     *
     */
    public function reportFlushSystemCache()
    {
        $session = Mage::getSingleton('admin/session');

        if ($this->_getEnabled() && $session->getUser()->getId()) {

            Mage::helper('blueacorn_newrelicreporting/deployments')->setDeployment(
                'Cache Flush', $session->getUser()->getUsername() . ' flushed the cache.', $session->getUser()->getUsername()
            );
        }
    }

    /**
     * Reporting for when an order is placed
     *
     * @param Varien_Event_Observer $observer
     */
    public function reportOrderPlaced($observer)
    {
        $order = $observer->getOrder();

        if ($this->_getEnabled()) {
            $itemCount = $order->getTotalItemCount();
            if (!is_numeric($itemCount) && empty($itemCount)) {
                $itemCount = $order->getTotalQtyOrdered();
            }
            newrelic_add_custom_parameter($this::ORDER_PLACED, 1);
            newrelic_add_custom_parameter($this::ORDER_ITEMS, $itemCount);
            newrelic_add_custom_parameter($this::ORDER_VALUE, $order->getQuoteBaseGrandTotal());
        }
    }

    /**
     * Adminhtml reporting for when product is updated
     *
     */
    public function reportProductUpdated()
    {
        if ($this->_getEnabled()) {
            newrelic_add_custom_parameter(self::PRODUCT_CHANGE, 'update');
        }
    }

    /**
     * Adminhtml reporting for when product is created
     *
     */
    public function reportProductCreated()
    {
        if ($this->_getEnabled()) {
            newrelic_add_custom_parameter(self::PRODUCT_CHANGE, 'create');
        }
    }

    /**
     * Adminhtml reporting for when product is deleted
     *
     */
    public function reportProductDeleted()
    {
        if ($this->_getEnabled()) {
            newrelic_add_custom_parameter(self::PRODUCT_CHANGE, 'delete');
        }
    }

    /**
     * Reports current module change status via deployment marker, and also total module counts to Insights
     *
     * @param Varien_Event_Observer $observer
     */
    public function reportModules($observer)
    {
        $moduleData = $observer->getModuleData();
        $moduleDataChanges = $moduleData['changes'];

        if ($this->_getEnabled()) {

            $enabledChangeArray = array();
            $disabledChangeArray = array();
            $installedChangeArray = array();
            $uninstalledChangeArray = array();

            //Create Arrays for deployment marker changes
            foreach($moduleDataChanges as $change){
                switch($change['type']){
                    case self::ENABLED:{
                        $enabledChangeArray[] = $change['name'] . '-' . $change['version'];
                        break;
                    }

                    case self::DISABLED:{
                        $disabledChangeArray[] = $change['name'] . '-' . $change['version'];
                        break;
                    }

                    case self::INSTALLED:{
                        $installedChangeArray[] = $change['name'] . '-' . $change['version'];
                        break;
                    }

                    case self::UNINSTALLED:{
                        $uninstalledChangeArray[] = $change['name'] . '-' . $change['version'];
                    }
                }
            }

            //Report Enabled Count
            $this->setCustomParameters(array(self::MODULES_ENABLED => $moduleData[self::ENABLED]));

            //If changes exist -> send deployment marker
            if(count($enabledChangeArray) > 0){
                foreach($enabledChangeArray as $change){
                    Mage::helper('blueacorn_newrelicreporting/deployments')->setDeployment(
                        'Modules Enabled', $change
                    );
                }
            }

            //Report Disabled Count
            $this->setCustomParameters(array(self::MODULES_DISABLED => $moduleData[self::DISABLED]));

            //If changes exist -> send deployment marker
            if(count($disabledChangeArray) > 0){
                foreach($disabledChangeArray as $change){
                    Mage::helper('blueacorn_newrelicreporting/deployments')->setDeployment(
                        'Modules Disabled', $change
                    );
                }

            }

            //Report Installed Count
            $this->setCustomParameters(array(self::MODULES_INSTALLED => $moduleData[self::INSTALLED]));

            //If changes exist -> send deployment marker
            if(count($installedChangeArray) > 0){
                foreach($installedChangeArray as $change){
                    Mage::helper('blueacorn_newrelicreporting/deployments')->setDeployment(
                        'Modules Installed', $change
                    );
                }
            }

            //If changes exist -> send deployment marker
            if(count($uninstalledChangeArray) > 0){
                foreach($uninstalledChangeArray as $change){
                    Mage::helper('blueacorn_newrelicreporting/deployments')->setDeployment(
                        'Modules Uninstalled', $change
                    );
                }
            }
        }
    }

    /**
     * Adds New Relic custom parameters per request for store, website, and logged in user if applicable
     *
     */
    public function reportConcurrentUsers()
    {
        if ($this->_getEnabled()) {
            $store = Mage::app()->getStore();
            $website = Mage::app()->getWebsite();
            $session = Mage::getSingleton('customer/session', array('name' => 'frontend'));

            newrelic_add_custom_parameter(self::STORE, $store->getName());
            newrelic_add_custom_parameter(self::WEBSITE, $website->getName());
            if ($session->isLoggedIn()) {
                newrelic_add_custom_parameter(self::CUSTOMER_ID, $session->getCustomerId());
                newrelic_add_custom_parameter(self::CUSTOMER_NAME, $session->getCustomer()->getName());
            }
        }
    }

    /**
     * Adds New Relic custom parameters per adminhtml request for current admin user, if applicable
     *
     */
    public function reportConcurrentAdmins()
    {
        if ($this->_getEnabled()) {
            $adminSession = Mage::getSingleton('admin/session', array('name' => 'adminhtml'));
            if ($adminSession->isLoggedIn()) {
                $user = Mage::getSingleton('admin/session');
                newrelic_add_custom_parameter(self::ADMIN_USER_ID, $user->getUser()->getId());
                newrelic_add_custom_parameter(self::ADMIN_USER, $user->getUser()->getUsername());
                newrelic_add_custom_parameter(
                    self::ADMIN_NAME, $user->getUser()->getFirstname() . ' ' . $user->getUser()->getLastname()
                );
            }
        }
    }

    /**
     * Reports total product count to New Relic
     * By default, observed through cron job
     *
     * @param Varien_Event_Observer $observer
     */
    public function reportProductsCount($observer)
    {
        if ($this->_getEnabled()) {
            $this->setCustomParameters(array(self::PRODUCT_COUNT => (int)$observer->getProductCount()));
        }
    }

    /**
     * Reports configurable product count to New Relic
     * By default, observed through cron job
     *
     * @param Varien_Event_Observer $observer
     */
    public function reportConfigurableProductsCount($observer)
    {
        if ($this->_getEnabled()) {
            $this->setCustomParameters(array(self::CONFIGURABLE_COUNT => (int)$observer->getConfigurableCount()));
        }
    }

    /**
     * Reports active product count to New Relic
     * By default, observed through cron job
     *
     * @param Varien_Event_Observer $observer
     */
    public function reportProductsActive($observer)
    {
        if ($this->_getEnabled()) {
            $this->setCustomParameters(array(self::ACTIVE_COUNT => (int)$observer->getActiveProductsCount()));
        }
    }

    /**
     * Reports total category count to New Relic
     * By default, observed through cron job
     *
     * @param Varien_Event_Observer $observer
     */
    public function reportCategoryCount($observer)
    {
        if ($this->_getEnabled()) {
            $this->setCustomParameters(array(self::CATEGORY_COUNT => (int)$observer->getCategoryCount()));
        }
    }

    /**
     * Reports total website count to New Relic
     * By default, observed through cron job
     *
     * @param Varien_Event_Observer $observer
     */
    public function reportWebsiteCount($observer)
    {
        if ($this->_getEnabled()) {
            $this->setCustomParameters(array(self::WEBSITE_COUNT => (int)$observer->getWebsiteCount()));
        }
    }

    /**
     * Reports total store view count to New Relic
     * By default, observed through cron job
     *
     * @param Varien_Event_Observer $observer
     */
    public function reportStoreViewsCount($observer)
    {
        if ($this->_getEnabled()) {
            $this->setCustomParameters(array(self::STORE_VIEW_COUNT => (int)$observer->getStoreViewsCount()));
        }
    }

    /**
     * Reports total customer count to New Relic
     * By default, observed through cron job
     *
     * @param Varien_Event_Observer $observer
     */
    public function reportCustomerCount($observer)
    {
        if ($this->_getEnabled()) {
            $this->setCustomParameters(array(self::CUSTOMER_COUNT => (int)$observer->getCustomerCount()));
        }
    }

    /**
     * Send off collected data, if any, to Insights Event API
     */
    public function afterCron()
    {
        if (!$this->_useEventApi) {
            return;
        }
        if (!empty($this->_customParameters)) {
            try {
                Mage::helper('blueacorn_newrelicreporting/cronEvent')
                    ->addData($this->_customParameters)
                    ->sendRequest();
            } catch (Exception $e) {
                Mage::log(sprintf("New Relic Cron Event exception: %s\n%s", $e->getMessage(), $e->getTraceAsString()));
            }
        }
    }

    /**
     * Returns status of module being enabled via system -> configuration
     *
     * @return bool
     */
    protected function _getEnabled()
    {
        if (extension_loaded('newrelic')) {
            return Mage::helper('blueacorn_newrelicreporting/config')->isNewRelicEnabled();
        }
        return false;
    }
}