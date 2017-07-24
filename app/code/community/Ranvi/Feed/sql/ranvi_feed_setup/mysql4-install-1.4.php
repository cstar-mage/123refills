<?php

$installer = $this;

$installer->startSetup();

$installer->run("
CREATE TABLE `{$this->getTable('ranvi_feed_entity')}` (
  `id` smallint(6) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `store_id` smallint(6) NOT NULL,
  `type` varchar(32) NOT NULL,
  `status` smallint(1) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `filter` text,
  `generated_at` datetime NOT NULL default '0000-00-00 00:00:00',
  `cron_started_at` datetime NOT NULL default '0000-00-00 00:00:00',
  `uploaded_at` datetime NOT NULL default '0000-00-00 00:00:00',
  `show_headers` tinyint(1) default NULL,
  `enclosure` varchar(32) default NULL,
  `delimiter` varchar(32) default NULL,
  `remove_lb` tinyint(1) DEFAULT '0',
  `iteration_limit` int(32) default '0',
  `use_layer` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Ranvi Catalog Feed' AUTO_INCREMENT=1;
");
$installer->endSetup(); 