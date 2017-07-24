<?php
$installer = $this;

$installer->startSetup();
$installer->run("

ALTER TABLE `{$installer->getTable('jewelryshare_import_codes')}` ADD `use_in_update` INTEGER( 11 ) NOT NULL ;

");
$installer->endSetup();