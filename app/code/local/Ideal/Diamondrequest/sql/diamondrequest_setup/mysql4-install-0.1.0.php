<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('diamondrequest')};
CREATE TABLE {$this->getTable('diamondrequest')} (
  `diamondrequest_id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',  
  `email` varchar(255) NOT NULL default '',
  `zipcode` varchar(255) NOT NULL default '',
  `phone` varchar(255) NOT NULL default '',  
  `caratsizefrom` varchar(255) NOT NULL default '',
  `caratsizeto` varchar(255) NOT NULL default '',  
  `colorfrom` varchar(255) NOT NULL default '',
  `colorto` varchar(255) NOT NULL default '',  
  `clarityfrom` varchar(255) NOT NULL default '',
  `clarityto` varchar(255) NOT NULL default '',  
  `pricerangefrom` varchar(255) NOT NULL default '',
  `pricerangeto` varchar(255) NOT NULL default '',  
  `lab` varchar(255) NOT NULL default '',  
  `productname` varchar(255) NOT NULL default '',
  `productsku` varchar(255) NOT NULL default '',
  `producturl` varchar(255) NOT NULL default '',
  `producttype` varchar(255) NOT NULL default '',
  `stonetype` varchar(255) NOT NULL default '',
  `created_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`diamondrequest_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 