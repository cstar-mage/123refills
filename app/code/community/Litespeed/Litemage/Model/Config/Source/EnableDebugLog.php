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


class Litespeed_Litemage_Model_Config_Source_EnableDebugLog {
    public function toOptionArray() {
        $helper = Mage::helper('litemage/data');
        return array(
            array( 'value' => 0, 'label' => $helper->__( 'No' ) ),
            array( 'value' => 1, 'label' => $helper->__( 'Yes' ) ),
            array( 'value' => 2, 'label' => $helper->__( 'Only for defined Admin IPs' ) ),
        );
    }
}
