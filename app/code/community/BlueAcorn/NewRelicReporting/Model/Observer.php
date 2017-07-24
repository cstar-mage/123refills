<?php

/**
 * @package     BlueAcorn\DatabaseLogging
 * @version     1.1
 * @author      Magento, Inc. <eeadmin@magentocommerce.com>
 * @copyright   Copyright © 2014 Magento, Inc.
 */
class BlueAcorn_NewRelicReporting_Model_Observer
{
    /**#@+
     * Names of parameters to be sent to database tables
     */
    const ORDER_ITEMS = 'lineItemCount';
    const ORDER_VALUE = 'orderValue';
    const ADMIN_USER_ID = 'adminId';
    const ADMIN_USER = 'adminUser';
    const ADMIN_NAME = 'adminName';
    const CUSTOMER_ID = 'customerId';
    const FLUSH_CACHE = 'systemCacheFlush';
    const STORE = 'store';
    const WEBSITE = 'website';
    const PRODUCT_CHANGE = 'adminProductChange';
    const PRODUCT_COUNT = 'productCatalogSize';
    const CONFIGURABLE_COUNT = 'productCatalogConfigurableSize';
    const ACTIVE_COUNT = 'productCatalogActiveSize';
    const CATEGORY_SIZE = 'productCatalogCategorySize';
    const ENABLED_MODULE_COUNT = 'enabledModuleCount';
    const MODULE_INSTALLED = 'moduleInstalled';
    const MODULE_UNINSTALLED = 'moduleUninstalled';
    const MODULE_ENABLED = 'moduleEnabled';
    const MODULE_DISABLED = 'moduleDisabled';
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
     * Reports A System Flush Cache to the database reporting_system_updates table
     */
    public function reportFlushSystemCache()
    {
        $jsonData = array(
            'status' => 'updated'
        );

        $data = array(
            'type' => self::FLUSH_CACHE,
            'action'  => Zend_Json_Encoder::encode($jsonData),
            'updated_at'    => Mage::getModel('core/date')->date('Y-m-d H:i:s')
        );

        $model = Mage::getModel('blueacorn_newrelicreporting/system');
        $model->addData($data);
        $model->save();
    }

    /**
     * Reports orders placed to the database reporting_orders table
     * @param Varien_Event_Observer $observer
     */
    public function reportOrderPlaced($observer)
    {
        $order = $observer->getOrder();

        $data = array(
            'customer_id'   => $order->getCustomer()->getId(),
            'total'         => $order->getGrandTotal(),
            'total_base'    => $order->getBaseGrandTotal(),
            'item_count'    => $order->getTotalItemCount(),
            'updated_at'    => Mage::getModel('core/date')->date('Y-m-d H:i:s')

        );

        $model = Mage::getModel('blueacorn_newrelicreporting/orders');
        $model->addData($data);
        $model->save();
    }

    /**
     * Reports any products updated to the database reporting_system_updates table
     * @param Varien_Event_Observer $observer
     */
    public function reportProductUpdated($observer)
    {
        $product = $observer->getProduct();

        $jsonData = array(
            'id'     => $product->getId(),
            'name'   => $product->getName(),
            'status' => 'updated'
        );

        $data = array(
            'type' => self::PRODUCT_CHANGE,
            'action'  => Zend_Json_Encoder::encode($jsonData),
            'updated_at' => Mage::getModel('core/date')->date('Y-m-d H:i:s')
        );

        $model = Mage::getModel('blueacorn_newrelicreporting/system');
        $model->addData($data);
        $model->save();
    }

    /**
     * Reports any products created to the database reporting_system_updates table
     * @param Varien_Event_Observer $observer
     */
    public function reportProductCreated($observer)
    {
        $product = $observer->getProduct();

        $jsonData = array(
            'id'     => $product->getId(),
            'name'   => $product->getName(),
            'status' => 'created'
        );

        $data = array(
            'type' => self::PRODUCT_CHANGE,
            'action'  => Zend_Json_Encoder::encode($jsonData),
            'updated_at' => Mage::getModel('core/date')->date('Y-m-d H:i:s')
        );

        $model = Mage::getModel('blueacorn_newrelicreporting/system');
        $model->addData($data);
        $model->save();
    }

