<?php

class IWD_OrderManager_Model_Cataloginventory_Stock extends Mage_CatalogInventory_Model_Stock
{
    protected function _construct()
    {
        $this->_init('iwd_ordermanager/cataloginventory_stock');
    }

    /**
     * @return int
     */
    public function getId()
    {
        if ($this->isMultiInventoryEnabled()) {
            return $this->getStockId();
        }

        return parent::getId();
    }

    /**
     * @return bool
     */
    protected function isMultiInventoryEnabled()
    {
        $module = Mage::app()->getRequest()->getControllerModule();
        $controller = Mage::app()->getRequest()->getControllerName();

        if ($module == 'IWD_OrderManager_Adminhtml' && $controller == 'sales_orderr') {
            return false;
        }

        $excludedControllers = array('catalog_product', 'cataloginventory_order', 'cataloginventory_stock', 'cataloginventory_product', 'system_config');
        return Mage::helper('iwd_ordermanager')->isMultiInventoryEnable()
        && (in_array($module, array('Mage_Adminhtml', 'IWD_OrderManager_Adminhtml')) && in_array($controller, $excludedControllers));
    }

    /**
     * @return int
     */
    protected function getStockId()
    {
        $fieldName = $this->getIdFieldName();
        if ($fieldName) {
            return $this->_getData($fieldName);
        } else {
            return $this->_getData('id');
        }
    }

    /**
     * @param $data
     * @return string
     */
    public function saveStockData($data)
    {
        if (isset($data['stock_id'])) {
            $this->load($data['stock_id']);
        }

        $this->saveStock($data);
        $this->saveStoreView($data);
        $this->save();

        $this->saveAddress($data);

        return $this->getStockId();
    }

    /**
     * @return $this
     */
    public function joinAddress()
    {
        $collection = $this->getCollection()->getSelect();

        if ($this->getStockId()) {
            $tableStockAddress = Mage::getSingleton('core/resource')->getTableName('iwd_cataloginventory_stock_address');

            $collection = $collection->joinLeft(
                $tableStockAddress,
                "main_table.stock_id={$tableStockAddress}.stock_id",
                array('*', 'stock_id' => 'main_table.stock_id')
            );

            $collection->where("main_table.stock_id={$this->getStockId()}");
        }

        $data = Mage::getSingleton('core/resource')->getConnection('core_read')->fetchAll($collection);
        $data = isset($data[0]) ? $data[0] : array();

        $this->setData($data);

        return $this;
    }

    /**
     * @return $this
     */
    public function joinStoreIds()
    {
        $store_ids= $this->getStoreIds();
        $this->setData('store_ids', $store_ids);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStoreIds()
    {
        $ids = $this->_getData('store_ids');
        if (is_null($ids)) {
            $this->loadStoreIds();
            $ids = $this->getData('store_ids');
        }
        return $ids;
    }

    public function loadStoreIds()
    {
        $this->_getResource()->loadStoreIds($this);
    }

    /**
     * @param $data
     * @throws Exception
     */
    protected function saveStock($data)
    {
        if (isset($data['stock_name']) && !empty($data['stock_name'])) {
            $this->setStockName($data['stock_name']);
        }
    }

    /**
     * @param $data
     */
    protected function saveStoreView($data)
    {
        if (isset($data['store_ids'])) {
            $this->setStoreIds($data['store_ids']);
        }
    }

    /**
     * @param $data
     */
    protected function saveAddress($data)
    {
        $stockAddress = Mage::getModel('iwd_ordermanager/cataloginventory_stock_address')->getCollection()
            ->addFieldToFilter('stock_id', $this->getStockId());

        if ($stockAddress->getSize() > 0) {
            $stockAddress = $stockAddress->getFirstItem();
        } else {
            $stockAddress = Mage::getModel('iwd_ordermanager/cataloginventory_stock_address');
        }

        $stockAddress->setData('stock_id', $this->getStockId());

        $fields = array('street', 'city', 'country_id', 'region', 'region_id', 'postcode');
        foreach ($fields as $field) {
            if (isset($data[$field])) {
                $stockAddress->setData($field, $data[$field]);
            }
        }

        $stockAddress->save();
    }
}
