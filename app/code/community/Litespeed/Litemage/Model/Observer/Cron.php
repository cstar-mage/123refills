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
class Litespeed_Litemage_Model_Observer_Cron extends Varien_Event_Observer
{

	const WARMUP_MAP_FILE = 'litemage_warmup_urlmap' ;
	const WARMUP_META_CACHE_ID = 'litemage_warmup_meta' ;
	const DELTA_META_CACHE_ID = 'litemage_delta_meta' ;
	const USER_AGENT = 'litemage_walker' ;
	const FAST_USER_AGENT = 'litemage_runner' ;
	const ENV_COOKIE_NAME = '_lscache_vary' ;

	protected $_meta ; // time, curfileline
	protected $_conf ;
	protected $_helper ;
	protected $_isDebug ;
	protected $_isDelta;
	protected $_debugTag ;
	protected $_maxRunTime ;
	protected $_curThreads = -1 ;
	protected $_curThreadTime ;
	protected $_curList ;
	protected $_curDelta ;
	protected $_listDir ;
	protected $_priority ;

	protected function _construct()
	{
		$this->_helper = Mage::helper('litemage/data') ;
		$this->_isDebug = $this->_helper->isDebug() ;
		$this->_listDir = $this->_helper->getCrawlerListDir() ;

		$this->_conf = $this->_helper->getWarmUpConf() ;
		if ($this->_conf[Litespeed_Litemage_Helper_Data::CFG_WARMUP_DELTA_LOG]) {
			$this->_isDebug |= 2;
		}
		if ( $this->_isDebug ) {
			$this->_debugTag = 'LiteMage [cron:' ;
			if ( isset($_SERVER['USER']) )
				$this->_debugTag .= $_SERVER['USER'] ;
			elseif ( isset($_SERVER['HTTP_X_FORWARDED_FOR']) )
				$this->_debugTag .= $_SERVER['HTTP_X_FORWARDED_FOR'] ;
			$this->_debugTag .= ':' . $_SERVER['REQUEST_TIME'] . '] ' ;
		}
	}

	public function resetCrawlerList( $listId )
	{
		$adminSession = Mage::getSingleton('adminhtml/session') ;
		$meta = Mage::app()->loadCache(self::WARMUP_META_CACHE_ID) ;
		$updated = false ;

		if ( $listId ) {
			$id = strtolower($listId) ;
			if ( $meta ) {
				$meta = unserialize($meta) ;
				if ( isset($meta[$id]) ) {
					unset($meta[$id]) ;
					$updated = true ;
					$adminSession->addSuccess($listId . ' ' . Mage::helper('litemage/data')->__('List has been reset and will be regenerated in next run.')) ;
				}
				else {
					$adminSession->addError($listId . ' ' . Mage::helper('litemage/data')->__('List has been reset already. It will be regenerated in next run.')) ;
				}
			}
		}
		else {
			if ( $meta ) {
				Mage::app()->removeCache(self::WARMUP_META_CACHE_ID) ;
				$updated = true ;
				$adminSession->addSuccess(Mage::helper('litemage/data')->__('All lists have been reset and will be regenerated in next run.')) ;
			}
			else {
				$adminSession->addError(Mage::helper('litemage/data')->__('All lists have been reset already. It will be regenerated in next run.')) ;
			}
		}

		if ( $updated ) {
			$this->_saveMeta($meta) ;
		}
	}

	public function getCrawlerList( $listId )
	{
		$output = '<h3>Generated URL List ' . $listId . '</h3>' ;
		if ( ($urls = $this->_getCrawlListFileData($listId)) != null ) {
			$output .= '<pre>' . $urls . '</pre>' ;
		}
		else {
			$output .= '<p>Cannot find generated URL list. It will be regenerated in next run.</p>' ;
		}
		return $output ;
	}

	public function getCrawlerStatus()
	{
		$this->_initMeta() ;
		$meta = $this->_meta ;
		$timefmt = 'n.d H:i:s' ;
		$status = array( 'lastupdate' => '', 'endreason' => '',
			'stores' => array() ) ;

		if ( isset($meta['lastupdate']) ) {
			$status['lastupdate'] = date($timefmt, $meta['lastupdate']) ;
			unset($meta['lastupdate']) ;
		}

		if ( isset($meta['endreason']) ) {
			$status['endreason'] = $meta['endreason'] ;
			unset($meta['endreason']) ;
		}
		unset($meta['deltalist']) ;

		$lists = array() ;
		$priority = array() ;
		foreach ( $meta as $listId => $store_stat ) {
			$disp = array() ;
			$disp['priority'] = intval($store_stat['priority'] + 0.5) ;
			$disp['id'] = strtoupper($listId) ;
			if ( $listId == 'delta' ) {

			}
			else {
				$disp['store_name'] = $store_stat['store_name'] ;
				$disp['default_curr'] = $store_stat['default_curr'] ;
				$disp['baseurl'] = $store_stat['baseurl'] ;
				$disp['file'] = (isset($store_stat['file']) ? $store_stat['file'] : '') ;
				$disp['ttl'] = $store_stat['ttl'] ;
				$disp['interval'] = $store_stat['interval'] ;
				$disp['gentime'] = ($store_stat['gentime'] > 0) ? date($timefmt, $store_stat['gentime']) : 'N/A' ;
				$disp['tmpmsg'] = isset($store_stat['tmpmsg']) ? $store_stat['tmpmsg'] : '' ;
				$disp['endtime'] = ($store_stat['endtime'] > 0) ? date($timefmt, $store_stat['endtime']) : (($store_stat['gentime'] > 0) ? 'Not finished' : ' ') ;
				$disp['lastendtime'] = ($store_stat['lastendtime'] > 0) ? date($timefmt, $store_stat['lastendtime']) : ' ' ;
				$disp['listsize'] = ($store_stat['listsize'] > 0) ? $store_stat['listsize'] : 'N/A' ;
				$disp['curpos'] = $store_stat['curpos'] ;
				$disp['env'] = str_replace(',', ', ', $store_stat['env']) ;
				$disp['curvary'] = preg_replace("/_lscache_vary=.+;/", '', $store_stat['curvary']) ;
			}
			$disp['lastquerytime'] = ($store_stat['lastquerytime'] > 0) ? date($timefmt, $store_stat['lastquerytime']) : 'N/A' ;
			$disp['queried'] = $store_stat['queried'] ;
			$priority[$listId] = $store_stat['priority'] ;
			$lists[$listId] = $disp ;
		}
		asort($priority, SORT_NUMERIC) ;
		foreach ( $priority as $id => $pri ) {
			$status['stores'][] = $lists[$id] ;
		}
		return $status ;
	}

