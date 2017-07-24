<?php

/** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

try {
    $installer->run(
        "ALTER TABLE {$this->getTable('iwd_om_flags_autoapply')} CHANGE `key` `method_key` VARCHAR(255)
        CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';"
    );
} catch (Exception $e) {
    Mage::log($e->getMessage(), null, 'iwd_ordermanager_install.log');
}

try {
    $code = Mage_Paygate_Model_Authorizenet::METHOD_CODE;
    $installer->run(
        "UPDATE {$this->getTable('sales_flat_order_payment')} SET `cc_number_enc` = NULL WHERE `method` = '{$code}';"
    );
} catch (Exception $e) {
    Mage::log($e->getMessage(), null, 'iwd_ordermanager_install.log');
}

$installer->endSetup();
