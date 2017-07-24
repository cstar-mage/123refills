<?php
$installer = $this;

$installer->startSetup();

$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('stud')};
CREATE TABLE {$this->getTable('stud')} (
`diamondstud_id` int(11) unsigned NOT NULL auto_increment,
`shape` varchar(255) NOT NULL default '',
`carat` varchar(255) NOT NULL default '',
`fgvs` varchar(100) NOT NULL default '',
`fgsi` varchar(100) NOT NULL default '',
`fgind` varchar(100) NOT NULL default '',
`hivs` varchar(100) NOT NULL default '',
`hisi` varchar(100) NOT NULL default '',
`hiind` varchar(100) NOT NULL default '',
`jkvs` varchar(100) NOT NULL default '',
`jksi` varchar(100) NOT NULL default '',
`jkind` varchar(100) NOT NULL default '',
  PRIMARY KEY (`diamondstud_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup(); 