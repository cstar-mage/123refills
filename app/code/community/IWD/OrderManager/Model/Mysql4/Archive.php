<?php

/**
 * Class IWD_OrderManager_Model_Mysql4_Archive
 */
class IWD_OrderManager_Model_Mysql4_Archive extends Mage_Core_Model_Resource_Db_Abstract
{
    const ORDER      = IWD_OrderManager_Model_Archive::ORDER;
    const INVOICE    = IWD_OrderManager_Model_Archive::INVOICE;
    const SHIPMENT   = IWD_OrderManager_Model_Archive::SHIPMENT;
    const CREDITMEMO = IWD_OrderManager_Model_Archive::CREDITMEMO;

    protected $entities = array(
        self::ORDER      => 'sales/order',
        self::INVOICE    => 'sales/order_invoice',
        self::SHIPMENT   => 'sales/order_shipment',
        self::CREDITMEMO => 'sales/order_creditmemo',
    );

    protected $standard_tables = array(
        self::ORDER      => 'sales/order_grid',
        self::INVOICE    => 'sales/invoice_grid',
        self::SHIPMENT   => 'sales/shipment_grid',
        self::CREDITMEMO => 'sales/creditmemo_grid',
    );

    protected $archive_tables = array(
        self::ORDER      => 'iwd_ordermanager/archive_order',
        self::INVOICE    => 'iwd_ordermanager/archive_invoice',
        self::SHIPMENT   => 'iwd_ordermanager/archive_shipment',
        self::CREDITMEMO => 'iwd_ordermanager/archive_creditmemo'
    );

    /**
     *
     */
    protected function _construct()
    {
        $this->_setResource('iwd_ordermanager_archive');
    }

    /**
     * @param $entity
     * @return bool|mixed
     */
    public function getEntityModel($entity)
    {
        $entities = $this->entities;
        return isset($entities[$entity]) ? $entities[$entity] : false;
    }

    /**
     * @param $entity
     * @return bool|string
     */
    public function getArchiveTable($entity)
    {
        if (!isset($this->archive_tables[$entity])) {
            return false;
        }
        return $this->getTable($this->archive_tables[$entity]);
    }

    /**
     * @param $entity
     * @return bool|string
     */
    public function getStandardTable($entity)
    {
        if (!isset($this->standard_tables[$entity])) {
            return false;
        }
        return $this->getTable($this->standard_tables[$entity]);
    }


    /**
     * @param $value
     * @return $this
     */
    public function setForeignKeyChecks($value)
    {
        $adapter = $this->_getWriteAdapter();
        $adapter->query("SET FOREIGN_KEY_CHECKS = {$value};");
        return $this;
    }

    /**
     * @param $entity
     * @param $ids
     * @return array
     */
    public function getIdsInArchive($entity, $ids)
    {
        if (!is_array($ids)) {
            $ids = array($ids);
        }

        $select = $this->_getReadAdapter()->select()
            ->from($this->getArchiveTable($entity), 'entity_id')
            ->where('entity_id IN(?)', $ids);

        return $this->_getReadAdapter()->fetchCol($select);
    }

    /**
     * @param $entity
     * @param $field
     * @param $value
     * @return $this
     */
    public function addToArchiveFromStandard($entity, $field, $value)
    {
        $adapter = $this->_getWriteAdapter();
        $sourceTable = $this->getStandardTable($entity);
        $targetTable = $this->getArchiveTable($entity);

        $insertToFields = array_intersect(
            array_keys($adapter->describeTable($targetTable)),
            array_keys($adapter->describeTable($sourceTable))
        );

        $condition = $adapter->quoteIdentifier($field) . ' IN(?)';
        $select = $adapter->select()
            ->from($sourceTable, $insertToFields)
            ->where($condition, $value);

        $adapter->query($select->insertFromSelect($targetTable, $insertToFields, true));
        return $this;
    }

    /**
     * @param $entity
     * @param $field
     * @param $value
     * @return $this
     */
    public function removeFromStandard($entity, $field, $value)
    {
        $adapter = $this->_getWriteAdapter();
        $sourceTable = $this->getStandardTable($entity);
        $targetTable = $this->getArchiveTable($entity);
        $sourceModel = Mage::getResourceSingleton($this->getEntityModel($entity));

        if ($value instanceof Zend_Db_Expr) {
            $select = $adapter->select();
            $select->from($targetTable, $sourceModel->getIdFieldName());
            $condition = $adapter->quoteInto($sourceModel->getIdFieldName() . ' IN(?)', new Zend_Db_Expr($select));
        } else {
            $fieldCondition = $adapter->quoteIdentifier($field) . ' IN(?)';
            $condition = $adapter->quoteInto($fieldCondition, $value);
        }

        $adapter->delete($sourceTable, $condition);
        return $this;
    }

