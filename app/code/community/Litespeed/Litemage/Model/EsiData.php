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


class Litespeed_Litemage_Model_EsiData
{

	const ACTION_GET_FORMKEY = 'getFormKey';
	const ACTION_GET_NICKNAME = 'getNickName';
	const ACTION_LOG = 'log';
	const ACTION_GET_BLOCK = 'getBlock';
	const ACTION_GET_COMBINED = 'getCombined';
	const ACTION_GET_MESSAGE = 'getMessage';

	const BATCH_DIRECT = '_DIR_';
	const BATCH_HANLE = '_HAN_';
	const BATCH_LAYOUT_READY = '_LAY_';

    //protected $_isDebug;

	protected $_url;
	protected $_rawOutput = null;
	protected $_responseCode;

	protected $_action;
	protected $_cacheAttr = array('tag' => '', 'ttl' => 0, 'access' => 'private', 'cacheIfEmpty' => false);
	protected $_layoutAttr = array('bi' => '', 'h' => '');
	protected $_data;
	protected $_batchId;
	protected $_layoutIdentifier;
	protected $_layoutXml;
	protected $_layoutCacheId;

	public function __construct($url, $configHelper)
    {
		$params = $this->_parseUrlParams($url, $configHelper);
		switch ($this->_action) {
			case self::ACTION_GET_FORMKEY:
				$this->_initFormKey($configHelper);
				break;
			case self::ACTION_GET_NICKNAME:
				$this->_initNickName($configHelper);
				break;
			case self::ACTION_LOG:
				$this->_initLogProduct($params);
				break;
			case self::ACTION_GET_COMBINED:
				$this->_initCombined($params);
				break;
			case self::ACTION_GET_BLOCK:
				$this->_initBlock($params, $configHelper);
				break;
			case self::ACTION_GET_MESSAGE:
				$this->_initMessage($params, $configHelper);
				break;
			default:
				$this->_exceptionOut('invalid action ' . $this->_action);
		}
	}

	public function getAction()
	{
		return $this->_action;
	}

	public function getUrl()
	{
		return $this->_url;
	}

	public function getCacheAttribute($attr='')
	{
		if ($attr)
			return $this->_cacheAttr[$attr];
		else
			return $this->_cacheAttr;
	}

	public function getLayoutAttribute($attr='')
	{
		if ($attr)
			return $this->_layoutAttr[$attr];
		else
			return $this->_layoutAttr;
	}

	public function getBatchId()
	{
		return $this->_batchId;
	}

	public function getLayoutXml()
	{
		return $this->_layoutXml;
	}

	public function initLayoutCache($layoutUnique)
	{
		$this->_layoutCacheId = 'LAYOUT_ESI_' . md5($layoutUnique . '_' . $this->_layoutIdentifier);
		if ( Mage::app()->useCache('layout') ) {
			if ( $data = Mage::app()->loadCache($this->_layoutCacheId ) ) {
				$this->_layoutXml = $data;
				$this->_batchId = self::BATCH_LAYOUT_READY;
			}
		}
		return $this->_batchId;
	}

	public function saveLayoutCache($layoutUnique, $xmlString, $helper)
	{
		$this->_layoutCacheId = 'LAYOUT_ESI_' . md5($layoutUnique . '_' . $this->_layoutIdentifier);
		$this->_layoutXml = $xmlString;
		if ( $helper->useInternalCache() ) {
			$tags = array(Mage_Core_Model_Layout_Update::LAYOUT_GENERAL_CACHE_TAG ) ;
			$helper->saveInternalCache($xmlString, $this->_layoutCacheId, $tags) ;
		}
	}

	public function getLayoutCacheId()
	{
		return $this->_layoutCacheId;
	}

	public function hasRawOutput()
	{
		return ($this->_rawOutput !== null);
	}

	public function getRawOutput()
	{
		return $this->_rawOutput;
	}

	public function setRawOutput($rawOutput, $responseCode = 200)
	{
		$this->_rawOutput = trim($rawOutput);
		if (strlen($this->_rawOutput) && isset($this->_data['ajax']) && ($this->_data['ajax'] == 'strip')) {
			$this->_rawOutput = addslashes($this->_rawOutput);
		}
		$this->_responseCode = $responseCode;
		if ( $this->_cacheAttr['ttl'] > 0 && ($responseCode != 200)) { // for esi req, 301 and 404 also treat as error, nocache
			$this->_cacheAttr['ttl'] = 0 ;
		}
	}

	public function getInlineHtml($esiInlineTag, $shared)
	{
		$buf = '<' . $esiInlineTag . ' name="' . $this->_url . '" cache-control="' ;

		$ttl = $this->_cacheAttr['ttl'] ;

		if ( $ttl == 0 ) {
			$buf .= 'no-cache' ;
		}
		else {
			$buf .= $this->_cacheAttr['access'] . ',max-age=' . $ttl . ',no-vary' ;
			if ( $this->_cacheAttr['cacheIfEmpty'] )
				$buf .= ',set-blank' ;
			elseif ( $shared && ($this->_action != self::ACTION_GET_FORMKEY) ) {
				$buf .= ',shared' ;
			}
			
			$buf .= '" cache-tag="' . $this->_cacheAttr['tag'] ;
		}

		$buf .= '">' . $this->_rawOutput . "</$esiInlineTag>\n" ;

		return $buf ;
	}

	protected function _exceptionOut($err)
	{
		Mage::throwException('LiteMage module invalid esi url ' . $this->_url . ' Err: ' . $err) ;;
	}