    /**
     * Reports any products deleted to the database reporting_system_updates
     * @param Varien_Event_Observer $observer
     */
    public function reportProductDeleted($observer)
    {
        $product = $observer->getProduct();

        $jsonData = array(
            'id'     => $product->getId(),
            'name'   => $product->getName(),
            'status' => 'deleted'
        );

        $data = array(
            'type' => self::PRODUCT_CHANGE,
            'action'  => Zend_Json_Encoder::encode($jsonData),
            'updated_at' => Mage::getModel('core/date')->date('Y-m-d H:i:s')
        );

        $model = Mage::getModel('blueacorn_newrelicreporting/system');
        $model->addData($data);
        $model->save();
    }

    /**
     * Reports Modules and module changes to the database reporting_module_status table
     * @param Varien_Event_Observer $observer
     */
    public function reportModules($observer)
    {
        $moduleData = $observer->getModuleData();

        //Verify that there are changes
        if(count($moduleData['changes']) > 0){

            foreach($moduleData['changes'] as $change){
                $type = $change['type'];

                switch($type){

                    case self::ENABLED:{
                        $data = array(
                            'type' => self::MODULE_ENABLED,
                            'action'  => Zend_Json_Encoder::encode($change),
                            'updated_at' => Mage::getModel('core/date')->date('Y-m-d H:i:s')
                        );

                        $model = Mage::getModel('blueacorn_newrelicreporting/system');
                        $model->addData($data);
                        $model->save();
                        break;
                    }

                    case self::DISABLED:{
                        $data = array(
                            'type' => self::MODULE_DISABLED,
                            'action'  => Zend_Json_Encoder::encode($change),
                            'updated_at' => Mage::getModel('core/date')->date('Y-m-d H:i:s')
                        );

                        $model = Mage::getModel('blueacorn_newrelicreporting/system');
                        $model->addData($data);
                        $model->save();
                        break;
                    }

                    case self::INSTALLED:{
                        $data = array(
                            'type' => self::MODULE_INSTALLED,
                            'action'  => Zend_Json_Encoder::encode($change),
                            'updated_at' => Mage::getModel('core/date')->date('Y-m-d H:i:s')
                        );

                        $model = Mage::getModel('blueacorn_newrelicreporting/system');
                        $model->addData($data);
                        $model->save();
                        break;
                    }

                    case self::UNINSTALLED:{
                        $data = array(
                            'type' => self::MODULE_UNINSTALLED,
                            'action'  => Zend_Json_Encoder::encode($change),
                            'updated_at' => Mage::getModel('core/date')->date('Y-m-d H:i:s')
                        );

                        $model = Mage::getModel('blueacorn_newrelicreporting/system');
                        $model->addData($data);
                        $model->save();
                        break;
                    }

                }
            }
        }
    }

    /**
     * Reports concurrent users to the database reporting_users table
     */
    public function reportConcurrentUsers()
    {
        $store = Mage::app()->getStore();
        $website = Mage::app()->getWebsite();
        $session = Mage::getSingleton('customer/session', array('name' => 'frontend'));
        if ($session->isLoggedIn()) {
            $jsonData = array(
                'id'      => $session->getCustomerId(),
                'name'    => $session->getCustomer()->getName(),
                'store'   => $store->getName(),
                'website' => $website->getName()
            );

            $data = array(
                'type' => 'user_action',
                'action'  => Zend_Json_Encoder::encode($jsonData),
                'updated_at' => Mage::getModel('core/date')->date('Y-m-d H:i:s')
            );

            $model = Mage::getModel('blueacorn_newrelicreporting/users');
            $model->addData($data);
            $model->save();
        }
    }

    /**
     * Reports concurrent admins to the database reporting_users table
     */
    public function reportConcurrentAdmins()
    {
        $adminSession = Mage::getSingleton('admin/session', array('name' => 'adminhtml'));
        if ($adminSession->isLoggedIn()) {
            $user = Mage::getSingleton('admin/session');
            $jsonData = array(
                'id'       => $user->getUser()->getUserId(),
                'username' => $user->getUser()->getUsername(),
                'name'     => $user->getUser()->getFirstname() . ' ' . $user->getUser()->getLastname()

            );

            $data = array(
                'type' => 'admin_activity',
                'action'  => Zend_Json_Encoder::encode($jsonData),
                'updated_at' => Mage::getModel('core/date')->date('Y-m-d H:i:s')
            );

            $model = Mage::getModel('blueacorn_newrelicreporting/users');
            $model->addData($data);
            $model->save();
        }
    }

