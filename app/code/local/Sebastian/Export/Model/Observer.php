<?php

/**
 *
 * Copyright Sebastian Enzinger <sebastian@enzinger.de> www.sebastian-enzinger.de
 *
 * All rights reserved.
 *
**/

class Sebastian_Export_Model_Observer
{
	public function checkoutTypeOnepageSaveOrderAfter($observer)
	{
    if (Mage::getStoreConfig('admin/orderexport/autoexport')) {
      $event = $observer->getEvent();
      $order = $event->getOrder();
      $order_id = $order->getData('increment_id');
      if ($order_id != null) {
        $types = Mage::helper('export')->getExportTypes();
        $type = strtolower(Mage::getStoreConfig('admin/orderexport/defaulttype'));
        if (!isset($types[$type])) return Mage::helper('export')->errorlog(Mage::helper('export')->__('Observer: Export type not found.'));
        Mage::getModel('export/export')->export($type, $order_id, $order_id, null, null, false, true);      
      }
    }
  }

  public function cronjob()
  {
    if (Mage::getStoreConfig('admin/orderexport/cronjobexport')) {
      $lastExportedOrder = Mage::helper('export')->getLastExportedOrder();
      if (strpos($lastExportedOrder, '-') !== FALSE) {
        $order = Mage::getModel('sales/order')->loadByIncrementId($lastExportedOrder);
        if ($order) $lastExportedOrder = $order->getOriginalIncrementId()+1;
      } else {
        $lastExportedOrder = $lastExportedOrder+1;
      }
      $types = Mage::helper('export')->getExportTypes();
      $type = strtolower(Mage::getStoreConfig('admin/orderexport/defaulttype'));
      if (!isset($types[$type])) return Mage::helper('export')->errorlog(Mage::helper('export')->__('Observer: Export type not found.'));
      Mage::getModel('export/export')->export($type, $lastExportedOrder, 0, null, null, false, true);
    }
  }
}