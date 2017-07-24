<?php
/**
 * LiteMage
 *
 * NOTICE OF LICENSE
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see https://opensource.org/licenses/GPL-3.0 .
 *
 * @package   LiteSpeed_LiteMage
 * @copyright  Copyright (c) 2016 LiteSpeed Technologies, Inc. (https://www.litespeedtech.com)
 * @license     https://opensource.org/licenses/GPL-3.0
 */


class Litespeed_Litemage_Model_Config_Source_FlushCategory
{
	// Flush Product and Categories When Product Qty Change
	// 0: default - Flush product when qty change, flush categories when stock status change
	// 1: Only flush product and categories when stock status change
	// 2: Flush product when stock status change, do not flush categories
	// 3: Always flush product and categories when qty/stock status change

    public function toOptionArray() {
        $helper = Mage::helper('litemage/data');
        return array(
            array( 'value' => 0, 'label' => $helper->__( 'Flush product when quantity or stock status change, flush categories only when stock status changes' ) ),
            array( 'value' => 1, 'label' => $helper->__( 'Flush product and categories only when stock status changes' ) ),
            array( 'value' => 2, 'label' => $helper->__( 'Flush product when stock status changes, do not flush categories when stock status or quantity change' ) ),
			array( 'value' => 3, 'label' => $helper->__( 'Always flush product and categories when quantity or stock status change' ) )
        );
    }
}
