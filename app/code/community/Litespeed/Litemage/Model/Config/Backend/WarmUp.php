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
 * @copyright  Copyright (c) 2015-2016 LiteSpeed Technologies, Inc. (https://www.litespeedtech.com)
 * @license     https://opensource.org/licenses/GPL-3.0
 */


class Litespeed_Litemage_Model_Config_Backend_WarmUp extends Mage_Core_Model_Config_Data
{
    protected function _beforeSave()
    {
        $value = $this->getValue();
		if (trim($value) == '')
			return $this;
		
		$lines = explode("\n", $value);
		$errs = array();
		foreach ($lines as $line) {
			$f = preg_split("/[\s]+/", $line, null, PREG_SPLIT_NO_EMPTY) ;
			if (count($f) != 3) {
				$errs[] = 'Requires 3 fields separated by space: absolute file path, interval and priority - ' . $line;
				break;
			}
			if ( (intval($f[1]) != $f[1]) || ($f[1] < 600)) {
				$errs[] = 'Second parameter is interval, requires an integer larger than 600 - ' . $line;
				break;
			}
			if ( (intval($f[2]) != $f[2]) || ($f[2] <= 0)) {
				$errs[] = 'Third parameter is priority, requires an integer larger than 0 - ' . $line;
				break;
			}
			if ( $f[0][0] != '/' ) {
				$errs[] = 'First parameter is custom URL file path, which requires absolute path - ' . $line;
				break;
			}
			if ( ! is_readable($f[0]) ) {
				$errs[] = 'First parameter is custom URL file path, cannot find it or file not readable due to permission - ' . $line;
				break;
			}
		}

		if (!empty($errs)) {
			Mage::throwException('Error in Custom Defined URL List Files:<br> ' . implode("<br>", $errs));
		}

        return $this;
    }
}
