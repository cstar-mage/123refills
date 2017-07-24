<?php

/** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

try {
    $installer->run(
        "DROP TABLE IF EXISTS {$this->getTable('iwd_auth_payment_transaction')};
        CREATE TABLE {$this->getTable('iwd_auth_payment_transaction')}(
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `payment_transaction_id` int(10) NULL COMMENT 'Magento Payment Transaction Id',
    
            `transaction_id` varchar(100) DEFAULT NULL COMMENT 'Transaction Id',
            `transaction_type` varchar(100) DEFAULT NULL COMMENT 'Transaction Type',
    
            `auth_transaction_status` varchar(100) DEFAULT NULL COMMENT 'Authorize Transaction Status',
            `mage_transaction_status` varchar(100) DEFAULT NULL COMMENT 'Magento Transaction Status',
    
            `auth_amount_authorized` decimal(12,4) DEFAULT NULL COMMENT 'Amount Authorized',
            `auth_amount_captured` decimal(12,4) DEFAULT NULL COMMENT 'Amount Captured',
            `auth_amount_settlement` decimal(12,4) DEFAULT NULL COMMENT 'Amount Settlement',
            `auth_amount_refund` decimal(12,4) DEFAULT NULL COMMENT 'Amount Refund',
    
            `mage_amount_authorized` decimal(12,4) DEFAULT NULL COMMENT 'Magento Amount Authorized',
            `mage_amount_captured` decimal(12,4) DEFAULT NULL COMMENT 'Magento Amount Captured',
            `mage_amount_settlement` decimal(12,4) DEFAULT NULL COMMENT 'Magento Amount Settlement',
            `mage_amount_refund` decimal(12,4) DEFAULT NULL COMMENT 'Magento Amount Refund',
    
            `order_increment_id`  varchar(100) DEFAULT NULL COMMENT 'Order Increment ID',
            `order_id` int(10) DEFAULT NULL COMMENT 'Order ID',
    
            `status` int(2) NULL COMMENT 'Compare Status',
    
            `created_at` timestamp NULL DEFAULT NULL COMMENT 'Payment Created At',
            PRIMARY KEY (`id`)
        ) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
    );
} catch (Exception $e) {
    Mage::log($e->getMessage(), null, 'iwd_ordermanager_install.log');
}

try {
    $installer->run(
        "ALTER TABLE {$this->getTable('sales/payment_transaction')} ADD COLUMN `amount` DECIMAL (12,4) NULL;"
    );
} catch (Exception $e) {
    Mage::log($e->getMessage(), null, 'iwd_ordermanager_install.log');
}

try {
    $installer->run(
        "ALTER TABLE {$this->getTable('iwd_backup_flat_sales')} ADD COLUMN `entity_id` int (10) DEFAULT NULL;
        ALTER TABLE {$this->getTable('iwd_backup_flat_sales')} ADD COLUMN `after_action` VARCHAR (10) DEFAULT 'delete';"
    );
} catch (Exception $e) {
    Mage::log($e->getMessage(), null, 'iwd_ordermanager_install.log');
}

try {
    $installer->run(
        "ALTER TABLE {$this->getTable('sales/order')} ADD COLUMN `iwd_backup_id` int (10) NULL;"
    );
} catch (Exception $e) {
    Mage::log($e->getMessage(), null, 'iwd_ordermanager_install.log');
}

$installer->endSetup();
