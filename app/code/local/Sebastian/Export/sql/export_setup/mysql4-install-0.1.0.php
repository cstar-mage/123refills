<?php

/**
 *
 * Copyright Sebastian Enzinger <sebastian@enzinger.de> www.sebastian-enzinger.de
 *
 * All rights reserved.
 *
**/

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('export')};
CREATE TABLE IF NOT EXISTS {$this->getTable('export')} (
  `export_id` int(11) unsigned NOT NULL auto_increment,
  `files` text NOT NULL,
  `displayfiles` text NOT NULL,
  `type` varchar(50) NOT NULL default '0',
  `count` int(11) unsigned NOT NULL default '0',
  `ftpupload` int(2) NOT NULL,
  `autoexport` int(2) NOT NULL,
  `downloaded` int(2) NOT NULL,
  `created` datetime default NULL,
  PRIMARY KEY  (`export_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

");

$installer->endSetup(); 

// http://www.magentocommerce.com/wiki/how_to/adding_a_new_attribute ? //

/*
-- ALTER TABLE `{$installer->getTable('sales_order')}` ADD credit decimal(10,4) NOT NULL default '0.0000';

-- INSERT INTO `{$this->getTable('eav_attribute')}` SET entity_type_id='11', attribute_code='credit', backend_type='static', is_global='1', is_visible='1', is_user_defined='0', frontend_input='text', frontend_label='Credit';

$installer->run("

ALTER TABLE `{$this->getTable('customer_entity')}` ADD credit decimal(10,4) NOT NULL default '0.0000';

INSERT INTO `{$this->getTable('eav_attribute')}` SET entity_type_id='1', attribute_code='credit', backend_type='static', is_global='1', is_visible='1', is_user_defined='0', frontend_input='text', frontend_label='Credit';

ALTER TABLE `{$installer->getTable('sales_flat_quote')}` ADD credit decimal(10,4) NOT NULL default '0.0000';

ALTER TABLE `{$installer->getTable('sales_order')}` ADD credit decimal(10,4) NOT NULL default '0.0000';

INSERT INTO `{$this->getTable('eav_attribute')}` SET entity_type_id='11', attribute_code='credit', backend_type='static', is_global='1', is_visible='1', is_user_defined='0', frontend_input='text', frontend_label='Credit';
");
*/