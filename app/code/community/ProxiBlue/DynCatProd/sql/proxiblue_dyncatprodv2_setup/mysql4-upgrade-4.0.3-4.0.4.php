<?php

/**
 * Create tempory table used for category ids storage used in subselects
 *
 * @category  ProxiBlue
 * @package   DynCatProd
 * @author    Lucas van Staden <sales@proxiblue.com.au>
 * @copyright 2016 Lucas van Staden (ProxiBlue)
 * @license   http://www.proxiblue.com.au/eula EULA
 * @link      http://www.proxiblue.com.au
 */
$installer = $this;
$installer->startSetup();

$magentoVersion = Mage::getVersionInfo();
if ($magentoVersion['minor'] < 6) {

    $installer->run(
        "
    DROP TABLE IF EXISTS {$installer->getTable('dyncatprod/subselect')};
CREATE TABLE {$installer->getTable('dyncatprod/subselect')} (
  `category_id` int(10) unsigned NOT NULL COMMENT 'Category id',
  `product_id` int(10) unsigned NOT NULL COMMENT 'Product id',
  KEY `IDX_DYNCATPROD_CATEGORY_ID` (`category_id`),
  CONSTRAINT `FK_CAT_ID_TO_SUBSELECT_CAT_ID` FOREIGN KEY (`category_id`) REFERENCES `{$installer->getTable(
        'catalog/category'
    )}` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_PROD_ID_TO_SUBSELECT_PROD_ID` FOREIGN KEY (`product_id`) REFERENCES `{$installer->getTable(
        'catalog/product'
    )}` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Temp storage of subselect data, used in place of PHP arrays to solve array out of memory issues';
"
    );

} else {

    $installer->run(
        "
    DROP TABLE IF EXISTS {$installer->getTable('dyncatprod/subselect')};
CREATE TABLE {$installer->getTable('dyncatprod/subselect')} (
  `category_id` INT NOT NULL COMMENT 'Category id',
  `product_id` INT NOT NULL COMMENT 'Product id',
  KEY `IDX_DYNCATPROD_CATEGORY_ID` (`category_id`),
  CONSTRAINT `FK_CAT_ID_TO_SUBSELECT_CAT_ID` FOREIGN KEY (`category_id`) REFERENCES `{$installer->getTable(
        'catalog/category'
    )}` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_PROD_ID_TO_SUBSELECT_PROD_ID` FOREIGN KEY (`product_id`) REFERENCES `{$installer->getTable(
        'catalog/product'
    )}` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Temp storage of subselect data, used in place of PHP arrays to solve array out of memory issues';
"
    );

}
$installer->endSetup();



$installer->endSetup();

