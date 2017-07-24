<?php
$installer = $this;
$installer->startSetup();

$installer->run("
		ALTER TABLE {$this->getTable('uploadtool_diamonds_inventory')} ADD `fluorescence_color` VARCHAR( 50 ) NOT NULL;
");
$installer->endSetup();