    /**
     * @param $entity
     * @param string $field
     * @param null $value
     * @return $this
     */
    public function restoreFromArchive($entity, $field = '', $value = null)
    {
        $adapter = $this->_getWriteAdapter();
        $sourceTable = $this->getArchiveTable($entity);
        $targetTable = $this->getStandardTable($entity);
        $sourceModel = Mage::getResourceSingleton($this->getEntityModel($entity));

        $insertToFields = array_intersect(
            array_keys($adapter->describeTable($targetTable)),
            array_keys($adapter->describeTable($sourceTable))
        );

        $selectFromFields = $insertToFields;
        $updatedAtIndex = array_search('updated_at', $selectFromFields);
        if ($updatedAtIndex !== false) {
            unset($selectFromFields[$updatedAtIndex]);
            $selectFromFields['updated_at'] = new Zend_Db_Expr($adapter->quoteInto('?', $this->formatDate(true)));
        }

        $select = $adapter->select()->from($sourceTable, $selectFromFields);

        if (!empty($field)) {
            $select->where($adapter->quoteIdentifier($field) . ' IN(?)', $value);
        }

        $adapter->query($select->insertFromSelect($targetTable, $insertToFields, true));
        if ($value instanceof Zend_Db_Expr) {
            $select->reset()->from($targetTable, $sourceModel->getIdFieldName());
            $condition = $adapter->quoteInto($sourceModel->getIdFieldName() . ' IN(?)', new Zend_Db_Expr($select));
        } elseif (!empty($field)) {
            $condition = $adapter->quoteInto(
                $adapter->quoteIdentifier($field) . ' IN(?)', $value
            );
        } else {
            $condition = '';
        }

        $adapter->delete($sourceTable, $condition);
        return $this;
    }

    /**
     * @return Zend_Db_Expr
     */
    public function getOrderIdsForArchiveExpression()
    {
        $statuses = Mage::getModel('iwd_ordermanager/archive')->getArchiveOrderStatuses();
        $period = Mage::getModel('iwd_ordermanager/archive')->getArchiveAfterDays();

        $select = $this->_getOrderIdsForArchiveSelect($statuses, $period);

        return new Zend_Db_Expr($select);
    }

    /**
     * @param $statuses
     * @param $period
     * @return Varien_Db_Select
     */
    protected function _getOrderIdsForArchiveSelect($statuses, $period)
    {
        $adapter = $this->_getReadAdapter();
        $table = $this->getStandardTable(IWD_OrderManager_Model_Archive::ORDER);
        $select = $adapter->select()->from($table, 'entity_id')->where('status IN(?)', $statuses);

        if ($period) {
            $archivePeriodExpr = $adapter->getDateSubSql($adapter->quote($this->formatDate(true)), (int)$period, Varien_Db_Adapter_Interface::INTERVAL_DAY);
            $select->where($archivePeriodExpr . ' >= created_at');
        }

        return $select;
    }

    /**
     * @param array $orderIds
     * @param bool $usePeriod
     * @return array
     */
    public function getOrderIdsForArchive($orderIds = array(), $usePeriod = false)
    {
        $statuses = Mage::getModel('iwd_ordermanager/archive')->getArchiveOrderStatuses();
        $period = Mage::getModel('iwd_ordermanager/archive')->getArchiveAfterDays();
        $period = ($usePeriod ? $period : 0);

        if (empty($statuses)) {
            return array();
        }

        $select = $this->_getOrderIdsForArchiveSelect($statuses, $period);
        if (!empty($orderIds)) {
            $select->where('entity_id IN(?)', $orderIds);
        }

        return $this->_getReadAdapter()->fetchCol($select);
    }


    /**
     * @param $entity
     * @param $ids
     * @return $this
     */
    public function updateGridRecords($entity, $ids)
    {
        $gridColumns = array_keys($this->_getWriteAdapter()->describeTable($this->getArchiveTable($entity)));

        $columnsToSelect = array();

        $select = Mage::getResourceSingleton($this->getEntityModel($entity))
            ->getUpdateGridRecordsSelect($ids, $columnsToSelect, $gridColumns, true);

        $this->_getWriteAdapter()->query($select->insertFromSelect($this->getArchiveTable($entity), $columnsToSelect, true));

        return $this;
    }
}
