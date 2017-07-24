<?php
$installer = $this;
$installer->startSetup();

$installer->run("
		ALTER TABLE {$this->getTable('uploadtool_diamonds_inventory')} ADD `diam_identifier`  text NOT NULL ;
		 
");
$installer->endSetup();
