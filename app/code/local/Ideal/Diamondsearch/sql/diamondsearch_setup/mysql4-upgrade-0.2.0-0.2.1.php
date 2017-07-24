<?php
$installer = $this;
$installer->startSetup();

$installer->run("
		ALTER TABLE {$this->getTable('uploadtool_diamonds_inventory')} ADD `special_shape` VARCHAR(255) ;
		ALTER TABLE {$this->getTable('uploadtool_diamonds_inventory')} ADD `full_description` VARCHAR(255) ;
		ALTER TABLE {$this->getTable('uploadtool_diamonds_inventory')} ADD `diamond_polices` VARCHAR(255) ;
		ALTER TABLE {$this->getTable('uploadtool_diamonds_inventory')} ADD `gem_advisor` VARCHAR(255) ;
		ALTER TABLE {$this->getTable('uploadtool_diamonds_inventory')} ADD `gia_facetware` VARCHAR(255) ;
		ALTER TABLE {$this->getTable('uploadtool_diamonds_inventory')} ADD `helium_report` VARCHAR(255) ;
");
$installer->endSetup();