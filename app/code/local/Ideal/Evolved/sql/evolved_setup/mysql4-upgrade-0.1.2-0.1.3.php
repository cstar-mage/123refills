<?php

$installer = $this;

$installer->startSetup();

$installer->getConnection()
->addColumn($installer->getTable('newsletter/subscriber'),
		'created_time',
		array(
				'type' => Varien_Db_Ddl_Table::TYPE_DATETIME,
				'nullable' => false,
				'comment' => 'Subscribe Datetime'
		)
);
$installer->endSetup();