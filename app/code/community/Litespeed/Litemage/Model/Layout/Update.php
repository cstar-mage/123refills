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
 * this class rewrite just try to remember what updates imported by which handle, only modify for frontend area
 */

class Litespeed_Litemage_Model_Layout_Update extends Mage_Core_Model_Layout_Update
{

	protected $_handleUpdates ;
	protected $_layoutHandles ;
	protected $_curHandles ;
	protected $_recursiveUpdates ;
	protected $_modified = false ;
	protected $_sharedCacheId ;
	protected $_layoutMaster ;
	protected $_handleXml ;
	protected $_isDebug ;

	public function __construct()
	{
		if ( Mage::getSingleton('core/design_package')->getArea() == 'frontend' && Mage::helper('litemage/data')->moduleEnabled() ) {
			$this->_modified = true ;
			$this->_layoutMaster = Mage::getSingleton('litemage/layout_master') ;
			$this->_resetInternals() ;
			$this->_isDebug = Mage::helper('litemage/data')->isDebug() ;
		}
		parent::__construct() ;
	}

	public function resetHandles()
	{
		if ( $this->_modified ) {
			$this->_resetInternals() ;
		}
		return parent::resetHandles() ;
	}

	protected function _resetInternals()
	{
		$this->_cacheId = null ;
		$this->_curHandles = array() ;
		$this->_handleUpdates = array() ;
		$this->_recursiveUpdates = array() ;
		$this->_layoutHandles = array() ;
	}

	public function getUsedHandles()
	{
		if ( !$this->_modified ) {
			if ( $this->_isDebug ) {
				Mage::helper('litemage/data')->debugMesg('LayoutUpdate SHOULD NOT GET HERE getUsedHandles');
			}
		}
		
		return array_keys($this->_handleUpdates) ;
	}

	/**
	 * Merge layout update by handle
	 *
	 * @param string $handle
	 * @return Mage_Core_Model_Layout_Update
	 */
	public function merge( $handle )
	{
		if ( ! $this->_modified ) {
			return parent::merge($handle) ;
		}

		// can be recusively loaded handle
		array_push($this->_curHandles, $handle) ;

		if ( ($update = $this->_layoutMaster->getHandleUpdates($handle)) !== false ) {
			$this->addUpdate($update) ;
		}
		else {
			parent::merge($handle) ;
		}

		array_pop($this->_curHandles) ;
		return $this ;
	}

	public function addUpdate( $update )
	{
		$update = trim($update) ;
		if ( $update == '' )
			return $this ;

		if ( $this->_modified && ! empty($this->_curHandles) ) {
			foreach ( $this->_curHandles as $h ) {
				if ( in_array($h, $this->_layoutHandles) ) {
					if ( ! isset($this->_handleUpdates[$h]) )
						$this->_handleUpdates[$h] = '' ;
					$this->_handleUpdates[$h] .= $update ;
				}
				else {
					if ( ! isset($this->_recursiveUpdates[$h]) )
						$this->_recursiveUpdates[$h] = '' ;
					$this->_recursiveUpdates[$h] .= $update ;
				}
			}
		}
		return parent::addUpdate($update) ;
	}

	/**
	 * Get cache id
	 *
	 * @return string
	 */
	public function getCacheId()
	{
		if ( ! $this->_cacheId ) {
			if ( ! $this->_modified ) {
				return parent::getCacheId() ;
			}
			$this->_resetInternals() ;
			$this->_layoutHandles = $this->getHandles() ;
			$tags = $this->_layoutHandles ;
			$design = Mage::getSingleton('core/design_package') ;
			$tags[] = $design->getPackageName();
			$tags[] = $design->getTheme('layout');			
			$tags[] = 'LITEMAGE_MODIFY' ;
			$this->_cacheId = 'LAYOUT_' . Mage::app()->getStore()->getId() . md5(join('__', $tags)) ;
		}
		elseif (empty($this->_layoutHandles)) {
			// cacheId is set through setCacheId from outside, so handles not initialized 
			$this->_layoutHandles = $this->getHandles() ;
		}
		return $this->_cacheId ;
	}

    /**
     * Set cache id
     *
     * @param string $cacheId
     * @return Litespeed_Litemage_Model_Layout_Update
     */
    public function setCacheId($cacheId)
    {
		if ( $this->_modified ) {
			$this->_resetInternals() ;
			if ( $this->_isDebug ) {
				Mage::helper('litemage/data')->debugMesg('LayoutUpdate CONTAINS setCacheId ' . $cacheId) ;
			}
		}
		return parent::setCacheId($cacheId) ;
    }
	
