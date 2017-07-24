<?php

/** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/** ORDER **/
try {
    $installer->run(
        "ALTER TABLE `{$this->getTable('sales/order')}` ADD `iwd_om_status` int(2) DEFAULT 0;"
    );
} catch (Exception $e) {
    Mage::log($e->getMessage(), null, 'iwd_ordermanager_install.log');
}

$installer->endSetup();
