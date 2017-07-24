<?php
/**
 * @copyright   Copyright (c) 2009-2012 Amasty (http://www.amasty.com)
 */ 
$this->startSetup();

$this->run("

ALTER TABLE  `{$this->getTable('amfinder/dropdown')}` 
ADD  `sort` TINYINT( 2 ) NOT NULL ,
ADD  `range` TINYINT( 2 ) NOT NULL

");

$this->endSetup(); 