	public function loadCache()
	{
		if ( ! Mage::app()->useCache('layout') ) {
			return false ;
		}

		if ( ! $this->_modified ) {
			return parent::loadCache() ;
		}

		if ( ! $result = Mage::app()->loadCache($this->getCacheId()) ) {
			return false ;
		}

		$this->_handleUpdates = unserialize($result) ;
		if ( $this->_handleUpdates == false ) {
			return false ;
		}

		if ( isset($this->_handleUpdates['LITEMAGE_SHARED']) ) {
			$this->_sharedCacheId = $this->_handleUpdates['LITEMAGE_SHARED'] ;
			if ( ! $result = Mage::app()->loadCache($this->_sharedCacheId) ) {
				unset($this->_handleUpdates['LITEMAGE_SHARED']) ;
				return false ;
			}

			$this->_handleUpdates = unserialize($result) ;
			if ( $this->_handleUpdates == false ) {
				return false ;
			}
		}
		if ( $this->_isDebug ) {
			Mage::helper('litemage/data')->debugMesg('Layout cache loaded '
					. implode(':', array_keys($this->_handleUpdates))
					. ' ' . substr($this->_cacheId, 8, 12)) ;
		}
		parent::addUpdate(implode('', $this->_handleUpdates)) ;

		return true ;
	}

	public function saveCache()
	{
		if ( ! Mage::app()->useCache('layout') ) {
			return false ;
		}
		if ( ! $this->_modified ) {
			return parent::saveCache() ;
		}

		$this->_curHandles = array() ;
		$tags = $this->getHandles() ; // all handles used, include recursive ones
		$tags[] = self::LAYOUT_GENERAL_CACHE_TAG ;
		$usedHandles = $this->getUsedHandles() ;

		if ( count($this->_layoutHandles) > count($usedHandles) ) {
			$shared = $usedHandles ;
			$design = Mage::getSingleton('core/design_package') ;
			$shared[] = $design->getPackageName();
			$shared[] = $design->getTheme('layout');			
			$shared[] = 'LITEMAGE_SHARED' ;
			$sharedTags = $usedHandles ;
			$sharedTags[] = self::LAYOUT_GENERAL_CACHE_TAG ;
			$this->_sharedCacheId = 'LAYOUT_' . Mage::app()->getStore()->getId() . md5(join('__', $shared)) ;
			if ( ! $result = Mage::app()->loadCache($this->_sharedCacheId) ) {
				$res = Mage::app()->saveCache(serialize($this->_handleUpdates), $this->_sharedCacheId, $sharedTags, null) ;
			}
			$ref = array( 'LITEMAGE_SHARED' => $this->_sharedCacheId ) ;
			$res = Mage::app()->saveCache(serialize($ref), $this->getCacheId(), $tags, null) ;
		}
		else {
			$res = Mage::app()->saveCache(serialize($this->_handleUpdates), $this->getCacheId(), $tags, null) ;
		}
		if ( $this->_isDebug ) {
			Mage::helper('litemage/data')->debugMesg('Layout cache saved '
					. implode(':', array_keys($this->_handleUpdates))
					. ' ' . substr($this->_cacheId, 8, 12)) ;
		}

		foreach ( $this->_handleUpdates as $h => $update ) {
			$this->_layoutMaster->saveHandleUpdates($h, $update) ;
		}
		foreach ( $this->_recursiveUpdates as $h => $update ) {
			$this->_layoutMaster->saveHandleUpdates($h, $update) ;
		}
		return $res ;
	}

	public function getBlockHandles( $blockNameList )
	{
		if ( !$this->_modified ) {
			if ( $this->_isDebug ) {
				Mage::helper('litemage/data')->debugMesg('LayoutUpdate SHOULD NOT COME HERE ' . implode(',', $blockNameList));
			}
		}
		if ( $this->_handleXml == null ) {
			$this->_handleXml = array() ;
			foreach ( $this->_handleUpdates as $h => $update ) {
				if ( ($h != 'customer_logged_out') && ($h != 'customer_logged_in') ) {
					$updates = '<' . '?xml version="1.0"?' . '><layout>' . $update . '</layout>' ;
					$this->_handleXml[$h] = simplexml_load_string($updates, $this->getElementClass()) ;
				}
			}
		}
		$handles = array() ;
		$parents = array() ;
		$found = false ;
		foreach ( $this->_handleXml as $h => $xml ) {
			foreach ( $blockNameList as $name ) {
				$xpath = '//*[@name="' . $name . '"]' ;
				if ( $node = $xml->xpath($xpath) ) {
					$handles[] = $h ;
					$found = true ;
					break ;
				}
			}
			if ( ! $found ) {
				$parents[] = $h ;
			}
		}
		// need to get all parent handle
		$blockHandles = count($handles) ? array_merge($parents, $handles) : array_slice($parents, 0, 1) ; // return default
		return $blockHandles ;
	}

}
