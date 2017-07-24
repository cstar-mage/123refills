<?php
/**
 *
 * Created by:  Milan Simek
 * Company:     Plugin Company
 *
 * LICENSE: http://plugin.company/docs/magento-extensions/magento-extension-license-agreement
 *
 * YOU WILL ALSO FIND A PDF COPY OF THE LICENSE IN THE DOWNLOADED ZIP FILE
 *
 * FOR QUESTIONS AND SUPPORT
 * PLEASE DON'T HESITATE TO CONTACT US AT:
 *
 * SUPPORT@PLUGIN.COMPANY
 *
 */


/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$blockTable = $installer->getTable('plugincompany_cmsrevisions/block');
$pageTable = $installer->getTable('plugincompany_cmsrevisions/page');

$sql = "
DROP TABLE IF EXISTS `{$pageTable}`;

CREATE TABLE `{$pageTable}` (
    `plugincompany_cms_page_id` int(10) NOT NULL AUTO_INCREMENT,
    `admin_user_id` SMALLINT(6) NOT NULL COMMENT 'User ID',
	`page_id` SMALLINT(6) NOT NULL COMMENT 'Page ID',
	`title` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Page Title',
	`root_template` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Page Template',
	`meta_keywords` TEXT NULL COMMENT 'Page Meta Keywords',
	`meta_description` TEXT NULL COMMENT 'Page Meta Description',
	`identifier` VARCHAR(100) NOT NULL COMMENT 'Page String Identifier',
	`content_heading` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Page Content Heading',
	`content` MEDIUMTEXT NULL COMMENT 'Page Content',
	`revision_created_on` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`is_active` SMALLINT(6) NOT NULL DEFAULT '1' COMMENT 'Is Page Active',
	`sort_order` SMALLINT(6) NOT NULL DEFAULT '0' COMMENT 'Page Sort Order',
	`layout_update_xml` TEXT NULL COMMENT 'Page Layout Update Content',
	`custom_theme` VARCHAR(100) NULL DEFAULT NULL COMMENT 'Page Custom Theme',
	`custom_root_template` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Page Custom Template',
	`custom_layout_update_xml` TEXT NULL COMMENT 'Page Custom Layout Update Content',
	`custom_theme_from` DATE NULL DEFAULT NULL COMMENT 'Page Custom Theme Active From Date',
	`custom_theme_to` DATE NULL DEFAULT NULL COMMENT 'Page Custom Theme Active To Date',
	 `is_current_revision` SMALLINT(1) NOT NULL COMMENT 'Current revision yes/no',
	  PRIMARY KEY (`plugincompany_cms_page_id`)
  )
;

DROP TABLE IF EXISTS `{$blockTable}`;

CREATE TABLE {$blockTable} (
    `plugincompany_cms_block_id` int(10) NOT NULL AUTO_INCREMENT,
    `admin_user_id` SMALLINT(6) NOT NULL COMMENT 'User ID',
	`block_id` SMALLINT(6) NOT NULL COMMENT 'Block ID',
    `revision_created_on` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`title` VARCHAR(255) NOT NULL COMMENT 'Block Title',
	`identifier` VARCHAR(255) NOT NULL COMMENT 'Block String Identifier',
	`content` MEDIUMTEXT NULL COMMENT 'Block Content',
	`creation_time` TIMESTAMP NULL DEFAULT NULL COMMENT 'Block Creation Time',
	`update_time` TIMESTAMP NULL DEFAULT NULL COMMENT 'Block Modification Time',
	`is_active` SMALLINT(6) NOT NULL DEFAULT '1' COMMENT 'Is Block Active',
    `is_current_revision` SMALLINT(1) NOT NULL COMMENT 'Current revision yes/no',
	PRIMARY KEY (`plugincompany_cms_block_id`)
)
";
$installer->run($sql);
$installer->endSetup();

//save first revisions
foreach (Mage::getModel('cms/page')->getCollection() as $page) {
    Mage::getModel('plugincompany_cmsrevisions/page')->setData($page->getData())->save();
}

foreach (Mage::getModel('cms/block')->getCollection() as $block) {
    Mage::getModel('plugincompany_cmsrevisions/block')->setData($block->getData())->save();
}