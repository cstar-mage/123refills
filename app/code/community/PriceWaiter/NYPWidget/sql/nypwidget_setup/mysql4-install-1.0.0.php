<?php
/*
 * Copyright 2013-2015 Price Waiter, LLC
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */

// Product types supported by the Name Your Price Widget
// $supportTypeIds = array('simple', 'configurable');
$installer = $this;
$installer->startSetup();

// Create a table to store category information --
// Magento's Category attributes are not stable enough to bolt onto,
// especially in bigger stores.
$installer->run("
DROP TABLE IF EXISTS {$this->getTable('nypwidget_category')};
CREATE TABLE {$this->getTable('nypwidget_category')} (
	PRIMARY KEY (`entity_id`),
	`entity_id` int(11) unsigned NOT NULL auto_increment,
	`category_id` int(11) unsigned NOT NULL,
	`store_id` int(11) unsigned NOT NULL,
	`nypwidget_enabled` tinyint(1) NOT NULL default '1'
);
");

// NOTE: This is commented out since version 1.2.5
// Create a new "Pending - PriceWaiter" status for orders
// that have been pulled from PriceWaiter back into Magento
// $installer->run("
//     INSERT INTO  `{$this->getTable('sales/order_status')}` (
//         `status`, `label`
//     ) VALUES (
//         'pricewaiter_pending', 'Pending - PriceWaiter'
//     );
//     INSERT INTO  `{$this->getTable('sales/order_status_state')}` (
//         `status`, `state`, `is_default`
//     ) VALUES (
//         'pricewaiter_pending', 'pending', '0'
//     );
// ");

// The default value above only applies to new products.
// Build a collection of products, and set 'nypwidget_enabled' to the default value
// This part can take a bit of time.
// Mage::app()->setUpdateMode(false);
// Mage::app()->setCurrentStore(0);

// $products = Mage::getModel('catalog/product')->getCollection()
//     ->addAttributeToFilter('type_id', array('in' => $supportTypeIds));

// foreach ($products as $product) {
//     Mage::getSingleton('catalog/product_action')
//         ->updateAttributes(array($product->getId()), array('nypwidget_enabled' => 1), 0);
// }

?>
