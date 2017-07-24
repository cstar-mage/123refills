<?php
$installer = $this;
/* @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */

$installer->startSetup();
$installer->run("
	ALTER TABLE `{$installer->getTable('slideshow')}` 
		ADD (
				`desktop_img` text NULL,
				`landscape_ipad_img` text NULL,
				`portrait_ipad_img` text NULL,
				`mobile_img` text NULL
			);
");
$installer->endSetup();