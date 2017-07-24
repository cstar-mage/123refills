<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('evolved')};
CREATE TABLE {$this->getTable('evolved')} (
  `evolved_id` int(11) unsigned NOT NULL auto_increment,
  `field` varchar(255) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY (`evolved_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 