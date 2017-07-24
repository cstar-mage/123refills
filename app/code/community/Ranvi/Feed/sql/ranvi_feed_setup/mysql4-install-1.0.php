<?php

$installer = $this;

$installer->startSetup();

$installer->run("
CREATE TABLE IF NOT EXISTS `{$this->getTable('ranvi_feed_entity')}` (
  `id` smallint(6) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `store_id` smallint(6) NOT NULL,
  `type` smallint(1) NOT NULL,
  `status` smallint(1) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `filter` text,
  `generated_at` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Ranvi Catalog Feed' AUTO_INCREMENT=1;
");

$installer->endSetup(); 