<?php
$installer = $this;
$installer->startSetup();

$installer->run("
	ALTER TABLE {$this->getTable('uploadtool_diamonds_inventory')} ADD `bankwire_price` DECIMAL( 12, 2 ) NULL DEFAULT NULL ;
");

$installer->run("
CREATE TABLE IF NOT EXISTS {$this->getTable('uploadtool_diamonds_images')} (
  `lotno` varchar(255) NOT NULL,
  `image_flag` tinyint(2) DEFAULT NULL,
  UNIQUE KEY `lotno` (`lotno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
");

$installer->endSetup();