	/**
	 * called by cron job
	 */
	public function warmCache()
	{
		$this->_crawl(false);
	}

	public function crawlDelta()
	{
		$this->_crawl(true);
	}

	protected function _crawl($isDelta)
	{
		$this->_isDelta = $isDelta ;
		if ( $errmsg = $this->_init() ) {
			$this->_meta['endreason'] = 'Skipped this round - ' . $errmsg ;
			$this->_saveMeta() ;
			$this->_debugLog('Cron ' . ($isDelta ? 'warmDelta' : 'warmCache' ) . ' skip this round - ' . $errmsg) ;
			return;
		}

		$options = array(
			CURLOPT_SSL_VERIFYPEER => 0,
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_TIMEOUT => 180
		) ;

		$server_ip = $this->_conf[Litespeed_Litemage_Helper_Data::CFG_WARMUP_SERVER_IP] ;

		$client = new Varien_Http_Adapter_Curl() ;
		$curCookie = '' ;
		$endReason = '' ;
		$pattern = "/:\/\/([^\/^:]+)(\/|:)?/";

		while ( $urls = $this->_getNextUrls($curCookie) ) {
			$curlOptions = $options ;
			if ( $curCookie ) {
				$curlOptions[CURLOPT_COOKIE] = $curCookie ;
			}
			$id = $this->_curList['id'] ;
			$ua = isset($this->_meta[$id]['ua']) ? $this->_meta[$id]['ua'] : self::FAST_USER_AGENT ;
			$curlOptions[CURLOPT_USERAGENT] = $ua ;

			if ( $this->_isDebug ) {
				$this->_debugLog($ua . ' crawling ' . $server_ip . ' ' . $id . ' urls (cur_pos:' . $this->_meta[$id]['curpos'] . ') with cookie ' . $curCookie . ' ' . print_r($urls, true)) ;
			}

			$regular = array();
			$ajax = array();
			foreach ($urls as $url) {
				if ($server_ip) {
					// replace domain with direct IP
					if (preg_match($pattern, $url, $m)) {
						$domain = $m[1];
						$pos = strpos($url, $domain);
						$url2 = substr($url, 0, $pos) . $server_ip . substr($url, $pos + strlen($domain));
						$curlOptions[CURLOPT_HTTPHEADER][] = "Host: $domain";
					}
					else {
						if ( $this->_isDebug ) {
							$this->_debugLog('invalid url ' . $url);
						}
						continue;
					}
				}
				else {
					$url2 = $url;
				}
				if ($url2{0} == ':')
					$ajax[] = substr($url2, 1);
				else
					$regular[] = $url2;
			}

			try {
				if (count($regular)) {
					$client->multiRequest($regular, $curlOptions) ;
				}
				if (count($ajax)) {
					$curlOptions[CURLOPT_HTTPHEADER][] = 'X-Requested-With: XMLHttpRequest';
					$client->multiRequest($ajax, $curlOptions) ;
				}
			} catch ( Exception $e ) {
				$endReason = 'Error when crawling url ' . implode(' ', $urls) . ' : ' . $e->getMessage() ;
				break ;
			}

			$this->_finishCurPosition() ;

			if ( $this->_meta['lastupdate'] > $this->_maxRunTime ) {
				$endReason = Mage::helper('litemage/data')->__('Stopped due to exceeding defined Maximum Run Time.') ;
				break ;
			}

			if ( $this->_meta['lastupdate'] - 60 > $this->_curThreadTime ) {
				$this->_adjustCurThreads() ;
				if ( $this->_curThreads == 0 ) {
					$endReason = Mage::helper('litemage/data')->__('Stopped due to current system load exceeding defined load limit.') ;
					break ;
				}
			}
			usleep(500) ;
		}
		$this->_meta['endreason'] = $endReason ;

		$this->_saveMeta() ;
		if ( $this->_isDebug ) {
			$this->_debugLog($endReason . ' cron meta end = ' . print_r($this->_meta, true)) ;
		}
	}

	protected function _getCrawlListFileData( $listId )
	{
		$filename = $this->_listDir . DS . self::WARMUP_MAP_FILE . '_' . strtolower($listId) ;
		if ( ! file_exists($filename) )
			return null ;
		else
			return trim(file_get_contents($filename)) ;
	}

	protected function _saveCrawlListFileData( $listId, $urls )
	{
		$size = count($urls);
		$now = time();
		$this->_meta[$listId]['listsize'] = $size ;
		$this->_meta[$listId]['gentime'] = $now ;
		$this->_meta[$listId]['lastendtime'] = $this->_meta[$listId]['endtime'] ;
		$this->_meta[$listId]['endtime'] = ($size == 0) ? $now : 0 ;
		$this->_meta[$listId]['lastquerytime'] = 0 ;
		$this->_meta[$listId]['curpos'] = 0 ;
		$this->_meta[$listId]['curvary'] = '' ;
		$this->_meta[$listId]['queried'] = 0 ;

		$this->_meta['lastupdate'] = $this->_meta[$listId]['gentime'] ;
		$header = $this->_meta[$listId]['gentime'] . "\t"
				. $this->_meta[$listId]['listsize'] . "\t"
				. $this->_meta[$listId]['env'] . "\n" ;

		if ( $this->_isDebug ) {
			$this->_debugLog('Generate url map for ' . $listId . ' url count=' . $this->_meta[$listId]['listsize']) ;
		}

		$buf = $header . implode("\n", $urls) ;

		$filename = $this->_listDir . DS . self::WARMUP_MAP_FILE . '_' . strtolower($listId) ;
		if ( ! file_put_contents($filename, $buf) ) {
			$this->_debugLog('Failed to save url map file ' . $filename) ;
		}
		else {
			chmod($filename, 0644) ;
		}
	}

