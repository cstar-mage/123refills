<?php

$installer = $this;

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');

$installer->startSetup();


$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('eternity_applied_rule')};
CREATE TABLE {$this->getTable('eternity_applied_rule')} ( 
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `price_from` varchar(255) NOT NULL,
  `price_to` varchar(255) NOT NULL,
  `price_increase` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->run("
   -- DROP TABLE IF EXISTS {$this->getTable('eternity_dia_price')};
   CREATE TABLE {$this->getTable('eternity_dia_price')} (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shape` varchar(255) NOT NULL,
  `carat` varchar(255) NOT NULL,
  `fvs2price` float NOT NULL,
  `gs11price` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->run("
  -- DROP TABLE IF EXISTS {$this->getTable('eternity_ring_cost')};
  CREATE TABLE {$this->getTable('eternity_ring_cost')} (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `size` float NOT NULL,
  `14k_gold` float NOT NULL,
  `18k_gold` float NOT NULL,
  `platinum` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->run("
  -- DROP TABLE IF EXISTS {$this->getTable('eternity_stone_qty')};
  CREATE TABLE {$this->getTable('eternity_stone_qty')} (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shape` varchar(255) NOT NULL,
  `ring_size` float NOT NULL,
  `0_5ct` int(5) NOT NULL,
  `0_10ct` int(5) NOT NULL,
  `0_15ct` int(5) NOT NULL,
  `0_20ct` int(5) NOT NULL,
  `0_25ct` int(5) NOT NULL,
  `0_33ct` int(5) NOT NULL,
  `0_40ct` int(5) NOT NULL,
  `0_50ct` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup(); 