    /**
     * Reports product size to the database reporting_counts table
     */
    public function reportProductsSize()
    {
        $productCount = Mage::helper('blueacorn_newrelicreporting')->getAllProductsCount();
        $model = Mage::getModel('blueacorn_newrelicreporting/counts')->load(self::PRODUCT_COUNT, 'type');
        $this->_updateCount($productCount, $model, self::PRODUCT_COUNT);
    }

    /**
     * Reports configurable product size to the database reporting_counts table
     */
    public function reportConfigurableProductsSize()
    {
        $configurableCount = Mage::helper('blueacorn_newrelicreporting')->getConfigurableCount();
        $model = Mage::getModel('blueacorn_newrelicreporting/counts')->load(self::CONFIGURABLE_COUNT, 'type');
        $this->_updateCount($configurableCount, $model, self::CONFIGURABLE_COUNT);
    }

    /**
     * Reports number of active products to the database reporting_counts table
     */
    public function reportProductsActive()
    {
        $productsActiveCount = Mage::helper('blueacorn_newrelicreporting')->getActiveCatalogSize();
        $model = Mage::getModel('blueacorn_newrelicreporting/counts')->load(self::ACTIVE_COUNT, 'type');
        $this->_updateCount($productsActiveCount, $model, self::ACTIVE_COUNT);
    }

    /**
     * Reports category size to the database reporting_counts table
     */
    public function reportCategorySize()
    {
        $categoryCount = Mage::helper('blueacorn_newrelicreporting')->getCategoryCount();
        $model = Mage::getModel('blueacorn_newrelicreporting/counts')->load(self::CATEGORY_SIZE, 'type');
        $this->_updateCount($categoryCount, $model, self::CATEGORY_SIZE);
    }

    /**
     * Updates the count for a specific model in the database
     * @param $count
     * @param $model
     * @param $type
     */
    protected function _updateCount($count, $model, $type)
    {
        $collection = $model->getCollection()
            ->addFieldToFilter('type', $type)
            ->addOrder('updated_at', 'DESC')
            ->getSelect()->limit(1);

        $latestUpdate = $collection->getFirstItem();

        if($count != $latestUpdate->getCount()){
            $model->setEntityId(null);
            $model->setType($type);
            $model->setCount($count);
            $model->setUpdatedAt( Mage::getModel('core/date')->date('Y-m-d H:i:s'));
            $model->save();
        }
    }

    /**
     * Dispatches the flush system cache event
     * @param Varien_Event_Observer $observer
     */
    public function dispatchFlushSystemCache($observer)
    {
        if ($this->_getEnabled()) {
            Mage::dispatchEvent('reporting_system_cache_flush', array('data' => $observer));
        }
    }

    /**
     * Dispatched the order placed event
     * @param Varien_Event_Observer $observer
     */
    public function dispatchOrderPlaced($observer)
    {
        if ($this->_getEnabled()) {
            Mage::dispatchEvent('reporting_sales_order_place', array('order' => $observer->getOrder()));
        }
    }

    /**
     * Dispatched the product saved event
     * @param Varien_Event_Observer $observer
     */
    public function dispatchProductSaved($observer)
    {
        if ($this->_getEnabled()) {
            $product = $observer->getProduct();

            if ($product->isObjectNew()) {
                Mage::dispatchEvent('reporting_catalog_product_create', array('product' => $product));
            } else {
                Mage::dispatchEvent('reporting_catalog_product_update', array('product' => $product));
            }
        }
    }

    /**
     * Dispatches the product deleted event
     * @param Varien_Event_Observer $observer
     */
    public function dispatchProductDeleted($observer)
    {
        if ($this->_getEnabled()) {
            Mage::dispatchEvent('reporting_catalog_product_delete', array('product' => $observer->getProduct()));
        }
    }

    /**
     * Dispatches an event to report concurrent users
     * @param Varien_Event_Observer $observer
     */
    public function dispatchConcurrentUsers($observer)
    {
        if ($this->_getEnabled()) {
            Mage::dispatchEvent('reporting_user_concurrent_users', array('data' => $observer));
        }
    }

    /**
     * Dispatches an event to report concurrent admins
     * @param Varien_Event_Observer $observer
     */
    public function dispatchConcurrentAdmins($observer)
    {
        if ($this->_getEnabled()) {
            Mage::dispatchEvent('reporting_user_concurrent_admins', array('data' => $observer));
        }
    }

    /**
     * Checks to see if New Relic is enabled in the admin panel
     * @return mixed
     */
    protected function _getEnabled()
    {
        return Mage::helper('blueacorn_newrelicreporting/config')->isNewRelicEnabled();
    }

}