	protected function _prepareCurList()
	{
		if ( empty($this->_priority) )
			return false ;

		if ( $this->_priority[0] == 'delta' ) {
			if ( $this->_prepareDeltaList() ) {
				return true ;
			}
			array_shift($this->_priority) ;
		}
		elseif ( $this->_priority[0]{0} == 'M') {
			$this->_maintainAutoList(substr(array_shift($this->_priority), 1));
			return $this->_prepareCurList() ;
		}

		$id = array_shift($this->_priority) ;
		if ( $id == null ) {
			return false ;
		}

		$m = &$this->_meta[$id] ;
		$this->_curList = array();

		if ( $m['gentime'] > 0 && $m['endtime'] == 0 && ($urls = $this->_getCrawlListFileData($id))
				!= null ) {
			$allurls = explode("\n", $urls) ;
			// verify data
			$header = explode("\t", array_shift($allurls)) ;
			if ( ($m['gentime'] == $header[0]) && ($m['listsize'] == $header[1]) && ($m['env']
					== $header[2]) && count($allurls) == $m['listsize'] ) {
				$this->_curList['urls'] = $allurls ;
			}
			else if ( $this->_isDebug ) {
				$this->_debugLog('load saved url list, header does not match, will regenerate') ;
			}
		}

		if ( ! isset($this->_curList['urls']) ) {
			// regenerate
			$this->_curList['urls'] = $this->_generateUrlList($id) ;
		}

		if ( $m['listsize'] == 0 ) {
			// get next list
			return $this->_prepareCurList() ;
		}	
		
		// parse env & get all possible varies
		$vary = array() ;
		$fixed = 'litemage_cron=' . $id . ';' ;
		$fixed .= $this->_parseEnvCookies($m['env'], $vary) ;
		if ( ! in_array($m['curvary'], $vary) || $m['curpos'] > $m['listsize'] ) {
			// reset current pointer
			$m['curvary'] = $vary[0] ;
			$m['curpos'] = 0 ;
			if ( $this->_isDebug ) {
				$this->_debugLog('Reset current position pointer to 0. curvary is ' . $m['curvary']) ;
			}
		}

		while ( ! empty($vary) && ($m['curvary'] != $vary[0]) ) {
			array_shift($vary) ;
		}
		
		$this->_curList['id'] = $id;
		$this->_curList['fixed'] = $fixed;
		$this->_curList['vary'] = $vary;
		$this->_curList['working'] = 0;
		
		return true ;
	}

	protected function _prepareDeltaList()
	{
		$m = &$this->_meta['delta'] ;
		if ( isset($this->_curDelta['storeurls']) && ($m['endtime'] > 0) ) {
			array_shift($this->_curDelta['ids']) ;
			if ( empty($this->_curDelta['ids']) ) {
				// switch to next tag
				unset($this->_curDelta['storeurls']) ;
				$m['curtag'] = '' ;
			}
			else {
				$m['curlist'] = $this->_curDelta['ids'][0] ;
				$m['curpos'] = 0 ;
				$m['curvary'] = '' ;
				$m['endtime'] = 0 ;
			}
		}
		if ( ! isset($this->_curDelta['storeurls']) && ! $this->_loadNextDeltaTag() ) {
			return false ;
		}

		if ( ! $m['curlist'] ) {
			$m['curlist'] = $this->_curDelta['ids'][0] ;
		}

		while ( $m['curlist'] != $this->_curDelta['ids'][0] ) {
			array_shift($this->_curDelta['ids']) ;
		}

		$urls	 = array();
		$depth	 = $this->_meta['deltaDepth'][$m['curlist']];
		foreach ($this->_curDelta['storeurls'][$m['curlist']] as $level => $ud) {
			if (is_int($level) && $level <= $depth) {
				$u = array();
				foreach ($ud as $url => $data) {
					if (($level == 0 && count($u) == 0) // always include first one
							|| (($data[1] & 28) > 0 ) // auto+cust+store = 16+8+4 = 28, from crawler list
							|| ($data[0] > 10)) { // or visitor count > 10 (hard coded number for now)
						$u[] = $url;
					}
				}
				$urls = array_merge($urls, $u);
			}
		}

		$m['listsize'] = count($urls) ;

		$id = 'delta' . $m['curlist'] ;
		if ( isset($this->_conf['store'][$id]['fixed']) ) {
			$fixed = $this->_conf['store'][$id]['fixed'] ;
			$vary = $this->_conf['store'][$id]['vary'] ;
		}
		else {
			$vary = array() ;
			$fixed = 'litemage_cron=' . $id . ':' . $m['curtag'] . ';' ;
			$fixed .= $this->_parseEnvCookies($this->_conf['store'][$id]['env'], $vary) ;
			$this->_conf['store'][$id]['fixed'] = $fixed ;
			$this->_conf['store'][$id]['vary'] = $vary ;
		}
		$m['baseurl'] = $this->_conf['store'][$id]['baseurl'] ;

		if ( ! in_array($m['curvary'], $vary) || $m['curpos'] > $m['listsize'] ) {
			// reset current pointer
			$m['curvary'] = $vary[0] ;
			$m['curpos'] = 0 ;
			if ( $this->_isDebug ) {
				$this->_debugLog('Reset current position pointer to 0. curvary is ' . $m['curvary']) ;
			}
		}

		while ( $m['curvary'] != $vary[0] ) {
			array_shift($vary) ;
		}

		$this->_curList = array(
			'id' => 'delta', 'fixed' => $fixed, 'vary' => $vary, 'working' => 0, 'urls' => $urls ) ;

		if ( $this->_isDebug ) {
			$this->_debugLog('current delta list for tag ' . $m['curtag'] . ' ' . print_r($this->_curList, true)) ;
		}
		return true ;
	}

