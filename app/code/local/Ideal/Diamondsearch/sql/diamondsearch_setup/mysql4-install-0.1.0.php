<?php
$installer = $this;
$installer->startSetup();
$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('uploadtool_diamonds_inventory')};
CREATE TABLE IF NOT EXISTS {$this->getTable('uploadtool_diamonds_inventory')} (
		`lotno` varchar(255) NOT NULL,
		`owner` varchar(255) NOT NULL,
		`shape` varchar(255) NOT NULL,
		`carat` decimal(8,4) NOT NULL,
		`color` varchar(10) NOT NULL,
		`clarity` varchar(10) NOT NULL,
		`cut` varchar(5) NOT NULL,
		`culet` varchar(10) NOT NULL,
		`crown` varchar(255) DEFAULT NULL,
		`pavilion` varchar(255) DEFAULT NULL,
		`dimensions` varchar(50) NOT NULL,
		`depth` varchar(10) NOT NULL,
		`tabl` varchar(10) NOT NULL,
		`polish` varchar(10) NOT NULL,
		`symmetry` varchar(10) NOT NULL,
		`fluorescence` varchar(10) NOT NULL,
		`girdle` varchar(10) NOT NULL,
		`certificate` varchar(50) NOT NULL,
		`fancy_intensity` varchar(255) DEFAULT NULL,
		`fancycolor` varchar(10) NOT NULL,
		`cost` varchar(255) NOT NULL,
		`totalprice` float NOT NULL,
		`percent_rap` decimal(8,2) NOT NULL,
		`Lab` varchar(10) NOT NULL,
		`stone` int(5) NOT NULL DEFAULT '1',
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`number_stones` varchar(255) NOT NULL,
		`cert_number` varchar(255) NOT NULL,
		`stock_number` varchar(255) NOT NULL,
		`make` varchar(255) NOT NULL,
		`diamond_date` varchar(255) NOT NULL,
		`city` varchar(255) NOT NULL,
		`state` varchar(255) NOT NULL,
		`country` varchar(255) NOT NULL,
		`image` varchar(255) NOT NULL,
		`diamond_image` varchar(100) NOT NULL,
		`diamond_video` varchar(500) NOT NULL,
		`availability` varchar(255) NOT NULL,
		PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
");
$installer->endSetup();
?> 