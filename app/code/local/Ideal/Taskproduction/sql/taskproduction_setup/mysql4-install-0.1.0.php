<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('ideal_taskproduction')};
  CREATE TABLE {$this->getTable('ideal_taskproduction')} (
  `taskproduction_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL DEFAULT '',
  `shape` text NOT NULL,
  `color` text NOT NULL,
  `intensity` text NOT NULL,
  `carat` text NOT NULL,
  `clarity` text NOT NULL,
  `price` text NOT NULL,
  `pricetype` varchar(255) NOT NULL,
  `cutgrade` text NOT NULL,
  `table` text NOT NULL,
  `depth` text NOT NULL,
  `polish` text NOT NULL,  
  `symmetry` text NOT NULL,  
  `dimensions` text NOT NULL,
  `ratio` text NOT NULL,  
  `lab` text NOT NULL,
  `enhancementtype` text NOT NULL,
  `fname` text NOT NULL,
  `lname` text NOT NULL,
  `phoneno` int(100) NOT NULL,
  `email` text NOT NULL,
  `created_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`taskproduction_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

    ");

$installer->endSetup(); 