	protected function _parseEnvCookies( $env, &$vary )
	{
		$fixed = '' ;
		if ( $env ) {
			$lsvary = array() ;
			$multiCurr = array( '-' ) ; // default currency
			$multiCgrp = array( '-' ) ; // default user group

			$env = trim($env, '/') ;
			$envs = explode('/', $env) ;
			$envVars = array() ;
			$cnt = count($envs) ;
			for ( $i = 0 ; ($i + 1) < $cnt ; $i+=2 ) {
				$envVars[$envs[$i]] = $envs[$i + 1] ;
			}
			if ( isset($envVars['vary_dev']) ) {
				$lsvary['dev'] = 1 ;
			}

			if ( isset($envVars['store']) ) {
				$fixed .= Mage_Core_Model_Store::COOKIE_NAME . '=' . $envVars['store'] . ';' ;
				$lsvary['st'] = $envVars['storeId'] ;
			}

			if ( isset($envVars['vary_cgrp']) ) {
				$multiCgrp = explode(',', $envVars['vary_cgrp']) ;
			}

			if ( isset($envVars['vary_curr']) ) {
				$multiCurr = explode(',', $envVars['vary_curr']) ;
			}

			foreach ( $multiCurr as $currency ) {
				$cookie_vary = '' ;
				$lsvary1 = $lsvary ;

				if ( $currency != '-' ) {
					$lsvary1['curr'] = $currency ;
					$cookie_vary .= Mage_Core_Model_Store::COOKIE_CURRENCY . '=' . $currency . ';' ;
				}

				foreach ( $multiCgrp as $cgrp ) {
					
					$cookie_vary2 = $cookie_vary;
					$lsvary2 = $lsvary1;
					
					if ( $cgrp != '-' ) {
						// need to set user id, group_userid
						if ($pos = strpos($cgrp, '_')) {
							$group = substr($cgrp, 0, $pos);
							$customerId = substr($cgrp, $pos+1);
							if ($group == 'review') {
								$cookie_vary2 .= '_lscache_vary_review=write%7E1%7E;' ;
							}
							else {
								$lsvary2['cgrp'] = $group ;
							}
							$cookie_vary2 .= 'lmcron_customer=' . $customerId . ';' ;
						}
					}

					if ( ! empty($lsvary2) ) {
						ksort($lsvary2) ;
						$lsvary2_val = '' ;
						foreach ( $lsvary2 as $k => $v ) {
							$lsvary2_val .= $k . '%7E' . urlencode($v) . '%7E' ; // %7E is "~"
						}
						$cookie_vary2 .= self::ENV_COOKIE_NAME . '=' . $lsvary2_val . ';' ;
					}
					$vary[] = $cookie_vary2 ; // can be empty string for default no vary
				}
			}
		}
		else {
			$vary[] = '' ; // no vary
		}
		return $fixed ;
	}

	protected function _getNextUrls( &$curCookie )
	{
		$this->_curList['working'] = 0 ;
		$id = $this->_curList['id'] ;
		if ( $this->_meta[$id]['endtime'] > 0 ) {
			if ( $this->_prepareCurList() ) {
				return $this->_getNextUrls($curCookie) ;
			}
			else {
				return null ;
			}
		}
		$isAutoList = ($id{0} == 'a');
		$curpos = $this->_meta[$id]['curpos'] ;
		$curCookie = $this->_curList['fixed'] . $this->_meta[$id]['curvary'] ;

		if ($isAutoList) {
			// {tag}:url
			$curtag = '';
			$urls = array();
			for ($i = 0; $i < $this->_curThreads ; $i ++) {
				if (!isset($this->_curList['urls'][$curpos]))
					break;

				$line = $this->_curList['urls'][$curpos];
				$curpos ++;

				if ($pos = strpos($line, '}')) {
					$url = substr($line, $pos+1);
					$tag = substr($line, 1, $pos-1);
				}
				else {
					// bad line, ignore
					continue;
				}

				if ($curtag == '') {
					$curtag = $tag;
				}
				elseif ($curtag != $tag) {
					break;
				}
				$urls[] = $url;
			}
			if ($curtag) {
			 //'litemage_cron=' . $id . ':' . $m['curtag'] . ';' ;
				$replace = '$1' . ':' . $curtag . ';';
				$curCookie = preg_replace('/(litemage_cron=[^;]+);/', $replace, $curCookie);
			}
		}
		else {
			$urls = array_slice($this->_curList['urls'], $curpos, $this->_curThreads) ;
		}

		if ( empty($urls) ) {
			return null ;
		}
		else {
			$baseurl = $this->_meta[$id]['baseurl'] ;
			foreach ( $urls as $key => $val ) {
				if ($val != '' && $val{0} == ':') {
					$val = substr($val, 1);
					$urls[$key] = ':' . $baseurl . $val ; // ajax
				}
				else {
					$urls[$key] = $baseurl . $val ;
				}
			}
			$this->_curList['working'] = count($urls) ;
			return $urls ;
		}
	}

