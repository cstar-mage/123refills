<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('customcontactnew')};
CREATE TABLE {$this->getTable('customcontactnew')} (
  `customcontact_id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',  
  `email` varchar(255) NOT NULL default '',
  `zipcode` varchar(255) NOT NULL default '',
  `phone` varchar(255) NOT NULL default '',  
  `contactpreference` varchar(55) NOT NULL default '',
  `comments` varchar(255) NOT NULL default '',
  `appointmentdate` date NOT NULL,
  `appointmenttime` varchar(55) NOT NULL default '',
  `interestedin` varchar(255) NOT NULL default '',
  `productname` varchar(255) NOT NULL default '',
  `productsku` varchar(255) NOT NULL default '',
  `producturl` varchar(255) NOT NULL default '',
  `producttype` varchar(255) NOT NULL default '',
  `created_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`customcontact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 