<?php

/**
 * Class IWD_OrderManager_Model_Archive
 */
class IWD_OrderManager_Model_Archive
{
    const ORDER      = 'order';
    const INVOICE    = 'invoice';
    const SHIPMENT   = 'shipment';
    const CREDITMEMO = 'creditmemo';

    protected $entities = array(
        self::ORDER      => 'sales/order',
        self::INVOICE    => 'sales/order_invoice',
        self::SHIPMENT   => 'sales/order_shipment',
        self::CREDITMEMO => 'sales/order_creditmemo',
    );

    protected  $_result_error = null;
    protected  $_not_allowed_orders = null;
    protected  $_count_orders = 0;

    /***************************** SETTINGS ***********************************/
    const XML_PATH_ARCHIVE_ORDER_ENABLE = 'iwd_ordermanager/archive/enable';
    const XML_PATH_ARCHIVE_ORDER_STATUSES = 'iwd_ordermanager/archive/order_statuses';
    const XML_PATH_AUTO_ARCHIVE_AFTER_DAYS = 'iwd_ordermanager/archive/auto_archive_after_days';

    public function isAllowArchiveOrders()
    {
        $permissionAllow = Mage::getSingleton('admin/session')->isAllowed('iwd_ordermanager/order/actions/archive');
        $enable = $this->isArchiveEnable();
        $enterprise = Mage::helper('iwd_ordermanager')->isEnterpriseMagentoEdition();

        return ($permissionAllow && $enable && !$enterprise);
    }

    public function isAllowRestoreOrders()
    {
        $permissionAllow = Mage::getSingleton('admin/session')->isAllowed('iwd_ordermanager/order/actions/archive_restore');
        $enable = $this->isArchiveEnable();
        return ($permissionAllow && $enable);
    }

    public function isArchiveEnable()
    {
        return Mage::getStoreConfig(self::XML_PATH_ARCHIVE_ORDER_ENABLE) ? 1 : 0;
    }

    public function getArchiveOrderStatuses()
    {
        $statuses = Mage::getStoreConfig(self::XML_PATH_ARCHIVE_ORDER_STATUSES);
        $statuses = explode(",", $statuses);
        return empty($statuses) ? array(0) : $statuses;
    }

    public function getArchiveAfterDays()
    {
        return (int) Mage::getStoreConfig(self::XML_PATH_AUTO_ARCHIVE_AFTER_DAYS);
    }
    /*********************************************************** end SETTINGS */


    /************************* GET ARCHIVE COLLECTIONS ***********************/
    public function getArchiveOrdersCollection()
    {
        return Mage::getModel('iwd_ordermanager/archive_order')->getCollection();
    }

    public function getArchiveInvoicesCollection()
    {
        return Mage::getModel('iwd_ordermanager/archive_invoice')->getCollection();
    }

    public function getArchiveCreditmemosCollection()
    {
        return Mage::getModel('iwd_ordermanager/archive_creditmemo')->getCollection();
    }

    public function getArchiveShipmentsCollection()
    {
        return Mage::getModel('iwd_ordermanager/archive_shipment')->getCollection();
    }
    /******************************************* end GET ARCHIVE COLLECTIONS */


    public function resultError()
    {
        return $this->_result_error;
    }

    public function getNotAllowedOrders()
    {
        return $this->_not_allowed_orders;
    }

    public function getCountOrderIds()
    {
        return $this->_count_orders;
    }

    protected function _getResource()
    {
        return Mage::getResourceSingleton('iwd_ordermanager/archive');
    }

    public function addSalesToArchive()
    {
        $ids = $this->_getResource()->getOrderIdsForArchiveExpression();
        return $this->_archive($ids);
    }

    public function addSalesToArchiveByIds($orderIds)
    {
        if (empty($orderIds)) {
            return $this;
        }

        $ids = $this->_getResource()->getOrderIdsForArchive($orderIds, false);

        $this->_not_allowed_orders = array_diff_key($orderIds, $ids);

        return $this->_archive($ids);
    }

