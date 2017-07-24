<?php
$installer = $this;
$installer->startSetup();

$installer->run("
		ALTER TABLE {$this->getTable('uploadtool_diamonds_inventory')} ADD `ratio` DECIMAL( 8, 4) NOT NULL ;
		 
");
$installer->endSetup();