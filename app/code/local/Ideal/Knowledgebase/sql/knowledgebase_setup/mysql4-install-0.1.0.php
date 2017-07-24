<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('knowledgebase')};
CREATE TABLE {$this->getTable('knowledgebase')} (
  `knowledgebase_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `filename` varchar(255) NOT NULL default '',
  `place` text NOT NULL default '',
  `content` text NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  `start_date` date NULL,
  `end_date` date NULL,
  `start_time` varchar(255) NULL,
  `end_time` varchar(255) NULL,
  PRIMARY KEY (`knowledgebase_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 