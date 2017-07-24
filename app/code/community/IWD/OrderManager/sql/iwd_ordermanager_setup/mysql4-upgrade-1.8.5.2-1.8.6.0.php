<?php

/** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/** QUOTE **/
try {
    $installer->run(
        "ALTER TABLE `{$this->getTable('sales/quote')}` ADD `iwd_om_fee_amount_incl_tax` DECIMAL(12,2) NULL;
         ALTER TABLE `{$this->getTable('sales/quote')}` ADD `iwd_om_fee_base_amount_incl_tax` DECIMAL(10,2) NULL;
         ALTER TABLE `{$this->getTable('sales/quote')}` ADD `iwd_om_fee_tax_percent` DECIMAL(10,2) NULL;"
    );
} catch (Exception $e) {
    Mage::log($e->getMessage(), null, 'iwd_ordermanager_install.log');
}

/** QUOTE ADDRESS **/
try {
    $installer->run(
        "ALTER TABLE `{$this->getTable('sales/quote_address')}` ADD `iwd_om_fee_amount_incl_tax` DECIMAL(12,2) NULL;
        ALTER TABLE `{$this->getTable('sales/quote_address')}` ADD `iwd_om_fee_base_amount_incl_tax` DECIMAL(10,2) NULL;
        ALTER TABLE `{$this->getTable('sales/quote_address')}` ADD `iwd_om_fee_tax_percent` DECIMAL(10,2) NULL;"
    );
} catch (Exception $e) {
    Mage::log($e->getMessage(), null, 'iwd_ordermanager_install.log');
}

/** ORDER **/
try {
    $installer->run(
        "ALTER TABLE `{$this->getTable('sales/order')}` ADD `iwd_om_fee_amount_incl_tax` DECIMAL(10,2) NULL;
        ALTER TABLE `{$this->getTable('sales/order')}` ADD `iwd_om_fee_base_amount_incl_tax` DECIMAL(10,2) NULL;
        ALTER TABLE `{$this->getTable('sales/order')}` ADD `iwd_om_fee_tax_percent` DECIMAL(10,2) NULL;"
    );
} catch (Exception $e) {
    Mage::log($e->getMessage(), null, 'iwd_ordermanager_install.log');
}

/** INVOICE **/
try {
    $installer->run(
        "ALTER TABLE `{$this->getTable('sales/invoice')}` ADD `iwd_om_fee_amount_incl_tax` DECIMAL(10,2) NULL;
        ALTER TABLE `{$this->getTable('sales/invoice')}` ADD `iwd_om_fee_base_amount_incl_tax` DECIMAL(10,2) NULL;"
    );
} catch (Exception $e) {
    Mage::log($e->getMessage(), null, 'iwd_ordermanager_install.log');
}

/** CREDIT MEMO **/
try {
    $installer->run(
        "ALTER TABLE `{$this->getTable('sales/creditmemo')}` ADD `iwd_om_fee_amount_incl_tax` DECIMAL(10,2) NULL;
        ALTER TABLE `{$this->getTable('sales/creditmemo')}` ADD `iwd_om_fee_base_amount_incl_tax` DECIMAL(10,2) NULL;"
    );
} catch (Exception $e) {
    Mage::log($e->getMessage(), null, 'iwd_ordermanager_install.log');
}

$installer->endSetup();
