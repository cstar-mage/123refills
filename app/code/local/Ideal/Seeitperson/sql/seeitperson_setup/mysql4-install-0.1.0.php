<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('seeitperson')};
CREATE TABLE {$this->getTable('seeitperson')} (
  `seeitperson_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `filename` varchar(255) NOT NULL default '',
  `content` text NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `zip_code` varchar(255) NOT NULL default '',
  `phone` varchar(255) NOT NULL default '',
  `psku` varchar(255) NOT NULL default '',  
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`seeitperson_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 