	protected function _finishCurPosition()
	{
		$now = time() ;
		$id = $this->_curList['id'] ;
		if ( ($this->_meta[$id]['curpos'] + $this->_curList['working']) < $this->_meta[$id]['listsize'] ) {
			$this->_meta[$id]['curpos'] += $this->_curList['working'] ;
		}
		else {
			if ( count($this->_curList['vary']) > 1 ) {
				array_shift($this->_curList['vary']) ;
				$this->_meta[$id]['curvary'] = $this->_curList['vary'][0] ;
				$this->_meta[$id]['curpos'] = 0 ;
			}
			else {
				$this->_meta[$id]['endtime'] = $now ;
				$this->_meta[$id]['curpos'] = $this->_meta[$id]['listsize'] ;
			}
		}
		$this->_meta[$id]['queried'] += $this->_curList['working'] ;
		$this->_meta[$id]['lastquerytime'] = $now ;
		$this->_meta['lastupdate'] = $now ;
		$this->_curList['working'] = 0 ;
	}

	protected function _newStoreMeta( $storeInfo, $tmpmsg )
	{
		$meta = array(
			'id' => $storeInfo['id'], // store1, custom1, delta
			'storeid' => $storeInfo['storeid'],
			'store_name' => $storeInfo['store_name'],
			'default_curr' => $storeInfo['default_curr'],
			'baseurl' => $storeInfo['baseurl'],
			'ttl' => $storeInfo['ttl'],
			'interval' => $storeInfo['interval'],
			'priority' => $storeInfo['priority'],
			'lastendtime' => 0,
			'gentime' => 0,
			'listsize' => 0,
			'env' => $storeInfo['env'],
			'ua' => self::FAST_USER_AGENT,
			'curpos' => 0,
			'curvary' => '',
			'queried' => 0,
			'lastquerytime' => 0,
			'endtime' => 0 ) ;
		if ( isset($storeInfo['file']) ) {
			$meta['file'] = $storeInfo['file'] ;
		}
		if ( $tmpmsg ) {
			$meta['tmpmsg'] = $tmpmsg ;
		}

		return $meta ;
	}

	protected function _resetDeltaMeta( $time, $curtag, $pending )
	{
		if ( ! isset($this->_meta['delta']) ) {
			$this->_meta['delta'] = array( 'time' => -1 ) ;
		}
		$m = &$this->_meta['delta'] ;
		$now = time() ;
		if ( $this->_meta['delta']['time'] != $time ) {
			// new delta list
			$this->_meta['delta'] = array(
				'time' => $time,
				'priority' => 0,
				'gentime' => $now,
				'listsize' => 0,
				'ua' => self::FAST_USER_AGENT,
				'curtag' => $curtag,
				'pending' => 0,
				'curlist' => '',
				'curpos' => 0,
				'curvary' => '',
				'queried' => 0,
				'lastquerytime' => 0,
				'endtime' => 0
			) ;
		}
		elseif ( $this->_meta['delta']['curtag'] != $curtag ) {
			$m['curtag'] = $curtag ;
			$m['gentime'] = $now ;
			$m['pending'] = $pending ;
			$m['curlist'] = '' ;
			$m['curpos'] = 0 ;
			$m['curvary'] = '' ;
			$m['lastquerytime'] = 0 ;
			$m['endtime'] = 0 ;
		}
		else {
			$m['pending'] = $pending ;
			if ( ! in_array($m['curlist'], $this->_meta['deltalist']) ) {
				$m = &$this->_meta['delta'] ;
				$m['curlist'] = '' ;
				$m['gentime'] = $now ;
				$m['curpos'] = 0 ;
				$m['curvary'] = '' ;
				$m['lastquerytime'] = 0 ;
				$m['endtime'] = 0 ;
			}
		}
	}

	protected function _saveMeta( $meta = null )
	{
		if ( $meta == null ) {
			$meta = $this->_meta ;
		}
		if ( $this->_helper->useInternalCache() ) {
			$cacheId = $this->_isDelta ? self::DELTA_META_CACHE_ID : self::WARMUP_META_CACHE_ID;
			$tags = array( $cacheId ) ;
			$this->_helper->saveInternalCache(serialize($meta), $cacheId, $tags) ;
		}
	}

	protected function _initMeta()
	{
		$this->_meta = array() ;

		$saved = array() ;
		if ( $meta = Mage::app()->loadCache(self::WARMUP_META_CACHE_ID) ) {
			$saved = unserialize($meta) ;
			if ( isset($saved['lastupdate']) ) {
				$this->_meta['lastupdate'] = $saved['lastupdate'] ;
			}
			if ( isset($saved['endreason']) ) {
				$this->_meta['endreason'] = $saved['endreason'] ;
			}
		}

		if ( empty($this->_conf['store']) ) {
			return array() ;
		}

		$unfinished = array() ;
		$expired = array() ;
		$curtime = time() ;
		$auto = array();

		foreach ( $this->_conf['store'] as $listId => $info ) {
			if ( $listId{0} == 'd' ) {
				// delta list
				continue ;
			}
			$tmpmsg = '' ;
			if ( isset($saved[$listId]) ) {
				// validate saved
				$m = $saved[$listId] ;
				if ( isset($m['storeid']) && ($m['storeid'] == $info['storeid']) && isset($m['env'])
						&& ($m['env'] == $info['env']) && isset($m['interval']) && ($m['interval']
						== $info['interval']) && isset($m['priority']) && ($m['priority'] == $info['priority'])
						&& isset($m['baseurl']) && ($m['baseurl'] == $info['baseurl']) ) {

					if ( $m['gentime'] == 0 ) {
						$tmpmsg = 'New list will be generated.' ;
						$unfinished[$listId] = $m['priority'] ;
					}
					elseif ( $m['endtime'] == 0 ) {
						// not finished
						if ($m['lastendtime']== 0) {
							$unfinished[$listId] = $m['priority'] ;
						}
						else {
							$expired[$listId] = $m['priority'] ;
						}
						$tmpmsg = 'Has not finished, will continue.' ;
					}
					elseif ( ($m['endtime'] + $m['interval'] < $curtime ) ) {
						// expired
						$expired[$listId] = $m['priority'] ;
						$m['ua'] = self::USER_AGENT ;
						$tmpmsg = 'Run interval passed, will restart.' ;
					}
					else {
						$tmpmsg = 'Still fresh within interval.' ;
						if ($listId{0} == 'a') {
							// maintain auto
							$auto[] = 'M' . $listId;
						}
					}
					$m['tmpmsg'] = $tmpmsg ;
					$this->_meta[$listId] = $m ;
				}
				else {
					$tmpmsg = 'Saved configuration does not match current configuration. List will be regenerated.' ;
					$m['gentime'] = 0 ;
					if ( $m['lastendtime'] == 0 ) {
						$unfinished[$listId] = $m['priority'] ;
					}
					else {
						$expired[$listId] = $m['priority'] ;
						$m['ua'] = self::USER_AGENT ;
					}
				}
			}
			else {
				$tmpmsg = 'New list will be generated' ;
				$m['gentime'] = 0 ;
				$unfinished[$listId] = $info['priority'] ;
			}
			if ( ! isset($this->_meta[$listId]) ) {
				$this->_meta[$listId] = $this->_newStoreMeta($info, $tmpmsg) ;
			}
		}

		asort($unfinished, SORT_NUMERIC) ;
		asort($expired, SORT_NUMERIC) ;
		$priority = array_merge(array_keys($unfinished), array_keys($expired), $auto) ;

		return $priority ;
	}

