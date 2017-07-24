<?php

/**
 * Class IWD_OrderManager_Model_Resource_Order_Grid_Collection
 */
class IWD_OrderManager_Model_Resource_Order_Grid_Collection extends Mage_Sales_Model_Resource_Order_Grid_Collection
{
    /**
     * Minimize usual count select
     * @return Varien_Db_Select
     */
    public function getSelectCountSql()
    {
        $controllerName = Mage::app()->getRequest()->getControllerName();

        if ($controllerName == 'sales_order' || $controllerName == 'sales_archive_order') {
            $this->_renderFilters();

            $unionSelect = clone $this->getSelect();

            $unionSelect->reset(Zend_Db_Select::ORDER);
            $unionSelect->reset(Zend_Db_Select::LIMIT_COUNT);
            $unionSelect->reset(Zend_Db_Select::LIMIT_OFFSET);

            $countSelect = clone $this->getSelect();
            $countSelect->reset();
            $countSelect->from(array('a' => $unionSelect), 'COUNT(*)');
        } else {
            $countSelect = parent::getSelectCountSql();
        }

        return $countSelect;
    }
}