    protected function _archive($orderIds)
    {
        if (Mage::helper('iwd_ordermanager')->isEnterpriseMagentoEdition()) {
            return $this;
        }

        if (!empty($orderIds)) {
            $this->_count_orders = count($orderIds);

            $this->_getResource()->beginTransaction();
            try {
                $this->_getResource()->setForeignKeyChecks(0);

                $this->_getResource()->addToArchiveFromStandard(self::ORDER, 'entity_id', $orderIds);
                $this->_getResource()->addToArchiveFromStandard(self::INVOICE, 'order_id', $orderIds);
                $this->_getResource()->addToArchiveFromStandard(self::SHIPMENT, 'order_id', $orderIds);
                $this->_getResource()->addToArchiveFromStandard(self::CREDITMEMO, 'order_id', $orderIds);

                $this->_getResource()->removeFromStandard(self::ORDER, 'entity_id', $orderIds);
                $this->_getResource()->removeFromStandard(self::INVOICE, 'order_id', $orderIds);
                $this->_getResource()->removeFromStandard(self::SHIPMENT, 'order_id', $orderIds);
                $this->_getResource()->removeFromStandard(self::CREDITMEMO, 'order_id', $orderIds);

                $this->_getResource()->setForeignKeyChecks(1);
                $this->_getResource()->commit();
            } catch (Exception $e) {
                $this->_getResource()->rollBack();
                $this->_result_error = $e;
            }
        }

        return $this;
    }

    public function restoreSalesFromArchiveByIds($orderIds)
    {
        if (Mage::helper('iwd_ordermanager')->isEnterpriseMagentoEdition()) {
            return $this;
        }

        $ids = $this->_getResource()->getIdsInArchive(self::ORDER, $orderIds);

        if (!empty($ids)) {
            $this->_getResource()->beginTransaction();
            try {
                $this->_getResource()->setForeignKeyChecks(0);

                $this->_getResource()->restoreFromArchive(self::ORDER, 'entity_id', $orderIds);
                $this->_getResource()->restoreFromArchive(self::INVOICE, 'order_id', $orderIds);
                $this->_getResource()->restoreFromArchive(self::SHIPMENT, 'order_id', $orderIds);
                $this->_getResource()->restoreFromArchive(self::CREDITMEMO, 'order_id', $orderIds);

                $this->_getResource()->setForeignKeyChecks(1);

                $this->_getResource()->commit();
            } catch (Exception $e) {
                $this->_getResource()->rollBack();
                $this->_result_error = $e;
            }
        }

        return $this;
    }

    public function restoreSalesFromArchive()
    {
        if (Mage::helper('iwd_ordermanager')->isEnterpriseMagentoEdition()) {
            return $this;
        }

        $this->_getResource()->beginTransaction();
        try {
            $this->_getResource()->setForeignKeyChecks(0);

            $this->_getResource()->restoreFromArchive(self::ORDER);
            $this->_getResource()->restoreFromArchive(self::INVOICE);
            $this->_getResource()->restoreFromArchive(self::SHIPMENT);
            $this->_getResource()->restoreFromArchive(self::CREDITMEMO);

            $this->_getResource()->setForeignKeyChecks(1);

            $this->_getResource()->commit();
        } catch (Exception $e) {
            $this->_getResource()->rollBack();
            $this->_result_error = $e;
        }

        return $this;
    }

    public function detectArchiveEntity($object)
    {
        if (Mage::helper('iwd_ordermanager')->isEnterpriseMagentoEdition()) {
            return false;
        }

        foreach ($this->entities as $archiveEntity => $entityModel) {
            $className = Mage::getConfig()->getModelClassName($entityModel);
            $resourceClassName = Mage::getConfig()->getResourceModelClassName($entityModel);
            if ($object instanceof $className || $object instanceof $resourceClassName) {
                return $archiveEntity;
            }
        }

        return false;
    }

    public function updateGridRecords($entity, $ids)
    {
        $this->_getResource()->updateGridRecords($entity, $ids);
        return $this;
    }
}