	protected function _initDeltaMeta()
	{
		$this->_meta = array() ;
		$priority = array();

		$saved = array() ;
		if ( $meta = Mage::app()->loadCache(self::DELTA_META_CACHE_ID) ) {
			$saved = unserialize($meta) ;
			if ( isset($saved['lastupdate']) ) {
				$this->_meta['lastupdate'] = $saved['lastupdate'] ;
			}
			if ( isset($saved['endreason']) ) {
				$this->_meta['endreason'] = $saved['endreason'] ;
			}
		}

		if ( empty($this->_conf['store']) ) {
			return $priority ;
		}

		$delta = array() ;
		$depth = array();

		foreach ( $this->_conf['store'] as $listId => $info ) {
			if ( $listId{0} == 'd' ) {
				// delta list
				$storeId = $info['storeid'];
				$delta[$storeId] = $info['priority'] ;
				$depth[$storeId] = $info['depth'];
			}
		}

		if ( ! empty($delta) ) {
			asort($delta, SORT_NUMERIC) ;
			$this->_meta['deltalist'] = array_keys($delta) ;
			$this->_meta['deltaDepth'] = $depth;
			if ( isset($saved['delta']) ) {
				$this->_meta['delta'] = $saved['delta'] ;
			}
			else {
				$this->_resetDeltaMeta(0, '', 0) ;
			}
			$priority[] = 'delta';
		}

		return $priority ;
	}

	protected function _loadNextDeltaTag()
	{
		$deltaCacheId = Litespeed_Litemage_Helper_Data::LITEMAGE_DELTA_CACHE_ID ;
		$result = Mage::app()->loadCache($deltaCacheId) ;
		if ( ! $result )
			return false ; // cache reset

		$delta = unserialize($result) ;
		$this->_curDelta = array() ;

		$curtag = '' ;
		$curIds = array() ;
		$updated = false ;

		while ( ! empty($delta['tags']) ) {
			$tag = array_shift($delta['tags']) ;
			$updated = true ;
			$cacheId = 'LITEMAGE_AUTOURL_' . $tag ;
			if ( $data = Mage::app()->loadCache($cacheId) ) {
				$tagdata = unserialize($data) ;
				foreach ( $this->_meta['deltalist'] as $storeId ) {
					if ( ! empty($tagdata[$storeId][0]) ) {
						$curIds[] = $storeId ;
					}
				}
				if ( count($curIds) ) {
					$curtag = $tag ;
					$this->_curDelta['storeurls'] = $tagdata ;
					$this->_curDelta['ids'] = $curIds ;
					$this->_curDelta['tag'] = $tag ;
					break ;
				}
			}

			if ( $this->_isDebug ) {
				$this->_debugLog('No urls saved for current delta tag ' . $tag . ' - bypass') ;
			}
		}

		if ( $updated ) {
			$this->_helper->saveInternalCache(serialize($delta), $deltaCacheId) ;
		}

		$this->_resetDeltaMeta($delta['time'], $curtag, count($delta['tags'])) ;
		return ($curtag != '') ;
	}

	protected function _init()
	{
		if ( empty($this->_conf['store']) ) {
			return 'configuration not enabled.' ;
		}

		if ( ! $this->_helper->useInternalCache() ) {
			return 'cache storage is disabled' ;
		}

		$this->_priority = $this->_isDelta ? $this->_initDeltaMeta() : $this->_initMeta() ;
		if ( empty($this->_priority) ) {
			return 'no URL list scheduled for warm up' ;
		}

		$maxTime = (int) ini_get('max_execution_time') ;
		if ( $maxTime == 0 )
			$maxTime = 300 ; // hardlimit 
		else
			$maxTime -= 5 ;

		$configed = $this->_conf[Litespeed_Litemage_Helper_Data::CFG_WARMUP_MAXTIME] ;
		if ( $maxTime >= $configed ) {
			$maxTime = $configed ;
		}
		else if (ini_set('max_execution_time', $configed + 15 ) !== false) {
			$maxTime = $configed;
		}
		$this->_maxRunTime = $maxTime + time() ;

		$this->_adjustCurThreads() ;

		if ( $this->_curThreads == 0 ) {
			return 'load over limit' ;
		}

		if ( $this->_prepareCurList() )
			return '' ; // no err msg
		else {
			return 'No url list available' ;
		}
	}

