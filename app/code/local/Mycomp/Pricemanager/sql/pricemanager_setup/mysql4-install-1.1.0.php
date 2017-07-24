<?php

$installer = $this;

$installer->startSetup();

	
$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('pricemanager')};
CREATE TABLE {$this->getTable('pricemanagermain')} (
  `main_id` int(11) unsigned NOT NULL auto_increment,
  `metal` varchar(100) NOT NULL default '',
  `price` float(9,2) NOT NULL default '0',
  `updated` datetime NULL,
  PRIMARY KEY (`main_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");

$installer->endSetup(); 