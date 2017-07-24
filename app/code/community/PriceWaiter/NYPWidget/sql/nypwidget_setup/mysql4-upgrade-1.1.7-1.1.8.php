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

// Add table to keep track of order IDs associated with `pricewaiter_id`s
// Will prevent duplicate orders from the order callback API
$installer = $this;
$installer->startSetup();
$installer->run("
DROP TABLE IF EXISTS {$this->getTable('nypwidget_orders')};
CREATE TABLE {$this->getTable('nypwidget_orders')} (
	PRIMARY KEY (`entity_id`),
	`entity_id` int(11) unsigned NOT NULL auto_increment,
	`store_id` int(11) unsigned NOT NULL,
	`pricewaiter_id` varchar(100)  NOT NULL,
	`order_id` int(11) unsigned NOT NULL
);
");
