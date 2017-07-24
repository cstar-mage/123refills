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
/*
 * this class is used by rewrite class of Layout_Update
 */

class Litespeed_Litemage_Model_Layout_Master
{

	protected $_handleUpdates = array() ;
	protected $_cachePrefix ;
	protected $_cacheTags ;

	public function __construct()
	{
		$design = Mage::getSingleton('core/design_package') ;
		if ( $design->getArea() != 'frontend' ) {
			throw Mage::exception('Litespeed_Litemage_Model_Layout_Master should only be used for frontend') ;
		}

		$this->_cacheTags = array( Mage_Core_Model_Layout_Update::LAYOUT_GENERAL_CACHE_TAG ) ;
	}

    public function getCachePrefix()
	{
		if (!$this->_cachePrefix) {
			$design	 = Mage::getSingleton('core/design_package');
			$storeId = Mage::app()->getStore()->getId();

			//dp & dt may change dynamically, so only set when calling it
			$this->_cachePrefix = 'LAYOUT_MASTER_' . $storeId . '_' . $design->getPackageName() . '_'
					. $design->getTheme('layout') . '_';
		}
		return $this->_cachePrefix;
	}

	public function getHandleUpdates( $handle )
	{
		if ( ! isset($this->_handleUpdates[$handle]) ) {
			$result = false ;
			if ( Mage::app()->useCache('layout') ) {
				$cacheId = $this->getCachePrefix() . $handle ;
				$result = Mage::app()->loadCache($cacheId) ;
			}
			$this->_handleUpdates[$handle] = $result ;
		}
		return $this->_handleUpdates[$handle] ;
	}

	public function saveHandleUpdates( $handle, $updateString )
	{
		if ( isset($this->_handleUpdates[$handle]) && $this->_handleUpdates[$handle] === false ) {
			$this->_handleUpdates[$handle] = $updateString ;// save even empty string

			if ( Mage::app()->useCache('layout') ) {
				$cacheId = $this->_cachePrefix . $handle ;
				Mage::app()->saveCache($updateString, $cacheId, $this->_cacheTags, null) ;
			}
		}
	}

}
