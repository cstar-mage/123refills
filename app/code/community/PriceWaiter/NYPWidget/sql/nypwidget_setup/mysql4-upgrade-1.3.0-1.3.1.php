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
$supportTypeIds = array('simple', 'configurable', 'grouped', 'bundle');

$installer = $this;
$installer->startSetup();

// Add a new attribute to all products to toggle the Conversion Tools on/off
$installer->addAttribute('catalog_product', 'nypwidget_ct_disabled',
    array(
        'group' => 'General',
        'label' => 'Disable PriceWaiter Conversion Tools? (such as Exit Intent)',
        'type' => 'int',
        'input' => 'boolean',
        'default' => '0',
        'class' => '',
        'backend' => '',
        'frontend' => '',
        'source' => '',
        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
        'visible' => true,
        'required' => true,
        'user_defined' => false,
        'searchable' => true,
        'filterable' => true,
        'comparable' => true,
        'visible_on_front' => true,
        'visible_in_advanced_search' => false,
        'unique' => false,
        'apply_to' => $supportTypeIds,
    )
);

// Add an attribute to our nypwidget_category table to hold conversion tools information
$installer->run("
ALTER TABLE {$this->getTable('nypwidget_category')} ADD COLUMN `nypwidget_ct_enabled` tinyint(1) NOT NULL default '1' AFTER nypwidget_enabled;
");
