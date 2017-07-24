<?php
$installer = $this;

$installer->startSetup();
$installer->run("

ALTER TABLE `{$installer->getTable('watches_import_codes')}` ADD `use_in_update` INTEGER( 11 ) NOT NULL ;

");
$installer->endSetup();