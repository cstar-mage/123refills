<?php
$installer = $this;
$installer->startSetup();

$installer->run("
		ALTER TABLE {$this->getTable('uploadtool_diamondinquiries')} ADD `created_time`  datetime NOT NULL ;
		ALTER TABLE {$this->getTable('uploadtool_diamondinquiries')} ADD `update_time`  datetime NOT NULL ;
		 
");
$installer->endSetup();  

