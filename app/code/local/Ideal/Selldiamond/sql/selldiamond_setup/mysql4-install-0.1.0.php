<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('selldiamond')};
CREATE TABLE {$this->getTable('selldiamond')} (
  `selldiamond_id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `phone1` varchar(255) NOT NULL default '',
  `phone2` varchar(255) NOT NULL default '',
  `contact_time` varchar(255) NOT NULL default '',
  `shape` varchar(255) NOT NULL default '',
  `weight` varchar(255) NOT NULL default '',
  `price` varchar(255) NOT NULL default '',
  `certification` varchar(255) NOT NULL default '',
  `certificationtype` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `filename` varchar(255) NOT NULL default '',
  `content` text NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`selldiamond_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 