	protected function _adjustCurThreads()
	{
		$max = $this->_conf[Litespeed_Litemage_Helper_Data::CFG_WARMUP_THREAD_LIMIT] ;
		$limit = $this->_conf[Litespeed_Litemage_Helper_Data::CFG_WARMUP_LOAD_LIMIT] ;

		$load = sys_getloadavg() ;
		$curload = 1; //$load[0] ;

		if ( $this->_curThreads == -1 ) {
			// init
			if ( $curload > $limit ) {
				$curthreads = 0 ;
			}
			elseif ( $curload >= ($limit - 1) ) {
				$curthreads = 1 ;
			}
			else {
				$curthreads = intval($limit - $curload) ;
				if ( $curthreads > $max ) {
					$curthreads = $max ;
				}
			}
		}
		else {
			// adjust
			$curthreads = $this->_curThreads ;
			if ( $curload >= $limit + 1 ) {
				sleep(5) ;  // sleep 5 secs
				if ( $curthreads >= 1 )
					$curthreads -- ;
			}
			elseif ( $curload >= $limit ) {
				if ( $curthreads > 1 ) // if already 1, keep
					$curthreads -- ;
			}
			elseif ( ($curload + 1) < $limit ) {
				if ( $curthreads < $max )
					$curthreads ++ ;
			}
		}


		if ( $this->_isDebug ) {
			$this->_debugLog('set current threads = ' . $curthreads . ' previous=' . $this->_curThreads
					. ' max_allowed=' . $max . ' load_limit=' . $limit . ' current_load=' . $curload) ;
		}

		$this->_curThreads = $curthreads ;
		$this->_curThreadTime = time() ;
	}

	protected function _generateUrlList( $listId )
	{
		switch ( $listId{0} ) {
			case 's':
				return $this->_generateStoreUrlList($listId) ;
			case 'c':
				return $this->_generateCustUrlList($listId) ;
			case 'a':
				return $this->_generateAutoUrlList($listId) ;
			default:
				return array() ;
		}
	}

	protected function _generateStoreUrlList( $listId )
	{
		$app = Mage::app() ;
		$storeId = $this->_meta[$listId]['storeid'] ;
		$store = $app->getStore($storeId) ;
		$app->setCurrentStore($store) ;

		$baseUrl = $this->_meta[$listId]['baseurl'] ;
		$basen = strlen($baseUrl) ;

		$urls = array( '' ) ; // first line is empty for base url
		$rootCatId = $store->getRootCategoryId();

		$visibleAll = array('neq' => Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE);
		$visibility = array('in'=> array(
			Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH,
			Mage_Catalog_Model_Product_Visibility::VISIBILITY_IN_CATALOG)) ;
		$status = array('eq' => Mage_Catalog_Model_Product_Status::STATUS_ENABLED);
		$catModel = Mage::getModel('catalog/category') ;

		$activeCat = $catModel->getCollection($storeId)->addIsActiveFilter() ;

		$produrls = array() ;
		// url with cat in path
		foreach ( $activeCat as $cat ) {
			$cid = $cat->getId();
			if ($cid == $rootCatId) {
				continue;
			}
			else {
				$caturl = $cat->getUrl() ;
				if ( strncasecmp($baseUrl, $caturl, $basen) == 0 ) {
					$urls[] = substr($caturl, $basen) ;
				}
				$prods = $cat->getProductCollection($storeId)
						->addUrlRewrite($cid)
						->addAttributeToFilter('visibility', $visibility)
						->addAttributeToFilter('status', $status);
			}
			foreach ($prods as $prod ) {
				$produrl = $prod->getProductUrl() ;
				if ( strncasecmp($baseUrl, $produrl, $basen) == 0 ) {
					$produrls[] = substr($produrl, $basen) ;
				}
			}
		}
		$produrls = array_unique($produrls) ;

		$collection = Mage::getResourceModel('catalog/product_collection');
        $collection->addStoreFilter($storeId)
            ->addAttributeToFilter('visibility', $visibleAll)
            ->addAttributeToFilter('status', $status);
        $prods = $collection->load();
		foreach ($prods as $prod) {
			$produrl = $prod->getProductUrl() ;
			if ( strncasecmp($baseUrl, $produrl, $basen) == 0 ) {
				$produrls[] = substr($produrl, $basen) ;
			}
		}
		$produrls = array_unique($produrls) ;

		$sitemap = (Mage::getConfig()->getNode('modules/MageWorx_XSitemap') !== false) ?
				'xsitemap/cms_page' : 'sitemap/cms_page' ;

		if (($sitemodel = Mage::getResourceModel($sitemap)) != null) {
			foreach ( $sitemodel->getCollection($storeId) as $item ) {
				$urls[] = $item->getUrl() ;
			}
		}

		$urls = array_merge($urls, $produrls) ;

		$this->_saveCrawlListFileData($listId, $urls) ;

		return $urls ;
	}
	
