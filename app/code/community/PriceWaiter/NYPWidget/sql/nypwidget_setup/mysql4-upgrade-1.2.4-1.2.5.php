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

$this->startSetup();

// Create a new "Processing - PriceWaiter" status for orders
// that have been pulled from PriceWaiter back into Magento.
// NOTE: This replaces "Pending - PriceWaiter"
$this->run("
    INSERT INTO  `{$this->getTable('sales/order_status')}` (
        `status`, `label`
    ) VALUES (
        'pricewaiter_processing', 'Processing - PriceWaiter'
    );
    INSERT INTO  `{$this->getTable('sales/order_status_state')}` (
        `status`, `state`, `is_default`
    ) VALUES (
        'pricewaiter_processing', 'processing', '0'
    );
");
