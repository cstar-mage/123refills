<?php

/** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/** ALTER ORDER HISTORY TABLE **/
try {
    $table = $this->getTable('sales_flat_order_status_history');
    $installer->run(
        "ALTER TABLE {$table} ADD `admin_id` INT NULL DEFAULT NULL;
        ALTER TABLE {$table} ADD `admin_email` VARCHAR(100) NULL DEFAULT NULL;"
    );
} catch (Exception $e) {
    Mage::log($e->getMessage(), null, 'iwd_ordermanager_install.log');
}

/** FLAGS **/
try {
    $installer->run(
        "DROP TABLE IF EXISTS {$this->getTable('iwd_om_flags')};
        CREATE TABLE {$this->getTable('iwd_om_flags')} (
          `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
          `name` varchar(100) NOT NULL DEFAULT '',
          `icon_type` varchar(10) NOT NULL DEFAULT '',
          `icon_fa` varchar(50) DEFAULT NULL,
          `icon_fa_color` varchar(10) DEFAULT NULL,
          `icon_img` varchar(255) DEFAULT NULL,
          `comment` varchar(255) DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;"
    );
} catch (Exception $e) {
    Mage::log($e->getMessage(), null, 'iwd_ordermanager_install.log');
}

/** FLAGS TYPES **/
try {
    $installer->run(
        "DROP TABLE IF EXISTS {$this->getTable('iwd_om_flags_types')};
        CREATE TABLE {$this->getTable('iwd_om_flags_types')} (
          `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
          `name` varchar(100) NOT NULL DEFAULT '',
          `comment` varchar(255) DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;"
    );
} catch (Exception $e) {
    Mage::log($e->getMessage(), null, 'iwd_ordermanager_install.log');
}

/** FLAGS FOR ORDERS **/
try {
    $installer->run(
        "DROP TABLE IF EXISTS {$this->getTable('iwd_om_flags_orders')};
        CREATE TABLE {$this->getTable('iwd_om_flags_orders')} (
          `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
          `flag_id` int(11) NOT NULL,
          `order_id` int(11) NOT NULL,
          `type_id` int(11) DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
    );
} catch (Exception $e) {
    Mage::log($e->getMessage(), null, 'iwd_ordermanager_install.log');
}

/** FLAG-TYPE RELATION **/
try {
    $installer->run(
        "DROP TABLE IF EXISTS {$this->getTable('iwd_om_flags_flag_type')};
        CREATE TABLE {$this->getTable('iwd_om_flags_flag_type')} (
          `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
          `flag_id` int(11) NOT NULL,
          `type_id` int(11) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
    );
} catch (Exception $e) {
    Mage::log($e->getMessage(), null, 'iwd_ordermanager_install.log');
}

/** FLAG-AUTO_APPLY RELATION **/
try {
    $installer->run(
        "DROP TABLE IF EXISTS {$this->getTable('iwd_om_flags_autoapply')};
        CREATE TABLE {$this->getTable('iwd_om_flags_autoapply')} (
          `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
          `flag_id` int(11) NOT NULL,
          `apply_type` varchar(15) NOT NULL DEFAULT '',
          `key` varchar(255) NOT NULL DEFAULT '',
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
    );
} catch (Exception $e) {
    Mage::log($e->getMessage(), null, 'iwd_ordermanager_install.log');
}

/** INSTALL DATA **/
try {
    $installer->run(
        "INSERT INTO {$this->getTable('iwd_om_flags_types')}
            (`id`, `name`, `comment`)
        VALUES (1, 'Label', 'Default Column for Labels');

        INSERT INTO {$this->getTable('iwd_om_flags')}
            (`id`, `name`, `icon_type`, `icon_fa`, `icon_fa_color`, `icon_img`, `comment`)
        VALUES ('1', 'Black', 'font', ' fa-flag', '#000000', NULL, 'Black Label'),
            ('2', 'Blue', 'font', ' fa-flag', '#00a7fe', NULL, 'Blue Label'),
            ('3', 'Brown', 'font', ' fa-flag', '#8f4000', NULL, 'Brown Label'),
            ('4', 'Gray', 'font', ' fa-flag', '#b6b6b5', NULL, 'Gray Label'),
            ('5', 'Green', 'font', ' fa-flag', '#45b600', NULL, 'Green Label'),
            ('6', 'Orange', 'font', ' fa-flag', '#ff6000', NULL, 'Orange Label'),
            ('7', 'Pink', 'font', ' fa-flag', '#ff4385', NULL, 'Pink Label'),
            ('8', 'Purple', 'font', ' fa-flag', '#8e00d7', NULL, 'Purple Label'),
            ('9', 'Red', 'font', ' fa-flag', '#ee0101', NULL, 'Red Label'),
            ('10', 'Yellow', 'font', ' fa-flag', '#efbf00', NULL, 'Yellow Label');

        INSERT INTO {$this->getTable('iwd_om_flags_flag_type')} (`flag_id`, `type_id`)
        VALUES ('1','1'), ('2','1'), ('3','1'), ('4','1'), ('5','1'), 
            ('6','1'), ('7','1'), ('8','1'), ('9','1'), ('10','1');"
    );
} catch (Exception $e) {
    Mage::log($e->getMessage(), null, 'iwd_ordermanager_install.log');
}

$installer->endSetup();
