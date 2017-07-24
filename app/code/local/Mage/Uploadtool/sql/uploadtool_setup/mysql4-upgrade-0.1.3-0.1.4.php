<?php
$installer = $this;
$installer->startSetup();

$installer->run("
		ALTER TABLE {$this->getTable('uploadtool_diamondinquiries')} ADD `sku`  varchar(255) NOT NULL ;
		ALTER TABLE {$this->getTable('uploadtool_diamondinquiries')} ADD `vendor`  varchar(255) NOT NULL ;
		 
");
$installer->endSetup();  
