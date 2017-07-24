<?php

/** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$tableOrderGrid = $this->getTable('iwd_sales_archive_order_grid');
$tableInvoiceGrid = $this->getTable('iwd_sales_archive_invoice_grid');
$tableShipGrid = $this->getTable('iwd_sales_archive_shipment_grid');
$tableCmGrid = $this->getTable('iwd_sales_archive_creditmemo_grid');

try {
    $installer->run(
        "ALTER TABLE `{$tableOrderGrid}` DROP FOREIGN KEY `FK_IWD_ORDER_GRID_ARCHIVE_CUSTOMER_ID_CUSTOMER_ENT_ID`;
        ALTER TABLE `{$tableOrderGrid}` DROP FOREIGN KEY `FK_IWD_ORDER_GRID_ARCHIVE_ENT_ID_SALES_FLAT_ORDER_ENT_ID`;
        ALTER TABLE `{$tableOrderGrid}` DROP FOREIGN KEY `FK_IWD_ORDER_GRID_ARCHIVE_STORE_ID_CORE_STORE_STORE_ID`;
        ALTER TABLE `{$tableOrderGrid}` ADD CONSTRAINT `FK_IWD_ORDER_GRID_ARCHIVE_CUSTOMER_ID_CUSTOMER_ENT_ID`
            FOREIGN KEY (`customer_id`) REFERENCES `{$this->getTable('customer_entity')}` (`entity_id`)
            ON UPDATE CASCADE ON DELETE SET NULL;
        ALTER TABLE `{$tableOrderGrid}` ADD CONSTRAINT `FK_IWD_ORDER_GRID_ARCHIVE_ENT_ID_SALES_FLAT_ORDER_ENT_ID`
            FOREIGN KEY (`entity_id`) REFERENCES `{$this->getTable('sales_flat_order')}` (`entity_id`)
            ON UPDATE CASCADE ON DELETE CASCADE;
        ALTER TABLE `{$tableOrderGrid}` ADD CONSTRAINT `FK_IWD_ORDER_GRID_ARCHIVE_STORE_ID_CORE_STORE_STORE_ID`
            FOREIGN KEY (`store_id`) REFERENCES `{$this->getTable('core_store')}` (`store_id`)
            ON UPDATE CASCADE ON DELETE SET NULL;
    
        ALTER TABLE `{$tableInvoiceGrid}` DROP FOREIGN KEY `FK_IWD_INVOICE_GRID_ARCHIVE_ENT_ID_SALES_FLAT_INVOICE_ID`;
        ALTER TABLE `{$tableInvoiceGrid}` DROP FOREIGN KEY `FK_IWD_INVOICE_GRID_ARCHIVE_STORE_ID_CORE_STORE_STORE_ID`;
        ALTER TABLE `{$tableInvoiceGrid}` ADD CONSTRAINT `FK_IWD_INVOICE_GRID_ARCHIVE_ENT_ID_SALES_FLAT_INVOICE_ID`
            FOREIGN KEY (`entity_id`) REFERENCES `{$this->getTable('sales_flat_invoice')}` (`entity_id`)
            ON UPDATE CASCADE ON DELETE CASCADE;
        ALTER TABLE `{$tableInvoiceGrid}` ADD CONSTRAINT `FK_IWD_INVOICE_GRID_ARCHIVE_STORE_ID_CORE_STORE_STORE_ID`
            FOREIGN KEY (`store_id`) REFERENCES `{$this->getTable('core_store')}` (`store_id`)
            ON UPDATE CASCADE ON DELETE SET NULL;
    
        ALTER TABLE `{$tableShipGrid}` DROP FOREIGN KEY `FK_IWD_SHIPMENT_GRID_ARCHIVE_ENT_ID_SALES_FLAT_SHIPMENT_ID`;
        ALTER TABLE `{$tableShipGrid}` DROP FOREIGN KEY `FK_ENT_SHIPMENT_GRID_ARCHIVE_STORE_ID_CORE_STORE_STORE_ID`;
        ALTER TABLE `{$tableShipGrid}` ADD CONSTRAINT `FK_IWD_SHIPMENT_GRID_ARCHIVE_ENT_ID_SALES_FLAT_SHIPMENT_ID`
            FOREIGN KEY (`entity_id`) REFERENCES `{$this->getTable('sales_flat_shipment')}` (`entity_id`)
            ON UPDATE CASCADE ON DELETE CASCADE;
        ALTER TABLE `{$tableShipGrid}` ADD CONSTRAINT `FK_ENT_SHIPMENT_GRID_ARCHIVE_STORE_ID_CORE_STORE_STORE_ID`
            FOREIGN KEY (`store_id`) REFERENCES `{$this->getTable('core_store')}` (`store_id`)
            ON UPDATE CASCADE ON DELETE SET NULL;
    
        ALTER TABLE `{$tableCmGrid}` DROP FOREIGN KEY `FK_IWD_CREDITMEMO_GRID_ARCHIVE_ID_SALES_FLAT_CREDITMEMO_ID`;
        ALTER TABLE `{$tableCmGrid}` DROP FOREIGN KEY `FK_ENT_CREDITMEMO_GRID_ARCHIVE_STORE_ID_CORE_STORE_STORE_ID`;
        ALTER TABLE `{$tableCmGrid}` ADD CONSTRAINT `FK_IWD_CREDITMEMO_GRID_ARCHIVE_ID_SALES_FLAT_CREDITMEMO_ID`
            FOREIGN KEY (`entity_id`) REFERENCES `{$this->getTable('sales_flat_creditmemo')}` (`entity_id`)
            ON UPDATE CASCADE ON DELETE CASCADE;
        ALTER TABLE `{$tableCmGrid}` ADD CONSTRAINT `FK_ENT_CREDITMEMO_GRID_ARCHIVE_STORE_ID_CORE_STORE_STORE_ID`
            FOREIGN KEY (`store_id`) REFERENCES `{$this->getTable('core_store')}` (`store_id`)
            ON UPDATE CASCADE ON DELETE CASCADE;"
    );
} catch (Exception $e) {
    Mage::log($e->getMessage(), null, 'iwd_ordermanager_install.log');
}

$installer->endSetup();