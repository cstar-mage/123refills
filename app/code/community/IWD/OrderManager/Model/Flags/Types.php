<?php

/**
 * Class IWD_OrderManager_Model_Flags_Types
 *
 * @method string getName()
 * @method IWD_OrderManager_Model_Flags_Types setName(string $value)
 * @method string getComment()
 * @method IWD_OrderManager_Model_Flags_Types setComment(string $value)
 */
class IWD_OrderManager_Model_Flags_Types extends Mage_Core_Model_Abstract
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('iwd_ordermanager/flags_types');
    }

    /**
     * @return bool
     */
    public function isTypeActive()
    {
        $columns = Mage::getStoreConfig('iwd_ordermanager/grid_order/columns');
        $columns = explode(',', $columns);

        return in_array($this->getOrderGridId(), $columns);
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = array(
            array(
                'label' => Mage::helper('adminhtml')->__('--Please Select--'),
                'value' => '0'
            )
        );

        $collection = $this->getCollection();
        foreach ($collection as $item) {
            $options[] = array(
                'label' => $item->getName(),
                'value' => $item->getId()
            );
        }

        return $options;
    }

    /**
     * @return void
     */
    public function assignFlags()
    {
        $flags = Mage::getModel('iwd_ordermanager/flags_flag_type')->getCollection()
            ->addFieldToFilter('type_id', $this->getId())
            ->getColumnValues('flag_id');

        $this->setData('flags', $flags);
    }

    /**
     * @return array
     */
    public function getAssignedFlags()
    {
        $tableFlags = Mage::getSingleton('core/resource')->getTableName('iwd_om_flags');

        $collection = Mage::getModel('iwd_ordermanager/flags_flag_type')->getCollection()
            ->addFieldToFilter('type_id', $this->getId());

        $collection->getSelect()->joinLeft(
            $tableFlags,
            "main_table.flag_id = {$tableFlags}.id",
            array("flag_name" => "{$tableFlags}.name")
        );

        $options = array();
        foreach ($collection as $item) {
            $options[$item->getFlagId()] = $item->getFlagName();
        }

        return $options;
    }

    /**
     * @param $flags
     */
    public function assignFlagsToType($flags)
    {
        $flagsTypes = Mage::getModel('iwd_ordermanager/flags_flag_type')->getCollection()
            ->addFieldToFilter('type_id', $this->getId());

        foreach ($flagsTypes as $item) {
            if (($key = array_search($item->getFlagId(), $flags)) !== false) {
                unset($flags[$key]);
            } else {
                $item->delete();
            }
        }

        foreach ($flags as $flag) {
            $flagType = Mage::getModel('iwd_ordermanager/flags_flag_type');
            $flagType->setTypeId($this->getId())
                ->setFlagId($flag)
                ->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addColumnToOrderGrid()
    {
        $items = Mage::getModel('core/config_data')->getCollection()
            ->addFieldToFilter('path', 'iwd_ordermanager/grid_order/columns');

        if ($items->getSize() > 0) {
            $columns = $items->getFirstItem()->getValue();
            if (!empty($columns)) {
                $columns = explode(',', $columns);
                array_unshift($columns, $this->getOrderGridId());
                $columns = implode(',', $columns);
                Mage::getConfig()->saveConfig('iwd_ordermanager/grid_order/columns', $columns, 'default', 0);
            }
        }
    }

    /**
     * @return $this
     */
    protected function _afterSave()
    {
        parent::_afterSave();

        if ($this->isObjectNew()) {
            $this->addColumnToOrderGrid();
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getOrderGridId()
    {
        return 'iwd_om_flags_' . $this->getId();
    }
}
