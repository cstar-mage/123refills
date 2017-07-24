<?php

/** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

/*************** iwd_cataloginventory_stock_address ***************/
try {
    $installer->run(
        "DROP TABLE IF EXISTS {$this->getTable('iwd_cataloginventory_stock_address')};
        CREATE TABLE {$this->getTable('iwd_cataloginventory_stock_address')}(
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `stock_id` smallint(5) NOT NULL,
            `street` varchar(255) DEFAULT NULL COMMENT 'Street',
            `city` varchar(255) DEFAULT NULL COMMENT 'City',
            `region_id` int(11) DEFAULT NULL COMMENT 'Region Id',
            `region` varchar(255) DEFAULT NULL COMMENT 'Region',
            `postcode` varchar(255) DEFAULT NULL COMMENT 'Postcode',
            `country_id` varchar(2) NOT NULL COMMENT 'Country Id',
            PRIMARY KEY (`id`, `stock_id`, `country_id`),
            KEY `IDX_CATALOGINVENTORY_STOCK_ADDRESS_IWD_STOCK_ID` (`stock_id`),
            KEY `IDX_CATALOGINVENTORY_STOCK_ADDRESS_IWD_COUNTRY_ID` (`country_id`),
            CONSTRAINT `FK_IWD_STOCK_ADDR_STOCK_ID_CATINV_STOCK_STOCK_ID` FOREIGN KEY (`stock_id`) 
            REFERENCES {$this->getTable('cataloginventory_stock')} (`stock_id`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='Stock Address';"
    );
} catch (Exception $e) {
    Mage::log($e->getMessage(), null, 'iwd_ordermanager_install.log');
}

/*************** iwd_cataloginventory_stock_store ***************/
try {
    $installer->run(
        "DROP TABLE IF EXISTS {$this->getTable('iwd_cataloginventory_stock_store')};
        CREATE TABLE {$this->getTable('iwd_cataloginventory_stock_store')}(
            `stock_id` smallint(6) NOT NULL COMMENT 'Page ID',
            `store_id` smallint(5) unsigned NOT NULL COMMENT 'Store ID',
            PRIMARY KEY (`stock_id`,`store_id`),
            CONSTRAINT `FK_IWD_STOCK_STORE_STOCK_ID_CATINV_STOCK_STOCK_ID` FOREIGN KEY (`stock_id`)
            REFERENCES {$this->getTable('cataloginventory_stock')} (`stock_id`) ON DELETE CASCADE ON UPDATE CASCADE,
            CONSTRAINT `FK_IWD_STOCK_STORE_STORE_ID_CORE_STORE_STORE_ID` FOREIGN KEY (`store_id`)
            REFERENCES {$this->getTable('core_store')} (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Stock To Store Linkage Table';"
    );
} catch (Exception $e) {
    Mage::log($e->getMessage(), null, 'iwd_ordermanager_install.log');
}

/*************** iwd_cataloginventory_stock_order_item ***************/
try {
    $installer->run(
        "DROP TABLE IF EXISTS {$this->getTable('iwd_cataloginventory_stock_order_item')};
        CREATE TABLE {$this->getTable('iwd_cataloginventory_stock_order_item')}(
            `stock_id` smallint(6) NOT NULL COMMENT 'Page ID',
            `order_id` int(10) unsigned NOT NULL COMMENT 'Order ID',
            `order_item_id` int(10) unsigned NOT NULL COMMENT 'Order Item ID',
            `qty_stock_assigned` decimal(12,4) DEFAULT '0.0000' COMMENT 'Qty',
            PRIMARY KEY (`stock_id`,`order_item_id`),
            CONSTRAINT `FK_IWD_ORDER_ITEM_STORE_STOCK_ID_CATINV_STOCK_STOCK_ID` FOREIGN KEY (`stock_id`)
            REFERENCES {$this->getTable('cataloginventory_stock')} (`stock_id`) ON DELETE CASCADE ON UPDATE CASCADE,
            CONSTRAINT `FK_IWD_ORDER_ITEM_STORE_STORE_ID_ORDER_ITEM_ID` FOREIGN KEY (`order_item_id`)
            REFERENCES {$this->getTable('sales_flat_order_item')} (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Stock To Order Item Table';"
    );
} catch (Exception $e) {
    Mage::log($e->getMessage(), null, 'iwd_ordermanager_install.log');
}

/*************** iwd_cataloginventory_stock_order ***************/
try {
    $installer->run(
        "DROP TABLE IF EXISTS {$this->getTable('iwd_cataloginventory_stock_order')};
        CREATE TABLE {$this->getTable('iwd_cataloginventory_stock_order')}(
            `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Order ID',
            `qty_assigned` decimal(12,4) DEFAULT '0.0000' COMMENT 'Items Assigned To Stock',
            `qty_ordered` decimal(12,4) DEFAULT '0.0000'
                  COMMENT 'Ordered Items Qty (without virtual products, canceled and refunded items)',
            `assigned` smallint(2) DEFAULT '0' COMMENT 'Is Order Assigned To Stock',
            PRIMARY KEY (`order_id`),
            CONSTRAINT `FK_IWD_ORDER_STORE_STORE_ID_ORDER_ID` FOREIGN KEY (`order_id`)
            REFERENCES {$this->getTable('sales_flat_order')} (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Stock To Order Table';"
    );
} catch (Exception $e) {
    Mage::log($e->getMessage(), null, 'iwd_ordermanager_install.log');
}

/************** add inventory column to order grid *************/
try {
    $columns = Mage::getStoreConfig('iwd_ordermanager/grid_order/columns');
    $items = Mage::getModel('core/config_data')->getCollection()
        ->addFieldToFilter('path', 'iwd_ordermanager/grid_order/columns');

    if ($items->getSize() > 0) {
        $columns = $items->getFirstItem()->getValue();
        if (!empty($columns)) {
            $columns = explode(',', $columns);
            array_unshift($columns, 'inventory');
            $columns = implode(',', $columns);
            Mage::getConfig()->saveConfig('iwd_ordermanager/grid_order/columns', $columns, 'default', 0);
        }
    }
} catch (Exception $e) {
    Mage::log($e->getMessage(), null, 'iwd_ordermanager_install.log');
}


$installer->endSetup();