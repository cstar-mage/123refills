<?php

$installer = $this;

$installer->startSetup();

$installer->run("

ALTER TABLE {$this->getTable('evolved')} ADD COLUMN `type` text;

");

$installer->endSetup();