	protected function _initBlock($params, $configHelper)
	{
		if (!isset($params['t']) || !isset($params['bi'])) {
			$this->_exceptionOut('missing param t_bi');
		}

		$bconf = $configHelper->getEsiConf('tag', $params['t']) ;
		if ( $bconf == null ) {
			$this->_exceptionOut('missing config for tag ' . $params['t']) ;
		}

		$this->_cacheAttr['tag'] = $bconf['cache-tag'];
		$this->_cacheAttr['access'] = $bconf['access'] ;
		if (isset($bconf['ttl'])) {
			$this->_cacheAttr['ttl'] = $bconf['ttl'];
		}
		elseif ($bconf['access'] == 'private') {
			$this->_cacheAttr['ttl'] = $configHelper->getConf(Litespeed_Litemage_Helper_Data::CFG_PRIVATETTL) ;
		}
		else {
			$this->_cacheAttr['ttl'] = $configHelper->getConf(Litespeed_Litemage_Helper_Data::CFG_PUBLICTTL) ;
		}

		$this->_layoutAttr['bi'] = $params['bi'];
		$this->_batchId = self::BATCH_HANLE;
		if (isset($params['h'])) {
			$this->_batchId = $this->_layoutAttr['h'] = $params['h'];
		}

		if ( isset($params['pc']) ) {
			$this->_batchId = self::BATCH_DIRECT;
			$this->_data['pc'] = $params['pc'] ; // dynamic block or message
		}
		else {
			$this->_layoutIdentifier = $params['_layout_Id_'];


		}
		if ( isset($params['pt']) ) {
			$this->_data['pt'] = $params['pt'] ; // dynamic block template
		}
		if ( isset($params['ajax'])) {
			$this->_data['ajax'] = $params['ajax'];
		}
    }

	protected function _initMessage($params, $configHelper)
	{
		$this->_initBlock($params, $configHelper);
		if ( isset($params['st']) ) {
			$this->_data['st'] = $params['st'] ;
			$this->_data['call'] = $params['call'] ;
			$this->_cacheAttr['cacheIfEmpty'] = true ;
		}
	}

	protected function _initFormKey($configHelper)
	{
		$this->_cacheAttr['ttl'] = $configHelper->getConf(Litespeed_Litemage_Helper_Data::CFG_PRIVATETTL) ;
		$this->_cacheAttr['tag'] = 'E.formkey';
		$this->_batchId = self::BATCH_DIRECT;
	}

	protected function _initNickName($configHelper)
	{
		$this->_cacheAttr['ttl'] = $configHelper->getConf(Litespeed_Litemage_Helper_Data::CFG_PRIVATETTL) ;
		$this->_cacheAttr['tag'] = 'E.welcome';
		$this->_batchId = self::BATCH_DIRECT;
	}

	protected function _initLogProduct( $params)
	{
		// ttl is 0, no cache
		if ( isset($params['product']) && isset($params['s']) ) {
			$this->_data['product'] = $params['product'];
			$this->_batchId = self::BATCH_DIRECT;
		}
		// else exception out
	}

	public function getData($key='')
	{
		if ($key) {
			if (isset($this->_data[$key]))
				return $this->_data[$key];
			else
				return null;
		}
		else
			return $this->_data;
	}

	protected function _initCombined($params)
	{
		if ( empty($_REQUEST['esi_include']) ) {
			$this->_exceptionOut('missing esi_include');
		}
	}

	protected function _procLogProduct( $params, $configHelper )
	{
		$this->_rawOutput = '';
		// ttl is 0, no cache

		if ( isset($params['product']) ) {
			if ( isset($params['s']) && ! isset($this->_env['s']) ) {
				$this->_env['s'] = $params['s'] ;
				Mage::app()->setCurrentStore(Mage::app()->getStore($params['s'])) ;
			}

			$product = new Varien_Object() ;
			$product->setId($params['product']) ;
			try {
				Mage::dispatchEvent('catalog_controller_product_view', array( 'product' => $product )) ;
			} catch ( Exception $e ) {
				if ( $this->_isDebug ) {
					$this->_config->debugMesg('_logData, exception for product ' . $product->getId() . ' : ' . $e->getMessage()) ;
				}
			}
		}
		return $esiData ;
	}


	protected function _parseUrlParams( $esiUrl, $configHelper )
	{
		$esiUrl = urldecode($esiUrl) ;
		$this->_url = $esiUrl;
		$pos = strpos($esiUrl, 'litemage/esi/') ;
		if ( $pos === false ) {
			return null;
		}

		$url1 = substr($esiUrl, $pos + 13);
		$buf = explode('/', $url1) ;
		$this->_action = $buf[0];

		$c = count($buf) ;
		$param = array() ;
		for ( $i = 1 ; ($i + 1) < $c ; $i+=2 ) {
			$param[$buf[$i]] = $buf[$i + 1] ;
		}
		$dparams = $configHelper->decodeEsiUrlParams($param);
		$dparams['_layout_Id_'] = $url1;
		
		$this->_data = array();
		if (isset($dparams['s']))
			$this->_data['s'] = $dparams['s'];
		if (isset($dparams['dp']))
			$this->_data['dp'] = $dparams['dp'];
		if (isset($dparams['dt']))
			$this->_data['dt'] = $dparams['dt'];
		
		if ($this->_action == self::ACTION_GET_COMBINED
				|| $this->_action == self::ACTION_GET_BLOCK
				|| $this->_action == self::ACTION_GET_MESSAGE) {
			if ( ! isset($dparams['s']) || ! isset($dparams['dp']) || ! isset($dparams['dt']) ) {
				$this->_exceptionOut('missing s_dp_dt') ;
			}
		}
		if (isset($dparams['extra'])) {
			$extra = base64_decode(strtr($dparams['extra'], '-_,', '+/='));
			$this->_data['extra'] = unserialize($extra);
		}
		return $dparams ;
	}

}