	protected function _generateCustUrlList( $listId )
	{
		$baseUrl = $this->_meta[$listId]['baseurl'] ;
		$basen = strlen($baseUrl) ;
		$custlist = $this->_meta[$listId]['file'] ;
		$lines = file($custlist, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ;
		$urls = array() ;
		if ( $lines === false ) {
			if ( $this->_isDebug ) {
				$this->_debugLog('Fail to read custom URL list file ' . $custlist) ;
			}
		}
		else if ( ! empty($lines) ) {
			$urls[] = '' ; // always add home page
			foreach ( $lines as $line ) {
				$line = ltrim(trim($line), '/') ;
				if ( $line != '' ) {
					if ( strpos($line, 'http') !== false ) {
						if ( strncasecmp($baseUrl, $line, $basen) == 0 ) {
							$urls[] = substr($line, $basen) ;
						}
					}
					else {
						$urls[] = $line ;
					}
				}
			}
			$urls = array_unique($urls) ;
		}

		$this->_saveCrawlListFileData($listId, $urls) ;

		return $urls ;
	}

	protected function _generateAutoUrlList( $listId )
	{
		$storeId = $this->_meta[$listId]['storeid'] ;
		$tagurls = $this->_maintainAutoList($listId);
		if (!$tagurls) {
			$file = $this->_listDir . DS . '_AUTO_STORE_' . $storeId ;
			if ( ! file_exists($file) ) {
				return array() ;
			}
			$tagurls = unserialize(file_get_contents($file)) ;
			if ( ! is_array($tagurls) ) {
				return array() ; // bad file
			}
		}
		$urls = array();
		foreach ($tagurls as $tag => $turls) {
			foreach ($turls as $url => $v) {
				$tagurl = '{' . $tag . '}';
				if ($v == 2) // for ajax
					$tagurl .= ':';
				$tagurl .= $url;
				$urls[] = $tagurl;
			}
		}

		$this->_saveCrawlListFileData($listId, $urls) ;

		return $urls ;
	}

	protected function _maintainAutoList($listId)
	{
		$storeId = $this->_meta[$listId]['storeid'] ;
		$pendingCacheId = 'LITEMAGE_AUTOURL_ADJ_S' . $storeId;
		$pending = null;
		if ( $result = Mage::app()->loadCache($pendingCacheId) ) {
			$pending = unserialize($result) ;
		}
		if (!$pending || !is_array($pending) || count($pending) <=1) {
			return null; // no pending tags
		}

		$autoconf = $this->_helper->getAutoCollectConf($storeId);
		// array('collect' => 0, 'crawlDelta' => 0, 'crawlAuto' => 0, 'frame' => 0, 'remove' => 0, 'deep' => 0, 'deltaDeep' => 0) ;

		$list = null;

		$file = $this->_listDir . DS . '_AUTO_STORE_' . $storeId ;
		if ( file_exists($file) ) {
			$list = unserialize(file_get_contents($file)) ;
		}
		if ( ! is_array($list) ) {
			$list = array();
		}
		unset($pending['utctime']);

		if (!$autoconf['collect']) {
			// only do single removal adjust
			foreach($pending as $tag => $pd) {
				if (isset($pd[1])) {
					foreach ($pd[1] as $url => $act) {
						if ($act == -1 && isset($list[$tag][$url])) {
							unset($list[$tag][$url]);
						}
					}
				}
			}
		}
		else {
			$now = time() - date('Z') ;
			foreach($pending as $tag => $pd) {
				$tagCacheId = 'LITEMAGE_AUTOURL_' . $tag;
				$tagUrls = null;
				if ( $result = Mage::app()->loadCache($tagCacheId) ) {
					$tagUrls = unserialize($result) ;
				}
				if (!$tagUrls || !isset($tagUrls[$storeId])) {
					// cache file changed, ignore
					continue;
				}
				$tagInitTime = $pd['t'];
				$cacheInitTime = $tagUrls[$storeId]['utctime'][0];

				if (($pd[0] == 1) || (($now - $cacheInitTime) > $autoconf['frame'])) {
					// is full check
					$stu = $tagUrls[$storeId];
					$orig = &$tagUrls[$storeId];
					$newAutoUrls = array();
					foreach ( $stu as $level => $data ) {
						if ( $level === 'utctime' ) {
							$orig['utctime'] = array( $now, $now ) ; // reset window
						}
						else {
							if ( $level > $autoconf['deep'] ) {
								// only check removal
								unset($orig[$level]) ;
								continue ;
							}

							foreach ( $data as $url => $ud ) {
								$visitorCount = $ud[0];
								$attr = $ud[1] ;
								// check if still qualify
								if ( (($attr & 8) == 0)  // not cron cust
										&& (($attr & 4) == 0) // not cron store
										&& (($visitorCount >= $autoconf['collect']) // over add limit
										|| (isset($list[$tag][$url]) && ($visitorCount >= $autoconf['remove']))) // over remove limit
								) {
									$newAutoUrls[$url] = ($attr & 32) ? 2 : 1 ; // isajax = 2
								}
								// reset
								$orig[$level][$url] = array( 0, 0 ) ;
							}
						}
					}

					$this->_helper->saveInternalCache(serialize($tagUrls), $tagCacheId) ;

					if (!empty($newAutoUrls)) {
						$list[$tag] = $newAutoUrls;	// refresh autolist
					}
					elseif (isset($list[$tag])) { // remove from autolist
						unset($list[$tag]);
					}
				}
				elseif (isset($pd[1])) { // only do url check, act: -1(remove), 1(add regular), 2(add ajax)
					foreach ($pd[1] as $url => $act) {
						if (isset($list[$tag][$url])) {
							// in list already, check if removal
							if ($act == -1) {
								unset($list[$tag][$url]);
							}
						}
						else if ($act == 1 || $act == 2) {
							$list[$tag][$url] = $act;
						}
					}
					if (empty($list[$tag])) {
						unset($list[$tag]);
					}

				}
			}
		}
		if ( ! file_put_contents($file, serialize($list)) ) {
			$this->_debugLog('Failed to save AUTO list ' . $file) ;
		}
		else {
			chmod($file, 0644) ;
			Mage::app()->removeCache($pendingCacheId);
		}
		return $list;
	}

	protected function _debugLog( $message, $level = 0 )
	{
		if ( $this->_isDebug ) {
			$message = $this->_debugTag . ' ' . str_replace("\n", ("\n" . $this->_debugTag . '  '), $message) ;
			if (($this->_isDebug & 1) == 1) {
				Mage::log($message) ;
			}
			if ($this->_isDelta && (($this->_isDebug & 2) == 2)) {
				//($message, $level = null, $file = '', $forceLog = false)
				Mage::log($message, null, 'lmdelta.log', true) ;
			}
		}
	}

}
