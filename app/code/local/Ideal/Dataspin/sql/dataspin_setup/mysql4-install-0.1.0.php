<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('dataspin_settings')};
CREATE TABLE {$this->getTable('dataspin_settings')} (
  `dataspin_id` int(11) unsigned NOT NULL auto_increment,
  `field` varchar(255) NOT NULL default '',
  `value` text NOT NULL default '',
  `update_time` datetime NULL,
  PRIMARY KEY (`dataspin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 