<?php
$installer = $this;

$installer->startSetup();

$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('stud')};
CREATE TABLE {$this->getTable('stud')} (
`diamondstud_id` int(11) unsigned NOT NULL auto_increment,
`shape` varchar(255) NOT NULL default '',
`carat` varchar(255) NOT NULL default '',
`dbfield` varchar(100) NOT NULL default '',
`price` varchar(100) NOT NULL default '',
 PRIMARY KEY (`diamondstud_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");


$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('clarity')};
CREATE TABLE {$this->getTable('clarity')} (
`clarity_id` int(11) unsigned NOT NULL auto_increment,
`label` varchar(255) NOT NULL default '',
`dbfield` varchar(255) NOT NULL default '',
 PRIMARY KEY (`clarity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");


$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('carat')};
CREATE TABLE {$this->getTable('carat')} (
`carat_id` int(11) unsigned NOT NULL auto_increment,
`caratweight` varchar(255) NOT NULL default '',
 PRIMARY KEY (`carat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup(); 