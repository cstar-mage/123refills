<?php
$installer = $this;

$installer->startSetup();

$installer->run("
		CREATE TABLE IF NOT EXISTS {$this->getTable('uploadtool_settings')} (
		`settings_id` int(11) NOT NULL AUTO_INCREMENT,
		`field` varchar(255) NOT NULL,
		`value` varchar(255) NOT NULL,
		PRIMARY KEY (`settings_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		
		CREATE TABLE IF NOT EXISTS {$this->getTable('uploadtool_price_increase')} (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `price_from` varchar(255) NOT NULL,
		  `price_to` varchar(255) NOT NULL,
		  `price_increase` varchar(255) NOT NULL,
	  	   PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	
		CREATE TABLE IF NOT EXISTS `uploadtool_vendor` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `vendor_name` varchar(255) NOT NULL,
			  `vendor_id` int(11) NOT NULL,
			  `rap_percent` float NOT NULL,
			  PRIMARY KEY (`id`),
			  UNIQUE KEY `id` (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		CREATE TABLE IF NOT EXISTS `uploadtool_diamonds_inventory` (
			  `lotno` varchar(255) NOT NULL,
			  `owner` varchar(255) NOT NULL,
			  `shape` varchar(255) NOT NULL,
			  `carat` varchar(10) NOT NULL,
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
			  `percent_rap` varchar(255) NOT NULL,
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
			  PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup();