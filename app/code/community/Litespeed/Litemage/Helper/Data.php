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
class Litespeed_Litemage_Helper_Data extends Mage_Core_Helper_Abstract
{

	const CFGXML_DEFAULTLM = 'default/litemage' ;
	const CFGXML_ESIBLOCK = 'frontend/litemage/esiblock' ;
	const STOREXML_PUBLICTTL = 'litemage/general/public_ttl' ;
	const STOREXML_PRIVATETTL = 'litemage/general/private_ttl' ;
	const STOREXML_HOMETTL = 'litemage/general/home_ttl' ;
	const STOREXML_TRACKLASTVIEWED = 'litemage/general/track_viewed' ;
	const STOREXML_DIFFCUSTGRP = 'litemage/general/diff_customergroup' ;
	const STOREXML_DIFFCUSTGRP_SET = 'litemage/general/diff_customergroup_set' ;
	const STOREXML_WARMUP_ENABLED = 'litemage/warmup/enable_warmup' ;
	const STOREXML_FPWP_ENABLED = 'litemage/fishpigwp/fpwp_cache';
	const STOREXML_FPWP_TTL = 'litemage/fishpigwp/fpwp_ttl';
	const CFG_ENABLED = 'enabled' ;
	const CFG_DEBUGON = 'debug' ;
	const CFG_WARMUP = 'warmup' ;
	const CFG_WARMUP_SERVER_IP = 'server_ip' ;
	const CFG_WARMUP_LOAD_LIMIT = 'load_limit' ;
	const CFG_WARMUP_MAXTIME = 'max_time' ;
	const CFG_WARMUP_THREAD_LIMIT = 'thread_limit' ;
	const CFG_WARMUP_DELTA_LOG = 'delta_log';
	const CFG_AUTOCOLLECT = 'collect' ;
	const CFG_TRACKLASTVIEWED = 'track_viewed' ;
	const CFG_DIFFCUSTGRP = 'diff_customergroup' ;
	const CFG_DIFFCUSTGRP_SET = 'diff_customergroup_set' ;
	const CFG_PUBLICTTL = 'public_ttl' ;
	const CFG_PRIVATETTL = 'private_ttl' ;
	const CFG_HOMETTL = 'home_ttl' ;
	const CFG_ESIBLOCK = 'esiblock' ;
	const CFG_NOCACHE = 'nocache' ;
	const CFG_CACHE_ROUTE = 'cache_routes' ;
	const CFG_NOCACHE_ROUTE = 'nocache_routes' ;
	const CFG_FULLCACHE_ROUTE = 'fullcache_routes' ;
	const CFG_NOCACHE_VAR = 'nocache_vars' ;
	const CFG_NOCACHE_URL = 'nocache_urls' ;
	const CFG_ALLOWEDIPS = 'allow_ips' ;
	const CFG_ADMINIPS = 'admin_ips' ;
	const CFG_FPWP_ENABLED = 'fpwp_cache';
	const CFG_FPWP_TTL = 'fpwp_ttl';
	const CFG_FPWP_PREFIX = 'fpwp_prefix';
	const CFG_FLUSH_PRODCAT = 'flush_prodcat' ;
	const CFG_NEED_ADD_DELTA = 'add_delta' ;
	const LITEMAGE_GENERAL_CACHE_TAG = 'LITESPEED_LITEMAGE' ;
	const LITEMAGE_DELTA_CACHE_ID = 'LITEMAGE_DELTA' ;

	// config items
	protected $_conf = array() ;
	protected $_userModuleEnabled = -2 ; // -2: not set, true, false
	protected $_moduleEnabled = -2 ; // -2: not set, true, false
	protected $_esiTag ;
	protected $_isDebug = null;
	protected $_translateParams = null ;
	protected $_debugTag = 'LiteMage' ;

	public function licenseEnabled()
	{
		if ( (isset($_SERVER['X-LITEMAGE']) && $_SERVER['X-LITEMAGE']) // for lsws
				|| (isset($_SERVER['HTTP_X_LITEMAGE']) && $_SERVER['HTTP_X_LITEMAGE'])) { // lslb
			return true;
		}
		else {
			return false ;
		}
	}

	public function moduleEnabled()
	{
		if ( $this->_moduleEnabled === -2 ) {
			if ($this->licenseEnabled()) {
				$this->_moduleEnabled = $this->getConf(self::CFG_ENABLED);
			}
			else {
				$this->_moduleEnabled = false;
			}
		}
		return $this->_moduleEnabled;
	}

	public function moduleEnabledForUser()
	{
		if ( $this->_userModuleEnabled === -2 ) {
			$allowed = $this->moduleEnabled() ;
			if ( $allowed ) {
				$tag = '' ;
				$httphelper = Mage::helper('core/http') ;
				$remoteAddr = $httphelper->getRemoteAddr() ;
				$ua = $httphelper->getHttpUserAgent() ;
				if ( $ua == 'litemage_walker' || $ua == 'litemage_runner' ) {
					$tag = $ua . ':' ;
				}
				else if ( $ips = $this->getConf(self::CFG_ALLOWEDIPS) ) {
					if ( ! in_array($remoteAddr, $ips) ) {
						$allowed = false ;
					}
				}

				if ( $this->_isDebug && $allowed ) {
					$tag .= $remoteAddr ;
					$msec = microtime() ;
					$msec1 = substr($msec, 2, strpos($msec, ' ') - 2) ;
					$this->_debugTag .= ' [' . $tag . ':' . $_SERVER['REMOTE_PORT'] . ':' . $msec1 . ']' ;
				}
			}
			$this->_userModuleEnabled = $allowed ;
		}
		return $this->_userModuleEnabled ;
	}

	public function isAdminIP()
	{
		if ( $adminIps = $this->getConf(self::CFG_ADMINIPS) ) {
			$remoteAddr = Mage::helper('core/http')->getRemoteAddr() ;
			if ( in_array($remoteAddr, $adminIps) ) {
				return true ;
			}
		}
		return false ;
	}

	public function isRestrainedIP()
	{
		return ($this->getConf(self::CFG_ALLOWEDIPS) != '') ;
	}

	public function isDebug()
	{
		return $this->getConf(self::CFG_DEBUGON) ;
	}

	public function esiTag( $type )
	{
		if ( isset($this->_esiTag[$type]) ) {
			return $this->_esiTag[$type] ;
		}

		if ( $this->_isDebug ) {
			$this->debugMesg('Invalid type for esiTag ' . $type) ;
		}
	}

	protected function _getTranslateParams()
	{
		if ( $this->_translateParams == null ) {
			// sample handles default:catalog_category_layered_nochildren:catalog_category_view:catalog_category_layered
			$this->_translateParams = array(
				'h' => array(
					0 => array( 'default', 'catalog', 'category', 'layered', 'nochildren' ),
					1 => array( 'D', 'L', 'G', 'Y', 'N' ) ),
				'st' => array(
					0 => array( 'core/session', 'catalog/session', 'checkout/session', 'customer/session', '/session' ),
					1 => array( 'O', 'L', 'K', 'U', 'S' ) ),
				'pc' => array(
					0 => array( 'Mage_Core_Block_Messages', 'Mage_Core_Block_Template' ),
					1 => array( 'M', 'T' ) )
					) ;
		}
		return $this->_translateParams ;
	}

	public function encodeEsiUrlParams( $params )
	{
		$translated = array() ;
		$tr = $this->_getTranslateParams() ;

		foreach ( $params as $key => $value ) {
			$newValue = $value ;
			switch ( $key ) {
				case 'h':
					$newValue = str_replace($tr[$key][0], $tr[$key][1], $value) ;
					break ;
				case 'st':
					$newValue = str_replace($tr[$key][0], $tr[$key][1], $value) ;
					$newValue = str_replace('/', '--', $newValue) ;
					break ;
				case 'pc':
					if ( ($index = array_search($value, $tr[$key][0])) !== false ) {
						$newValue = $tr[$key][1][$index] ;
					}
					break ;
				case 'pt':
				case 'call':
					$newValue = str_replace('/', '--', $value) ;
					break ;
			}
			$translated[$key] = $newValue ;
		}
		return $translated ;
	}

	public function decodeEsiUrlParams( $params )
	{
		$translated = array() ;
		$tr = $this->_getTranslateParams() ;

		foreach ( $params as $key => $value ) {
			$origValue = $value ;
			switch ( $key ) {
				case 'h':
					$origValue = str_replace($tr[$key][1], $tr[$key][0], $value) ;
					break ;
				case 'st':
					$origValue = str_replace('--', '/', $value) ;
					$origValue = str_replace($tr[$key][1], $tr[$key][0], $origValue) ;
					break ;
				case 'pc':
					if ( ($index = array_search($value, $tr[$key][1])) !== false ) {
						$origValue = $tr[$key][0][$index] ;
					}
					break ;
				case 'pt':
				case 'call':
					$origValue = str_replace('--', '/', $value) ;
					break ;
			}
			$translated[$key] = $origValue ;
		}
		return $translated ;
	}

	public function trackLastViewed()
	{
		return Mage::getStoreConfig(self::STOREXML_TRACKLASTVIEWED) ;
	}

	public function getEsiConf( $type = '', $name = '' ) //type = tag, block, event
	{
		$conf = $this->getConf('', self::CFG_ESIBLOCK) ;
		if ( $type == 'event' && ! isset($conf['event']) ) {
			$events = array() ;
			foreach ( $conf['tag'] as $tag => $d ) {
				if ( isset($d['purge_events']) ) {
					$pes = array_keys($d['purge_events']) ;
					foreach ( $pes as $e ) {
						if ( ! isset($events[$e]) )
							$events[$e] = array() ;
						$events[$e][] = $d['cache-tag'] ;
					}
				}
			}
			$this->_conf[self::CFG_ESIBLOCK]['event'] = $events ;
			return $events ;
		}
		if ( $type == '' )
			return $conf ;
		elseif ( $name == '' )
			return $conf[$type] ;
		else
			return $conf[$type][$name] ;
	}

	public function getWarmUpConf()
	{
		if ( ! isset($this->_conf[self::CFG_WARMUP]) ) {
			$storeInfo = array() ;

			if ( $this->getConf(self::CFG_ENABLED) ) {
				$this->getConf('', self::CFG_WARMUP) ;
				$storeIds = array_keys(Mage::app()->getStores()) ;
				$vary_dev = $this->isRestrainedIP() ? '/vary_dev/1' : '' ;

				foreach ( $storeIds as $storeId ) {
					$warmuplist = $this->_getStoreWarmUpInfo($storeId, $vary_dev) ;
					$storeInfo = array_merge($storeInfo, $warmuplist) ;
				}
			}
			else {
				$this->_conf[self::CFG_WARMUP] = array() ;
			}
			$this->_conf[self::CFG_WARMUP]['store'] = $storeInfo ;
		}

		return $this->_conf[self::CFG_WARMUP] ;
	}

	public function needAddDeltaTags()
	{
		if ( ! isset($this->_conf[self::CFG_NEED_ADD_DELTA]) ) {
			$found = false ;
			// as long as we find one store has delta crawl enabled
			if ( $this->getConf(self::CFG_ENABLED) ) {
				$storeIds = array_keys(Mage::app()->getStores()) ;

				foreach ( $storeIds as $storeId ) {
					$enabled_sel = Mage::getStoreConfig(self::STOREXML_WARMUP_ENABLED, $storeId) ;
					if ( strpos($enabled_sel, '8') !== false ) {
						if ( Mage::app()->getStore($storeId)->getIsActive() )
							$found = true ;
						break ;
					}
				}
			}
			$this->_conf[self::CFG_NEED_ADD_DELTA] = $found ;
		}

		return $this->_conf[self::CFG_NEED_ADD_DELTA] ;
	}

	public function getCrawlerListDir()
	{
		$path = Mage::getBaseDir('var') . DS . 'litemage' ;

		if ( ! is_dir($path) ) {
			mkdir($path) ;
			chmod($path, 0777) ;
		}
		return $path ;
	}

	public function getAutoCollectConf( $storeId )
	{
		if ( ! isset($this->_conf[self::CFG_AUTOCOLLECT][$storeId]) ) {

			if ( ! isset($this->_conf[self::CFG_AUTOCOLLECT]) ) {
				$this->_conf[self::CFG_AUTOCOLLECT] = array() ;
			}
			$info = array( 'collect' => 0, 'crawlDelta' => 0, 'crawlAuto' => 0, 'frame' => 0, 'remove' => 0, 'deep' => 0, 'deltaDeep' => 0, 'countRobot' => 0 ) ;

			if ( $this->getConf(self::CFG_ENABLED) ) {
				$enabled_sel = Mage::getStoreConfig(self::STOREXML_WARMUP_ENABLED, $storeId) ;
				if ( $enabled_sel ) {

					if ( strpos($enabled_sel, '8') !== false ) {
						$info['crawlDelta'] = 1 ;
						$info['deltaDeep'] = Mage::getStoreConfig('litemage/warmup/delta_depth', $storeId) ;
					}
					if ( strpos($enabled_sel, '4') !== false ) {
						$info['crawlAuto'] = 1 ;
						if ( Mage::getStoreConfig('litemage/warmup/enable_autocollect', $storeId) ) {
							$info['collect'] = Mage::getStoreConfig('litemage/warmup/auto_collect_add', $storeId) ;
							$info['countRobot'] = Mage::getStoreConfig('litemage/warmup/auto_collect_robot', $storeId) ;
							$info['remove'] = Mage::getStoreConfig('litemage/warmup/auto_collect_remove', $storeId) ;
							if ( $info['remove'] < 1 )
								$info['remove'] = 1 ; // minimum is 1
							elseif ( $info['remove'] > $info['collect'] )
								$info['remove'] = $info['collect'] ;
							$info['frame'] = Mage::getStoreConfig('litemage/warmup/auto_collect_hours', $storeId)
									* 3600 ;
							$info['deep'] = Mage::getStoreConfig('litemage/warmup/auto_collect_depth', $storeId) ;
							if ( $info['deltaDeep'] > $info['deep'] )
								$info['deltaDeep'] = $info['deep'] ;
						}
					}
				}
			}
			$this->_conf[self::CFG_AUTOCOLLECT][$storeId] = $info ;
		}

		return $this->_conf[self::CFG_AUTOCOLLECT][$storeId] ;
	}

	protected function _getStoreWarmUpCustGroupVary($store)
	{
		$storeId = $store->getId();
		$customers	 = trim(Mage::getStoreConfig('litemage/warmup/multi_custgroup', $storeId));
		if (!$customers)
			return '';

		$cids = array_unique(preg_split("/[\s,]+/", $customers, null, PREG_SPLIT_NO_EMPTY));
		if (count($cids) == 0)
			return '';

		$vary_cgrp	 = '';
		$customer = Mage::getModel('customer/customer')->setWebsiteId($store->getWebsiteId());
		
		$diffGrp = Mage::getStoreConfig(self::STOREXML_DIFFCUSTGRP, $storeId);
		if ($diffGrp == 1) {
			// per group
			$grps = array();
			foreach ($cids as $cid) {
				$customer->load($cid);
				if ($customer->getId() == $cid) {
					$gid = $customer->getGroupId();
					if (!in_array($gid, $grps)) {
						$grps[] = $gid;
						$vary_cgrp .= ',' . $gid . '_' . $cid;
					}
				}
			}
		}
		elseif ($diffGrp == 2) {
			// for in & out
			foreach ($cids as $cid) {
				$customer->load($cid);
				if ($customer->getId() == $cid) {
					$vary_cgrp .= ',in_' . $cid;
					break;
				}
			}
		}
		elseif ($diffGrp == 3) {
			$rgids		 = $this->_parseCustGrpSets(Mage::getStoreConfig(self::STOREXML_DIFFCUSTGRP_SET, $storeId));
			$grps		 = array();
			$guestReview = Mage::helper('review')->getIsGuestAllowToWrite();
			foreach ($cids as $cid) {
				$customer->load($cid);
				if ($customer->getId() == $cid) {
					$gid = $customer->getGroupId();
					if (isset($rgids[$gid])) {
						if (!in_array($rgids[$gid], $grps)) {
							$grps[] = $rgids[$gid];
							$vary_cgrp .= ',' . $rgids[$gid] . '_' . $cid;
						}
					}
					elseif (!$guestReview && !in_array('review', $grps)) {
						$grps[] = 'review';
						$vary_cgrp .= ',review_' . $cid;
					}
				}
			}
		}
		elseif ($diffGrp == 0) {
			$guestReview = Mage::helper('review')->getIsGuestAllowToWrite();
			if (!$guestReview) {
				foreach ($cids as $cid) {
					$customer->load($cid);
					if ($customer->getId() == $cid) {
						$vary_cgrp .= ',review_' . $cid;
						break;
					}
				}
			}
		}

		if ($vary_cgrp) {
			$vary_cgrp = '/vary_cgrp/-' . $vary_cgrp; // "-" means default, can also be review_userid
		}
		return $vary_cgrp;
	}

	protected function _getStoreWarmUpInfo( $storeId, $vary_dev )
	{
		$storeInfo = array() ;
		$enabled_sel = Mage::getStoreConfig(self::STOREXML_WARMUP_ENABLED, $storeId) ;
		if ( ! $enabled_sel )
			return $storeInfo ;

		$store = Mage::app()->getStore($storeId) ;
		if ( ! $store->getIsActive() )
			return $storeInfo ;

		$enabledStore = (strpos($enabled_sel, '1') !== false) ;
		$enabledCust = (strpos($enabled_sel, '2') !== false) ;
		$enabledAuto = (strpos($enabled_sel, '4') !== false) ;
		$enabledDelta = (strpos($enabled_sel, '8') !== false) ;

		$site = $store->getWebsite() ;
		$is_default_store = ($site->getDefaultStore()->getId() == $storeId) ; // cannot use $app->getDefaultStoreView()->getId();
		$is_default_site = $site->getIsDefault() ;
		$orderAdjust = 0.0 ;
		if ( $is_default_site )
			$orderAdjust -= 0.25 ;
		if ( $is_default_store )
			$orderAdjust -= 0.25 ;

		$availCurrCodes = $store->getAvailableCurrencyCodes() ;
		$default_currency = $store->getDefaultCurrencyCode() ;
		$vary_curr = '' ;
		$curr = trim(Mage::getStoreConfig('litemage/warmup/multi_currency', $storeId)) ;
		if ( $curr ) {
			// get currency vary
			$currs = preg_split("/[\s,]+/", strtoupper($curr), null, PREG_SPLIT_NO_EMPTY) ;
			if ( in_array('ALL', $currs) ) {
				$currs = $availCurrCodes ;
			}
			else {
				$currs = array_unique($currs) ;
			}

			foreach ( $currs as $cur ) {
				if ( $cur != $default_currency && in_array($cur, $availCurrCodes) ) {
					$vary_curr .= ',' . $cur ;
				}
			}
			if ( $vary_curr ) {
				$vary_curr = '/vary_curr/-' . $vary_curr ; // "-" means default
			}
		}

		$vary_cgrp = $this->_getStoreWarmUpCustGroupVary($store);
		
		$env = '' ;

		$storeName = $store->getName() ;
		if ( ! $is_default_store ) {
			$env .= '/store/' . $store->getCode() . '/storeId/' . $storeId ;
		}
		$env .= $vary_curr . $vary_cgrp . $vary_dev ;
		$baseurl = $store->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK) ;
		$ttl = Mage::getStoreConfig(self::STOREXML_PUBLICTTL, $storeId) ;
		$priority = Mage::getStoreConfig('litemage/warmup/priority', $storeId) + $orderAdjust ;
		$interval = Mage::getStoreConfig('litemage/warmup/interval', $storeId) ;
		if ( $interval == '' || $interval < 600 ) { // for upgrade users, not refreshed conf
			$interval = $ttl ;
		}

		if ( $enabledStore ) {
			$listId = 'store' . $storeId ;
			$storeInfo[$listId] = array(
				'id' => $listId,
				'storeid' => $storeId,
				'store_name' => $storeName,
				'default_curr' => $default_currency,
				'default_store' => $is_default_store,
				'default_site' => $is_default_site,
				'env' => $env,
				'interval' => $interval,
				'ttl' => $ttl,
				'priority' => $priority,
				'baseurl' => $baseurl ) ;
		}

		if ( $enabledAuto ) {
			// check auto list
			$autopriority = Mage::getStoreConfig('litemage/warmup/autolist_priority', $storeId) ;
			$autopriority += $orderAdjust ;
			$autointerval = Mage::getStoreConfig('litemage/warmup/autolist_interval', $storeId) ;
			if ( $autointerval == '' || $interval < $autointerval / 2 ) { // for upgrade users, not refreshed conf
				$autointerval = $ttl ;
			}
			$listId = 'auto' . $storeId ;
			$storeInfo[$listId] = array(
				'id' => $listId,
				'storeid' => $storeId,
				'store_name' => $storeName,
				'default_curr' => $default_currency,
				'default_store' => $is_default_store,
				'default_site' => $is_default_site,
				'env' => $env,
				'interval' => $autointerval,
				'ttl' => $ttl,
				'priority' => $autopriority,
				'baseurl' => $baseurl ) ;
		}

		if ( $enabledDelta ) {
			// delta list
			$autoconf = $this->getAutoCollectConf($storeId) ;
			$listId = 'delta' . $storeId ;
			$storeInfo[$listId] = array(
				'storeid' => $storeId,
				'store_name' => $storeName,
				'default_curr' => $default_currency,
				'default_store' => $is_default_store,
				'default_site' => $is_default_site,
				'env' => $env,
				'priority' => $priority,
				'depth' => $autoconf['deltaDeep'],
				'baseurl' => $baseurl ) ;
		}

		if ( $enabledCust ) {
			// check custom list
			$custlist = Mage::getStoreConfig('litemage/warmup/custlist', $storeId) ;
			$lines = explode("\n", $custlist) ;
			foreach ( $lines as $index => $line ) {
				$f = preg_split("/[\s]+/", $line, null, PREG_SPLIT_NO_EMPTY) ;
				if ( count($f) != 3 ) {
					continue ;
				}
				$custFile = $f[0] ;
				if ( ! is_readable($custFile) || ! isset($f[1]) || ! isset($f[2]) || $f[1] < 600
						|| $f[2] <= 0 ) {
					continue ;
				}
				$custInterval = $f[1] ;
				$custPriority = $f[2] ;
				$listId = 'cust' . $storeId . '-' . $index ;
				$storeInfo[$listId] = array(
					'id' => $listId,
					'storeid' => $storeId,
					'store_name' => $storeName,
					'default_curr' => $default_currency,
					'env' => $env,
					'interval' => $custInterval,
					'ttl' => $ttl,
					'priority' => $custPriority + $orderAdjust,
					'baseurl' => $baseurl,
					'file' => $custFile ) ;
			}
		}

