<?php

$installer = $this;

$installer->startSetup();

/**
 * Create table 'watches_import_codes'
 */
$table = $installer->getConnection()
		->newTable($installer->getTable('watches_import_codes'))
		->addColumn('code_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
				'identity'  => true,
				'unsigned'  => true,
				'nullable'  => false,
				'primary'   => true,
		), 'Code id')
		->addColumn('import_code', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
				'nullable'  => false,
		), 'Import type')
		->addColumn('eav_code', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
				'nullable'  => false,
		), 'EAV code')
		->addColumn('watch_imported', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
				'nullable'  => false,
		), 'Is imported')
		->setComment('Jewelerslink watches import codes');
$installer->getConnection()->createTable($table);

$this->addAttribute('catalog_product', 'watch_imported', array(
		'group'                    => 'General',
		'type'                     => 'int',
		'input'                    => 'select',
		'label'                    => 'Publish Watch In Jewelerslink',
		'global'                   => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible'                  => 1,
		'required'                 => 0,
		'visible_on_front'         => 0,
		'is_html_allowed_on_front' => 0,
		'is_configurable'          => 0,
		'source'                   => 'eav/entity_attribute_source_boolean',
		'searchable'               => 0,
		'filterable'               => 0,
		'comparable'               => 0,
		'unique'                   => false,
		'user_defined'             => false,
		'is_user_defined'          => false,
		'used_in_product_listing'  => true
));

$installer->run("
		-- DROP TABLE IF EXISTS {$this->getTable('watches_priceincrease')};
		CREATE TABLE {$this->getTable('watches_priceincrease')} (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`price_from` varchar(255) NOT NULL,
		`price_to` varchar(255) NOT NULL,
		`price_increase` varchar(255) NOT NULL,
		PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->run("
	-- DROP TABLE IF EXISTS {$this->getTable('watches_vendor')};
	CREATE TABLE {$this->getTable('watches_vendor')} (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`vendor_name` varchar(255) NOT NULL,
	`vendor_id` int(11) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `id` (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");

$installer->endSetup(); 