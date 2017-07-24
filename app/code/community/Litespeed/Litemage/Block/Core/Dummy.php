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

class Litespeed_Litemage_Block_Core_Dummy extends Mage_Core_Block_Abstract
{
	protected $_name;

	public function __construct($name)
	{
		// most time is root, head
		$this->_name = $name;
	}

	// dummy block not exist in ESILayout, they are not ESI block, safe to ignore
	public function __call($method, $args)
	{
		Mage::helper('litemage/data')->debugMesg('Dummy block ' . $this->_name . " called $method - ignore");

	}

	public static function __callStatic($method, $args)
	{
		Mage::helper('litemage/data')->debugMesg('Dummy block ' . $this->_name . " called static $method - ignore");
	}

}