		return $storeInfo ;
	}

	public function isEsiBlock( $block, $startDynamic )
	{
		$blockName = $block->getNameInLayout() ;
		$tag = null ;
		$valueonly = 0 ;
		$blockType = null ;
		$classname = get_class($block) ;

		$ref = $this->_conf[self::CFG_ESIBLOCK]['block'] ;
		if ( isset($ref['bn'][$blockName]) ) {
			$tag = $ref['bn'][$blockName]['tag'] ;
			$valueonly = $ref['bn'][$blockName]['valueonly'] ;
		}
		else {
			foreach ( $ref['bt'] as $bt => $bv ) {
				if ( $block instanceof $bt ) {
					$tag = $bv['tag'] ;
					$valueonly = $bv['valueonly'] ;
					$blockType = $bt ;
					break ;
				}
			}
		}
		if ( ($tag == null) && ($bd = $block->getData('litemage_dynamic')) ) {
			if ( isset($bd['tag']) && isset($this->_conf[self::CFG_ESIBLOCK]['tag'][$bd['tag']]) ) {
				$tag = $bd['tag'] ;
			}
			else {
				$tag = 'welcome' ; // default
			}
			if ( isset($bd['valueonly']) ) {
				$valueonly = 1 ;
			}
		}

		if ( $tag == null ) {
			return false ;
		}

		$tagdata = $this->_conf[self::CFG_ESIBLOCK]['tag'][$tag] ;
		$bconf = array(
			'tag' => $tag,
			'cache-tag' => $tagdata['cache-tag'],
			'access' => $tagdata['access'],
			'valueonly' => $valueonly,
			'bn' => $blockName,
			'bt' => $blockType,
			'extra' => array()
				) ;
		if ( $startDynamic ) {
			$bconf['pc'] = get_class($block) ;
			$bconf['is_dynamic'] = 1 ;
			// template may not be set at the moment
		}

		$block->setData('litemage_bconf', $bconf) ;
		return true ;
	}

	public function getNoCacheConf( $name = '' )
	{
		return $this->getConf($name, self::CFG_NOCACHE) ;
	}
	
	public function isWholeRouteCache($actionName)
	{
		return in_array($actionName, 
				$this->getConf(Litespeed_Litemage_Helper_Data::CFG_FULLCACHE_ROUTE, self::CFG_NOCACHE));		
	}

	public function getConf( $name, $type = '' )
	{
		if ( ($type == '' && ! isset($this->_conf[$name])) || ($type != '' && ! isset($this->_conf[$type])) ) {
			$this->_initConf($type) ;
		}

		// get store override, because store id may change after init
		switch ($name) {
			case self::CFG_DIFFCUSTGRP:
				$this->_conf[self::CFG_DIFFCUSTGRP] = Mage::getStoreConfig(self::STOREXML_DIFFCUSTGRP) ;
				break;
			case self::CFG_DIFFCUSTGRP_SET:
				$this->_conf[self::CFG_DIFFCUSTGRP_SET] = $this->_parseCustGrpSets(Mage::getStoreConfig(self::STOREXML_DIFFCUSTGRP_SET)) ;
				break;
			case self::CFG_PUBLICTTL:
				$this->_conf[self::CFG_PUBLICTTL] = Mage::getStoreConfig(self::STOREXML_PUBLICTTL) ;
				break;
			case self::CFG_PRIVATETTL:
				$this->_conf[self::CFG_PRIVATETTL] = Mage::getStoreConfig(self::STOREXML_PRIVATETTL) ;
				break;
			case self::CFG_HOMETTL:
				$this->_conf[self::CFG_HOMETTL] = Mage::getStoreConfig(self::STOREXML_HOMETTL) ;
				break;
			case self::CFG_TRACKLASTVIEWED:
				$this->_conf[self::CFG_TRACKLASTVIEWED] = Mage::getStoreConfig(self::STOREXML_TRACKLASTVIEWED) ;
				break;
		}

		if ( $type == '' )
			return $this->_conf[$name] ;
		elseif ( $name == '' )
			return $this->_conf[$type] ;
		else
			return $this->_conf[$type][$name] ;
	}

	protected function _parseCustGrpSets($groupings)
	{
		//return array of reversed gid -> groupings
		$groupingids = array_unique(preg_split("/[\s,]+/", $groupings, null, PREG_SPLIT_NO_EMPTY)) ;
		$rgids = array(); // reversed gid -> groupings (groupings convert : to .
		foreach ($groupingids as $groupingid) {
			if (strpos($groupingid, ':') !== false) {
				$gids2 = explode(':', $groupingid);
				$trgids = array();
				foreach ($gids2 as $singlegid) {
					$sgid = intval($singlegid);
					if ((strval($sgid) == $singlegid) && ($sgid > 0))
						$trgids[] = $sgid;
				}
				if (count($trgids)) {
					sort($trgids);
					$cleangroupid = implode('.', $trgids);
					foreach ($trgids as $sgid) {
						$rgids[$sgid] = $cleangroupid;
					}
				}
			}
			else {
				$sgid = intval($groupingid);
				if ((strval($sgid) == $groupingid) && ($sgid > 0))
					$rgids[$sgid] = $groupingid;				
			}
		}
		return $rgids;
	}
	
	protected function _initConf( $type = '' )
	{
		if ( ! isset($this->_conf['defaultlm']) ) {
			$this->_conf['defaultlm'] = $this->_getConfigByPath(self::CFGXML_DEFAULTLM) ;
		}
		$pattern = "/[\s,]+/" ;

		switch ( $type ) {
			case self::CFG_ESIBLOCK:
				$this->_conf[self::CFG_ESIBLOCK] = array() ;
				$this->_conf[self::CFG_ESIBLOCK]['tag'] = $this->_getConfigByPath(self::CFGXML_ESIBLOCK) ;

				$custblocks = array() ;
				$cust = $this->_conf['defaultlm']['donotcache'] ;
				$custblocks['welcome'] = empty($cust['welcome']) ? array() : preg_split($pattern, $cust['welcome'], null, PREG_SPLIT_NO_EMPTY) ;
				$custblocks['toplinks'] = empty($cust['toplinks']) ? array() : preg_split($pattern, $cust['toplinks'], null, PREG_SPLIT_NO_EMPTY) ;
				$custblocks['messages'] = empty($cust['messages']) ? array() : preg_split($pattern, $cust['messages'], null, PREG_SPLIT_NO_EMPTY) ;
				$toplinkstag = empty($cust['toplinkstag']) ? array() : preg_split($pattern, $cust['toplinkstag'], null, PREG_SPLIT_NO_EMPTY) ;

				$allblocks = array( 'bn' => array(), 'bt' => array() ) ;
				foreach ( $this->_conf[self::CFG_ESIBLOCK]['tag'] as $tag => $d ) {
					$this->_conf[self::CFG_ESIBLOCK]['tag'][$tag]['cache-tag'] = Litespeed_Litemage_Helper_Esi::TAG_PREFIX_ESIBLOCK . $tag ;
					$blocks = preg_split($pattern, $d['blocks'], null, PREG_SPLIT_NO_EMPTY) ;
					if ( ! empty($custblocks[$tag]) ) {
						$blocks = array_merge($blocks, $custblocks[$tag]) ;
					}

					foreach ( $blocks as $b ) {
						$valueonly = 0 ;
						if ( substr($b, -2) == '$v' ) {
							$valueonly = 1 ;
							$b = substr($b, 0, -2) ;
						}
						$bc = array( 'tag' => $tag, 'valueonly' => $valueonly ) ;
						if ( substr($b, 0, 2) == 'T:' ) {
							$b = substr($b, 2) ;
							$allblocks['bt'][$b] = $bc ;
						}
						else {
							$allblocks['bn'][$b] = $bc ;
						}
					}
					if ( isset($d['purge_tags']) ) {
						$pts = preg_split($pattern, $d['purge_tags'], null, PREG_SPLIT_NO_EMPTY) ;
						if ( $tag == 'toplinks' && ! empty($toplinkstag) ) {
							$pts = array_merge($pts, $toplinkstag) ;
						}
						if ( ! isset($d['purge_events']) ) {
							$this->_conf[self::CFG_ESIBLOCK]['tag'][$tag]['purge_events'] = array() ;
						}
						foreach ( $pts as $t ) {
							if ( isset($this->_conf[self::CFG_ESIBLOCK]['tag'][$t]['purge_events']) ) {
								$this->_conf[self::CFG_ESIBLOCK]['tag'][$tag]['purge_events'] = array_merge($this->_conf[self::CFG_ESIBLOCK]['tag'][$tag]['purge_events'], $this->_conf[self::CFG_ESIBLOCK]['tag'][$t]['purge_events']) ;
							}
						}
					}
				}
				$this->_conf[self::CFG_ESIBLOCK]['block'] = $allblocks ;
				break ;

			case self::CFG_NOCACHE:
				$this->_conf[self::CFG_NOCACHE] = array() ;
				$default = $this->_conf['defaultlm']['default'] ;
				$cust = $this->_conf['defaultlm']['donotcache'] ;
				if ( ! isset($cust['fullcache_routes']) ) {
					$cust['fullcache_routes'] = '' ;
				}
				if ($this->_conf[self::CFG_FPWP_ENABLED]) {
					$cust['cache_routes'] .= ' wordpress_' ;
				}

				$this->_conf[self::CFG_NOCACHE][self::CFG_CACHE_ROUTE] = array_merge(preg_split($pattern, $default['cache_routes'], null, PREG_SPLIT_NO_EMPTY), preg_split($pattern, $cust['cache_routes'], null, PREG_SPLIT_NO_EMPTY)) ;
				$this->_conf[self::CFG_NOCACHE][self::CFG_NOCACHE_ROUTE] = array_merge(preg_split($pattern, $default['nocache_subroutes'], null, PREG_SPLIT_NO_EMPTY), preg_split($pattern, $default['nocache_subroutes'], null, PREG_SPLIT_NO_EMPTY)) ;
				$this->_conf[self::CFG_NOCACHE][self::CFG_FULLCACHE_ROUTE] = preg_split($pattern, $cust['fullcache_routes'], null, PREG_SPLIT_NO_EMPTY) ;
				$this->_conf[self::CFG_NOCACHE][self::CFG_NOCACHE_VAR] = preg_split($pattern, $cust['vars'], null, PREG_SPLIT_NO_EMPTY) ;
				$this->_conf[self::CFG_NOCACHE][self::CFG_NOCACHE_URL] = preg_split($pattern, $cust['urls'], null, PREG_SPLIT_NO_EMPTY) ;
				break ;

			case self::CFG_WARMUP:
				$warmup = $this->_conf['defaultlm']['warmup'] ;
				$server_ip = trim($warmup[self::CFG_WARMUP_SERVER_IP]) ;
				if ( !$server_ip || ! Mage::helper('core/http')->validateIpAddr($server_ip) ) {
					$server_ip = '' ; //default
				}
				$delta_log = isset($this->_conf['defaultlm']['test']['delta_log']) && ($this->_conf['defaultlm']['test']['delta_log'] == 1);
				$this->_conf[self::CFG_WARMUP] = array(
					self::CFG_WARMUP_LOAD_LIMIT => $warmup[self::CFG_WARMUP_LOAD_LIMIT],
					self::CFG_WARMUP_THREAD_LIMIT => $warmup[self::CFG_WARMUP_THREAD_LIMIT],
					self::CFG_WARMUP_MAXTIME => $warmup[self::CFG_WARMUP_MAXTIME],
					self::CFG_WARMUP_SERVER_IP => $server_ip,
					self::CFG_WARMUP_DELTA_LOG => $delta_log) ;
				break ;

			default:
				$general = $this->_conf['defaultlm']['general'] ;
				$this->_conf[self::CFG_ENABLED] = $general[self::CFG_ENABLED] ;

				$test = $this->_conf['defaultlm']['test'] ;
				$this->_conf[self::CFG_DEBUGON] = $test[self::CFG_DEBUGON] ;
				$this->_isDebug = $test[self::CFG_DEBUGON] ; // required by cron, needs to be set even when module disabled.
				$adminIps = trim($general[self::CFG_ADMINIPS]) ;
				$this->_conf[self::CFG_ADMINIPS] = $adminIps ? preg_split($pattern, $adminIps, null, PREG_SPLIT_NO_EMPTY) : '' ;
				if ( ($this->_isDebug == 2) && (empty($this->_conf[self::CFG_ADMINIPS]) || ! in_array(Mage::helper('core/http')->getRemoteAddr(), $this->_conf[self::CFG_ADMINIPS])) ) {
					$this->_isDebug = 0 ;
				}

				if ( ! $general[self::CFG_ENABLED] )
					break ;

				// get store override
				$storeId = Mage::app()->getStore()->getId() ;
				$this->_conf[self::CFG_TRACKLASTVIEWED] = Mage::getStoreConfig(self::STOREXML_TRACKLASTVIEWED, $storeId) ;
				$this->_conf[self::CFG_DIFFCUSTGRP] = Mage::getStoreConfig(self::STOREXML_DIFFCUSTGRP, $storeId) ;
				if ($this->_conf[self::CFG_DIFFCUSTGRP] == 3) {
					$this->_conf[self::CFG_DIFFCUSTGRP_SET] = $this->_parseCustGrpSets(Mage::getStoreConfig(self::STOREXML_DIFFCUSTGRP_SET, $storeId)) ;
				}
				$this->_conf[self::CFG_PUBLICTTL] = Mage::getStoreConfig(self::STOREXML_PUBLICTTL, $storeId) ;
				$this->_conf[self::CFG_PRIVATETTL] = Mage::getStoreConfig(self::STOREXML_PRIVATETTL, $storeId) ;
				$this->_conf[self::CFG_HOMETTL] = Mage::getStoreConfig(self::STOREXML_HOMETTL, $storeId) ;

				if ( $general['alt_esi_syntax'] ) {
					$this->_esiTag = array( 'include' => 'esi_include', 'inline' => 'esi_inline', 'remove' => 'esi_remove' ) ;
				}
				else {
					$this->_esiTag = array( 'include' => 'esi:include', 'inline' => 'esi:inline', 'remove' => 'esi:remove' ) ;
				}
				$allowedIps = trim($test[self::CFG_ALLOWEDIPS]) ;
				$this->_conf[self::CFG_ALLOWEDIPS] = $allowedIps ? preg_split($pattern, $allowedIps, null, PREG_SPLIT_NO_EMPTY) : '' ;
				$this->_conf[self::CFG_FLUSH_PRODCAT] = isset($general[self::CFG_FLUSH_PRODCAT]) ? $general[self::CFG_FLUSH_PRODCAT] : 0 ; // for upgrade, maynot save in config
				
				if (isset($this->_conf['defaultlm']['fishpigwp'])) {
					$fpwp = $this->_conf['defaultlm']['fishpigwp'];
					$this->_conf[self::CFG_FPWP_PREFIX] = $fpwp[self::CFG_FPWP_PREFIX];
					$this->_conf[self::CFG_FPWP_TTL] = Mage::getStoreConfig(self::STOREXML_FPWP_TTL, $storeId) ;
					$this->_conf[self::CFG_FPWP_ENABLED] = Mage::getStoreConfig(self::STOREXML_FPWP_ENABLED, $storeId) ;
				}
				else {
					$this->_conf[self::CFG_FPWP_ENABLED] = 0;
				}
		}
	}

	protected function _getConfigByPath( $xmlPath )
	{
		$node = Mage::getConfig()->getNode($xmlPath) ;
		if ( ! $node )
			Mage::throwException('Litemage missing config in xml path ' . $xmlPath) ;
		return $node->asCanonicalArray() ;
	}

	public function useInternalCache()
	{
		if ( ! isset($this->_conf['useInternalCache']) ) {
			$this->_conf['useInternalCache'] = Mage::app()->useCache('layout') ;
		}
		return $this->_conf['useInternalCache'] ;
	}

	public function saveInternalCache( $data, $id, $tags = array() )
	{
		$tags[] = self::LITEMAGE_GENERAL_CACHE_TAG ;
		Mage::app()->saveCache($data, $id, $tags, null) ;
	}

	public function debugMesg( $mesg )
	{
		if ($this->_isDebug === null) {
			$this->_initConf();
		}
		if ( $this->_isDebug ) {
			$mesg = str_replace("\n", ("\n" . $this->_debugTag . '  '), $mesg) ;
			Mage::log($this->_debugTag . ' ' . $mesg) ;
		}
	}

}
