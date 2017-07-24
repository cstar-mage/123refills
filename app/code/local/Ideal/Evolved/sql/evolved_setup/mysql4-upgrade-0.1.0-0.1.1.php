<?php

$installer = $this;

$installer->startSetup();

$installer->run("

ALTER TABLE {$this->getTable('evolved')} MODIFY COLUMN `value` text;

");

$installer->endSetup();