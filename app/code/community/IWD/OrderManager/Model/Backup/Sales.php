<?php

class IWD_OrderManager_Model_Backup_Sales extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('iwd_ordermanager/backup_sales');
    }

    public function saveBackup($obj, $items, $type, $afterAction='delete')
    {
        $itemsArray = $this->prepareItems($items);

        $objSerialize = serialize($obj->getData());
        $itemsSerialize = serialize($itemsArray);

        $adminUser = Mage::getSingleton('admin/session')->getUser();
        $adminUserId = !empty($adminUser) ? $adminUser->getId() : 0;

        $this->setDeletionAt(Mage::getModel('core/date')->date('Y-m-d H:i:s'))
            ->setObjectType($type)
            ->setObject($objSerialize)
            ->setObjectItems($itemsSerialize)
            ->setAdminUserId($adminUserId)
            ->setAfterAction($afterAction)
            ->setEntityId($obj->getEntityId());

        return $this->save();
    }

    protected function prepareItems($items)
    {
        $itemsArray = array();
        foreach ($items as $item) {
            $itemArray = $item->getData();
            unset($itemArray["product"]);
            $itemsArray[] = $itemArray;
        }

        return $itemsArray;
    }

    public function loadSalesObject($id)
    {
        $backup = $this->load($id);
        $object = $backup->getObject();
        $type = $this->getObjectType();

        $salesObject = $this->getSalesObject($type);
        $salesObject->setData($object);

        return $salesObject;
    }

    protected function getSalesObject($type)
    {
        switch($type) {
            case 'order': return Mage::getModel('sales/order');
            case 'creditmemo': return Mage::getModel('sales/order_creditmemo');
            case 'invoice': return Mage::getModel('sales/order_invoice');
            case 'shipment': return Mage::getModel('sales/order_shipment');
            default: throw new Exception('Unknown object type');
        }
    }
}
