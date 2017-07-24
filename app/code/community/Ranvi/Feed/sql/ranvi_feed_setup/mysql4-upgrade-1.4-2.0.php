<?php

$installer = $this;

$installer->startSetup();

$installer->run("
ALTER TABLE `{$this->getTable('ranvi_feed_entity')}`
  ADD COLUMN `use_disabled` tinyint(1) NOT NULL default '1';
");


$installer->endSetup();