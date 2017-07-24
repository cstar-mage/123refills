<?php

$installer = $this;

$installer->startSetup();

$installer->run("
ALTER TABLE `{$this->getTable('ranvi_feed_entity')}`
  ADD COLUMN `iteration_limit` int(32) default '0';
");
$installer->run("
ALTER TABLE `{$this->getTable('ranvi_feed_entity')}`
  ADD COLUMN `use_layer` tinyint(1) NOT NULL default '1';
");


$installer->endSetup();