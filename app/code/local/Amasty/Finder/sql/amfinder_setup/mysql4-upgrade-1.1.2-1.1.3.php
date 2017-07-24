<?php
/**
 * @copyright   Copyright (c) 2009-2012 Amasty (http://www.amasty.com)
 */ 
$this->startSetup();

$this->run("
ALTER TABLE `{$this->getTable('amfinder/map')}` ADD `id` INT( 10 ) NOT NULL AUTO_INCREMENT FIRST ,ADD PRIMARY KEY ( `id` )
");

$this->endSetup(); 