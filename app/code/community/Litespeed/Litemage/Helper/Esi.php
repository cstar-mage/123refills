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
 * @copyright  Copyright (c) 2015-2017 LiteSpeed Technologies, Inc. (https://www.litespeedtech.com)
 * @license     https://opensource.org/licenses/GPL-3.0
 */


class Litespeed_Litemage_Helper_Esi
{

    const LSHEADER_PURGE = 'X-Litespeed-Purge' ;
    const LSHEADER_CACHE_CONTROL = 'X-Litespeed-Cache-Control' ;
    const LSHEADER_CACHE_TAG = 'X-Litespeed-Tag' ;
    const LSHEADER_CACHE_VARY = 'X-Litespeed-Vary';
    const TAG_PREFIX_CMS = 'G.' ;
    const TAG_PREFIX_CATEGORY = 'C.' ;
    const TAG_PREFIX_PRODUCT = 'P.' ;
    const TAG_PREFIX_ESIBLOCK = 'E.' ;

	//BITMASK for Cache Header Flag
    const CHBM_CACHEABLE = 1 ;
    const CHBM_PRIVATE = 2 ;
    const CHBM_ONLY_CACHE_EMPTY = 4 ;
    const CHBM_ESI_ON = 16 ;
    const CHBM_ESI_REQ = 32 ;
    const CHBM_FORMKEY_REPLACED = 64 ;
	const CHBM_NOT_CACHEABLE = 128 ; // for redirect

    const FORMKEY_REAL = '_litemage_realformkey' ;
    const FORMKEY_REPLACE = 'litemagefmkeylmg' ; //do not use special characters, maybe changed by urlencode
    const FORMKEY_NAME = '_form_key' ;

    const NICKNAME_REPLACE = 'litemagenicknamelmg' ; //do not use special characters, maybe changed by urlencode

    // config items
    protected $_viewedTracker ;
    protected $_cacheVars = array( 'tag' => array(), 'flag' => 0, 'ttl' => -1, 'env' => array(), 'internal' => array(), 'cookie' => array(), 'baseUrl' => '', 'baseUrlESI' => '' ) ;
	protected $_esiLayoutCache ;
    protected $_esiPurgeEvents = array() ;
	protected $_defaultEnvVaryCookie = '_lscache_vary'; // system default
    protected $_isDebug;
    protected $_config;


    public function __construct()
    {
        $this->_config = Mage::helper('litemage/data');
        $this->_isDebug = $this->_config->isDebug();
    }

    public function isDebug()
    {
        return $this->_isDebug;
    }

    public function setCacheControlFlag( $flag, $ttl = -1, $tag = '' )
    {
        $this->_cacheVars['flag'] = $flag ;
        if ( $tag )
            $this->_cacheVars['tag'][] = $tag ;
        if ( $ttl != -1 )
            $this->_cacheVars['ttl'] = $ttl ;
        // init esiconf
        $this->_config->getEsiConf('tag');
    }

	public function notCacheable()
	{
		return ( ($this->_cacheVars['flag'] & self::CHBM_NOT_CACHEABLE) == self::CHBM_NOT_CACHEABLE );
	}

    protected function _setEsiOn()
    {
        if ( ($this->_cacheVars['flag'] & self::CHBM_ESI_ON) == 0 ) {
            $this->_cacheVars['flag'] |= self::CHBM_ESI_ON ;
        }
    }

    public function getBaseUrl()
    {
        if ($this->_cacheVars['baseUrl'] == '') {
            $base = Mage::getBaseUrl(); // cannot use request->getBaseUrl, as store ID maybe in url
            $this->_cacheVars['baseUrl'] = $base;
			$esibase = $base;
			if ((stripos($base, 'http') !== false) && ($pos = strpos($base, '://'))) {
				// remove domain, some configuration will use multiple domain/vhosts map  to different one.
				$pos2 = strpos($base, '/', $pos+ 4);
				$esibase = ($pos2 === false) ? '/' : substr($base, $pos2);
			}
			$this->_cacheVars['baseUrlESI'] = $esibase;
        }

        return $this->_cacheVars['baseUrl'];
    }

	public function getEsiBaseUrl()
	{
		if ($this->_cacheVars['baseUrlESI'] == '') {
			$this->getBaseUrl();
		}
		return $this->_cacheVars['baseUrlESI'];
	}

    protected function _getSubReqUrl($route, $params)
    {
        $baseurl = $this->getEsiBaseUrl();
        $url = $baseurl . $route . '/';
		$eparams = $this->_config->encodeEsiUrlParams($params);
        foreach ( $eparams as $key => $value ) {
            $url .= $key . '/' . $value . '/';
        }
        return $url;
    }

    public function canInjectEsi()
    {
        $flag = $this->_cacheVars['flag'] ;
        return ((($flag & self::CHBM_CACHEABLE) != 0) && (($flag & self::CHBM_ESI_REQ) == 0)) ;
    }

    public function isEsiRequest()
    {
        $flag = $this->_cacheVars['flag'] ;
        return (($flag & self::CHBM_ESI_REQ) != 0) ;
    }

    public function initFormKey()
    {
        $session = Mage::getSingleton('core/session') ;
        if ( method_exists($session, 'getFormKey') ) {
            $cur_formkey = $session->getFormKey() ;
            if ( $cur_formkey != self::FORMKEY_REPLACE ) {
                $session->setData(self::FORMKEY_REAL, $cur_formkey) ;
                $session->setData(self::FORMKEY_NAME, self::FORMKEY_REPLACE) ;
            }
            $this->_cacheVars['flag'] |= self::CHBM_FORMKEY_REPLACED ;
        }
    }

    protected function _restoreFormKey()
    {
        if ( ($this->_cacheVars['flag'] & self::CHBM_FORMKEY_REPLACED) != 0 ) {
            $session = Mage::getSingleton('core/session') ;
            if ( ($realFormKey = $session->getData(self::FORMKEY_REAL)) != null ) {
                $session->unsetData(self::FORMKEY_REAL) ;
                $session->setData(self::FORMKEY_NAME, $realFormKey) ;
            }
        }
    }

	// $block instanceof Mage_Review_Block_Form
    public function initNickName($block)
    {
		$data = new Varien_Object();
		$data->setNickname(self::NICKNAME_REPLACE);
		$block->assign('data', $data);
		$this->_cacheVars['internal']['nickname'] = 1; // replaced
    }

    public function addPrivatePurgeEvent( $eventName, $tags=null )
    {
        // always set purge header, due to ajax call, before_reponse_send will not be triggered, also it may die out in the middle, so must set raw header using php directly
		if (isset($this->_esiPurgeEvents[$eventName]))
			return;

		if ($tags == null) {
			$tags = array() ;
			$this->_esiPurgeEvents[$eventName] = $eventName ;

			$events = $this->_config->getEsiConf('event');
			foreach ( $this->_esiPurgeEvents as $e ) {
				if (isset($events[$e])) {
					foreach($events[$e] as $t) {
						if (!in_array($t, $tags)) {
							$tags[] = $t;
						}
					}
				}
			}
		}

        if (count($tags)) {		
			$purgeHeader = 'private,' ;
			$t = '';
			foreach ($tags as $tag) {
				$t .= ( $tag == '*' ) ? '*' : 'tag=' . $tag . ',' ;
			}
			$purgeHeader .= trim($t, ',');
			
			header(self::LSHEADER_PURGE . ': ' . $purgeHeader, true);
			if ($this->_isDebug) {
				$this->_config->debugMesg("SetPurgeHeader: " . $purgeHeader . '  (triggered by event ' . $eventName . ')') ;
			}
		}
    }

    protected function _getPurgeHeaderValueByPublicTags($tags)
    {
		$this->_addDeltaByTags($tags);
		if (in_array('*', $tags)) {
			return '*';
		}

        $t = '';
        foreach ($tags as $tag) {
            $t .= 'tag=' . $tag . ',' ;
        }
        $purgeHeader = trim($t, ',');
        return $purgeHeader;
    }
	
    public function setPurgeHeader( $tags, $by, $response = null )
    {
        $purgeHeader = $this->_getPurgeHeaderValueByPublicTags($tags);

        if ( $response == null ) {
            $response = Mage::app()->getResponse() ;
        }
        $response->setHeader(self::LSHEADER_PURGE, $purgeHeader, true) ;
		if ($this->_isDebug) {
            $this->_config->debugMesg("SetPurgeHeader: " . $purgeHeader . '  (triggered by ' . $by . ')') ;
		}
    }
	
    public function setPurgeURLHeader( $url, $by )
    {
        $response = Mage::app()->getResponse() ;

        if ($this->_isDebug) {
            $this->_config->debugMesg("SetPurgeHeader: " . $url . '  (triggered by ' . $by . ')') ;
		}
        $response->setHeader(self::LSHEADER_PURGE, $url, true) ;
    }

    /*public function refreshPrivateSessionOnce($by)
    {
        header(self::LSHEADER_PURGE . ': once, private, *', false);
    }*/

    public function addCacheEntryTag( $tag )
    {
        $this->_cacheVars['tag'][] = $tag ;
    }

    public function trackProduct( $productId )
    {
        if ( $this->_viewedTracker == null )
            $this->_viewedTracker = array( 'product' => $productId ) ;
        else
            $this->_viewedTracker['product'] = $productId ;
    }

	public function getEsiIncludeHtml($block)
	{
		if (!isset($this->_esiLayoutCache)) {
			// load from cache
			$this->_initEsiLayoutCache($block);
		}

		$bi = $this->_getEsiBlockIndex($block);
		if (isset($this->_esiLayoutCache['blocks'][$bi]['e'])) {
			$html = $this->_esiLayoutCache['blocks'][$bi]['e'];
		}
		else {
			$html = $this->_loadEsiIncludeHtml($block, $bi);
		}
		return $html;
	}

    protected function _initEsiLayoutCache( $block )
    {
		/*
		 * _esiLayoutCache => array(),
		 *			'cacheId'
		 *			'esiUpdate'
		 *			'adjusted'
		 *			'blocks[blockindex][e] : esiinclude html string'
		 *								[h] : actual handle used
		 *								[b] : block name
		 */

		$update = $block->getLayout()->getUpdate();
		if ( ! $update instanceof Litespeed_Litemage_Model_Layout_Update) {
			Mage::throwException('LiteMage module requires Layout_Update class overwrite');
		}

		$tags = $update->getUsedHandles(); // used handles include customer_logged_in/out
        $tags[] = 'LITEMAGE_INJECT_ESI' ;
        $tags[] = join('-', $this->getEsiSharedParams()); // for env vary
        $cacheId = 'LITEMAGE_BLOCK_' . md5(join('__', $tags)) ;
        $this->_esiLayoutCache['cacheId'] = $cacheId ;
        $this->_setEsiOn() ;

        $preload = 0 ;
        $this->_esiLayoutCache = array('adjusted' => false,
			'layoutUpdate' => $update,
			'cacheId' => $cacheId,
			'blocks' => array());

        if ( $result = Mage::app()->loadCache($cacheId) ) {
            $preload = 1 ;
            $this->_esiLayoutCache['blocks'] = unserialize($result) ;
        }

        if ( $this->_isDebug ) {
			// 0 not in cache, 1 from cache
            $this->_config->debugMesg('INJECTING_' . $preload . '  ' . $_SERVER['REQUEST_URI']) ;
		}
    }

	protected function _loadEsiIncludeHtml($block, $bi)
	{
		$bconf = $block->getData('litemage_bconf');
		$blockName = $bconf['bn'];
		$blockHandles = null;
		$urlOptions = array('t' => $bconf['tag'], 'bi' => $bi);

		if (isset($bconf['is_dynamic'])) {
			$urlOptions['pc'] = $bconf['pc'];
			if (!is_null($block->getTemplate())) {
				$urlOptions['pt'] = $block->getTemplate();
			}
		}
		else {
			$blockHandles = $this->_getBlockHandles($blockName, $block);
		}

		if (!empty($blockHandles)) {
			$urlOptions['h'] = implode(',', $blockHandles);
		}
		if (!empty($bconf['extra'])) {
			$urlOptions['extra'] = strtr(base64_encode(serialize($bconf['extra'])), '+/=', '-_,');
		}
		$urlOptions = array_merge($urlOptions, $this->getEsiSharedParams());

		$esiUrl = $this->_getSubReqUrl('litemage/esi/getBlock', $urlOptions) ;
		// use single quote to work with pagespeed module
		$esiHtml = '<' . $this->_config->esiTag('include') . " src='" . $esiUrl . "' combine='sub' cache-tag='" . $bconf['cache-tag'] . "' cache-control='no-vary," . $bconf['access'] . "'/>" ;
		if ($this->_isDebug && !$bconf['valueonly']) {
			$esiHtml = '<!--Litemage esi started ' . $blockName . '-->' . $esiHtml . '<!--Litemage esi ended ' . $blockName . '-->' ;
		}

		$this->_esiLayoutCache['blocks'][$bi] = array(
			'h' => $blockHandles,	//actual handle used
			'e' => $esiHtml);		// esiinclude html string
		$this->_esiLayoutCache['adjusted'] = true;

		return $esiHtml;
	}

	protected function _getEsiBlockIndex($block)
	{
		// check if it's in layout, maybe a lost child introduced by bad layout
		$index = $this->_getEsiBlockIndexElement($block, $block->getLayout());
		return implode(';', $index);
	}

	protected function _getEsiBlockIndexElement($block, $layout)
	{
		// check if it's in layout, maybe a lost child introduced by bad layout
		$blockIndex = array();
		$blockName = $block->getNameInLayout();

		if ($layout->getBlock($blockName) !== $block) {
			$alias = $block->getBlockAlias();
			if ($alias != '' && $alias != $blockName) {
					$blockName .= ',' . $alias;
			}

			if ($parent = $block->getParentBlock()) {
				$blockIndex = $this->_getEsiBlockIndexElement($parent, $layout);
			}
		}
		$blockIndex[] = $blockName;
		return $blockIndex;
	}

    protected function _getBlockHandles($blockName, $block)
    {
        $blockNames = $this->_getChildrenNames($block, $block->getLayout()) ;
        if ( ($alias = $block->getBlockAlias()) && ($alias != $blockName) ) {
            array_unshift($blockNames, $blockName, $alias) ;
        }
        else {
            array_unshift($blockNames, $blockName) ;
        }

        $handles = $this->_esiLayoutCache['layoutUpdate']->getBlockHandles($blockNames);

		return $handles;
    }

    protected function _getChildrenNames( $block, $layout )
    {
        if ($block == null) {
            return array();
        }

        $children = $block->getSortedChildren() ;
        foreach ( $children as $childName ) {
            if ( $childBlock = $layout->getBlock($childName) ) {
                $alias = $childBlock->getBlockAlias() ;
                if ( $alias != $childName ) {
                    $children[] = $alias ;
                }
                $grandChildren = $this->_getChildrenNames($childBlock, $layout) ;
                if ( count($grandChildren) > 0 ) {
                    $children = array_merge($children, $grandChildren) ;
                }
            }
        }
        return $children ;
    }

	protected function _refreshEsiBlockCache()
	{
		if ($this->_esiLayoutCache['adjusted'] && $this->_config->useInternalCache()) {
			$tags = array(Mage_Core_Model_Layout_Update::LAYOUT_GENERAL_CACHE_TAG);
            $this->_config->saveInternalCache(serialize($this->_esiLayoutCache['blocks']), $this->_esiLayoutCache['cacheId'], $tags) ;
			$this->_esiLayoutCache['adjusted'] = false;
        }
	}

	protected function _integrateFishpigWP()
	{
		$h = Mage::helper('wordpress/app');
		if ($h) {
			$blogId = $h->getBlogId();
			if ($blogId > 0) {
				$this->_cacheVars['ttl'] = $this->_config->getConf(Litespeed_Litemage_Helper_Data::CFG_FPWP_TTL);
				$prefix = $this->_config->getConf(Litespeed_Litemage_Helper_Data::CFG_FPWP_PREFIX);
				$this->_cacheVars['wptag'] = $prefix . 'B' . $blogId . '_';
				if (empty($this->_cacheVars['tag'])) {
					if ( ($curProduct = Mage::registry('product')) != null ) {
						$this->_cacheVars['tag'][] = self::TAG_PREFIX_PRODUCT . $curProduct->getId() ;
					}
					elseif ( ($curCategory = Mage::registry('category')) != null ) {
						$this->_cacheVars['tag'][] = self::TAG_PREFIX_CATEGORY . $curCategory->getId() ;
					}
				}
				$this->_cacheVars['tag'][] = $this->_cacheVars['wptag'];
				return true;
			}
			else {
				$msg = 'cannot find blog Id';
			}
		}
		else {
			$msg = 'cannot find Fishpig helper';
		}
		if ($this->_isDebug) {
            $this->_config->debugMesg('Fishpig WP - ' . $msg);
        }
		
	}
	
    public function beforeResponseSend( $response )
    {
		$this->_refreshEsiBlockCache();

        $extraHeaders = array();
		$envChanged = $this->setEnvCookie(); // envChanged, need to set even when not cacheable (like currency change), need to above other things.

        $cacheControlHeader = '' ;
        $flag = $this->_cacheVars['flag'] ;
        $cacheable = true;
		$responseCode = $response->getHttpResponseCode();
		$this->_cacheVars['internal']['response_code'] = $responseCode;

        if ( (($flag & self::CHBM_CACHEABLE) == 0)
				|| $envChanged
                || Mage::registry('LITEMAGE_SHOWHOLES')
                || Mage::registry('LITEMAGE_PURGE')
                || !in_array($responseCode, array( 200, 301, 404 ))
			) {
            $cacheable = false;
        }

		$isPublic = (($flag & self::CHBM_PRIVATE) == 0);
		if ($cacheable && $isPublic
				&& (strpos($this->_cacheVars['internal']['route_info'], 'wordpress_') !== false)
				&& $this->_config->getConf(Litespeed_Litemage_Helper_Data::CFG_FPWP_ENABLED)) {
			$cacheable = $this->_integrateFishpigWP();
		}
		
        if ( $cacheable ) {
            if ( $isPublic ) {
                $cacheControlHeader = 'public,max-age=' . (($this->_cacheVars['ttl'] > 0) ? $this->_cacheVars['ttl'] : $this->_config->getConf(Litespeed_Litemage_Helper_Data::CFG_PUBLICTTL)) ;
			}
            else {
                $cacheControlHeader = 'private,max-age=' . (($this->_cacheVars['ttl'] > 0) ? $this->_cacheVars['ttl'] : $this->_config->getConf(Litespeed_Litemage_Helper_Data::CFG_PRIVATETTL)) ;
			}

            $notEsiReq = (($flag & self::CHBM_ESI_REQ) == 0);
            if ($notEsiReq) {
                // for cacheable, non-esi page
                if ($vary_on = $this->_getCacheVaryOn()) {
                    $extraHeaders[self::LSHEADER_CACHE_VARY] = $vary_on;
                }
            }
            else {
                $cacheControlHeader .= ',no-vary';
                if ( ($this->_cacheVars['flag'] & self::CHBM_ONLY_CACHE_EMPTY) != 0)
                    $cacheControlHeader .= ',set-blank';
            }

            if ( ($cacheTagHeader = $this->_getCacheTagHeader($notEsiReq, $isPublic)) ) {
                $extraHeaders[self::LSHEADER_CACHE_TAG] = $cacheTagHeader;
            }
        }

        if ((($flag & self::CHBM_ESI_REQ) == 0)    // for non-esi request
                && ((($flag & self::CHBM_ESI_ON) != 0)  // esi on
                        || (($flag & self::CHBM_FORMKEY_REPLACED) != 0) // formkey replaced
                        || ($this->_viewedTracker != null))) { // has view tracker
            $this->_updateResponseBody($response) ; // flag may change
			$flag = $this->_cacheVars['flag']; 
        }

        if ( ($flag & self::CHBM_ESI_ON) != 0 ) {
            if ($cacheControlHeader != '')
                $cacheControlHeader .= ',';
            $cacheControlHeader .= 'esi=on' ;
        }

        if ($cacheControlHeader != '') { // if only no-cache, no need to set header
            $extraHeaders[self::LSHEADER_CACHE_CONTROL] = $cacheControlHeader;
        }

        // due to ajax, move purge header when event happens, so already purged, here's for LITEMAGE_CTRL=PURGE
        if (Mage::registry('LITEMAGE_PURGE')) {
            $extraHeaders[self::LSHEADER_PURGE] = $this->_getPurgeCacheTags();
        }

        $this->_restoreFormKey() ;

        foreach($extraHeaders as $key => $val) {
            $response->setHeader($key, $val);
            if ($this->_isDebug) {
                $this->_config->debugMesg("Header $key: $val");
            }
        }

        return $extraHeaders;
    }

    protected function _updateResponseBody( $response )
    {
        // only for non-esi request and injected
        $responseBody = $response->getBody() ;
        $updated = false ;
        $combined = '' ;
        $tracker = '' ;
        $sharedParams = $this->getEsiSharedParams();
        $esiIncludeTag = $this->_config->esiTag('include');
        if ( (($this->_cacheVars['flag'] & self::CHBM_FORMKEY_REPLACED) != 0) && strpos($responseBody, self::FORMKEY_REPLACE) ) {
			// use single quote for pagespeed module
            $replace = '<' . $esiIncludeTag . " src='" . $this->getEsiBaseUrl() . "litemage/esi/getFormKey' as-var='1' combine='sub' cache-control='no-vary,private' cache-tag='E.formkey'/>" ;
            $responseBody = str_replace(self::FORMKEY_REPLACE, $replace, $responseBody) ;
			if ($this->_isDebug) {
				$this->_config->debugMesg('FormKey replaced as ' . $replace);
			}
            $updated = true ;
        }

		if ( isset($this->_cacheVars['internal']['nickname']) && strpos($responseBody, self::NICKNAME_REPLACE)) {
			// use single quote for pagespeed module
            $replace = '<' . $esiIncludeTag . " src='" . $this->getEsiBaseUrl() . "litemage/esi/getNickName' combine='sub' cache-control='no-vary,private' cache-tag='E.welcome'/>" ;
            $responseBody = str_replace(self::NICKNAME_REPLACE, $replace, $responseBody) ;
			if ($this->_isDebug) {
				$this->_config->debugMesg('Nickname replaced as ' . $replace);
			}
            $updated = true ;
		}

        if ( $this->_viewedTracker != null ) {
            $logOptions = $this->_viewedTracker;
            $logOptions['s'] = $sharedParams['s'];
            // no need to use comment, will be removed by minify extensions
            // if response coming from backend, no need to send separate log request
            $tracker = '<' . $esiIncludeTag . ' src="' . $this->_getSubReqUrl('litemage/esi/log', $logOptions)
                    . '" test="$(RESP_HEADER{X-LITESPEED-CACHE})!=\'hit,litemage\'" cache-control="no-cache" combine="sub"/>' ;
			if ($this->_isDebug) {
				$this->_config->debugMesg('Track recently viewed  as ' . $tracker);
			}
            $updated = true ;
        }

        if ( $updated ) {
            $this->_setEsiOn() ;
		}

        if ( ($this->_cacheVars['flag'] & self::CHBM_ESI_ON) != 0 ) {
            // no need to use comment, will be removed by minify extensions
            $combined = '<' . $esiIncludeTag . ' src="' . $this->_getSubReqUrl('litemage/esi/getCombined', $sharedParams) . '" combine="main2" cache-control="no-cache"/>' ;
			if ($this->_isDebug) {
				$this->_config->debugMesg('_updateResponseBody combined is ' . $combined);
			}
            $updated = true;
        }

        if ( $updated ) {
			// cannot insert at beginning of body, pagespeed module will complain
			$pos = stripos($responseBody, '<body');
			if ($pos) {
				$pos = strpos($responseBody, '>', $pos);
				$newbody = substr($responseBody, 0, $pos+1) . $combined . $tracker . substr($responseBody, $pos+1);
				$response->setBody($newbody);
			}
			else {
				$isAjax = $this->_cacheVars['internal']['is_ajax'];
				// json output will add slashes
				if ($isAjax) {
					$responseBody = preg_replace_callback('|src=\'.*\\\/litemage\\\/esi\\\/[^>]+\\\/>|U',
						function ($matches) {
							$b = stripslashes($matches[0]);
							$c = preg_replace('/\/esi\/([^\/]+)\//', '/esi/$1/ajax/strip/', $b);
							return $c;
						}, 
						$responseBody);
				}
	            $response->setBody($combined . $tracker . $responseBody) ;
				if ($this->_isDebug && !$isAjax) {
					$this->_config->debugMesg('_updateResponseBody failed to insert combined after <body>');
				}
			}
        }

    }

    protected function _getCacheTagHeader($notEsiReq, $isPublic)
    {
        $tags = $this->_cacheVars['tag'] ;
		$curStore = Mage::app()->getStore() ;
		$curStoreId = $curStore->getId();
        if ($notEsiReq) {
            if ( count($tags) == 0 ) {
                // set tag for product id, cid, and pageid
                if ( ($curProduct = Mage::registry('current_product')) != null ) {
                    $tags[] = self::TAG_PREFIX_PRODUCT . $curProduct->getId() ;
                }
                elseif ( ($curCategory = Mage::registry('current_category')) != null ) {
                    $tags[] = self::TAG_PREFIX_CATEGORY . $curCategory->getId() ;
                }
            }

            if ($curStore->getCurrentCurrencyCode() != $curStore->getBaseCurrencyCode()) {
                $tags[] = 'CURR'; // will be purged by currency rate update event
            }

			$debugMesg = $this->_autoCollectUrls($curStoreId, $tags);
			if ($this->_isDebug && $debugMesg) {
				$this->_config->debugMesg('_autoCollectUrls: ' . $debugMesg);
			}
        }
		if ($isPublic) {
			$tags[] = 'S.' . $curStoreId;
		}

        $tag = count($tags) ? implode(',', $tags) : '' ;
        return $tag ;
    }

	public function setInternal($data)
	{
		foreach ($data as $key => $value) {
			$this->_cacheVars['internal'][$key] = $value;
		}
		// avail key route_info, cron(1), response_code, url, nickname
	}

	protected function _autoCollectUrls($storeId, $tags)
	{
		$dbgMsg = '';
		if (!$this->_config->useInternalCache())
			return $dbgMsg;

		$conf = $this->_config->getAutoCollectConf($storeId);
		// array('collect' => 0, 'crawlDelta' => 0, 'crawlAuto' => 0, 'frame' => 0, 'remove' => 0, 'deep' => 0, 'deltaDeep' => 0, 'countRobot'=>1) ;

		if ($conf['collect'] == 0 && $conf['crawlDelta'] == 0)
			return $dbgMsg;

		$url = $this->_cacheVars['internal']['url'];
		$level = 0;
		if (!empty($_SERVER['QUERY_STRING'])) {
			$level = substr_count($_SERVER['QUERY_STRING'], '&') + 1;
		}

		$dbgMsg = $url;
		$cronLabel = '';

		if (isset($this->_cacheVars['internal']['cron'])) {
			$cronLabel = $this->_cacheVars['internal']['cron'];//substr($this->_cacheVars['internal']['cron'], 0, 1); // s|c|a|d
		}

		if ( $this->_cacheVars['internal']['response_code'] != 200 ) {
			if ($cronLabel)
				$dbgMsg .= $this->_removeBadUrl($cronLabel, $url, $storeId, $level, $conf['crawlAuto']);
			return $dbgMsg;
		}

		if ( $level > max($conf['deep'], $conf['deltaDeep'])) {
			$dbgMsg .= ' depth ' . $level . ' over limit ';
			return $dbgMsg;
		}

		$isRobot = $this->isRobot();
		// only collect those are referred (allow internal & external) if has query string to avoid manually typed
		if ($level && !$cronLabel && !$isRobot && !isset($_SERVER['HTTP_REFERER'])) {
			$dbgMsg .= ' is not robot, has query string, no referer, ignored';
			return $dbgMsg;
		}

		$tag = '';
		foreach($tags as $t) {
			if ((strpos($t, self::TAG_PREFIX_PRODUCT) !== false)
					|| (strpos($t, self::TAG_PREFIX_CATEGORY) !== false)
					|| (strpos($t, self::TAG_PREFIX_CMS) !== false)) {
				$tag = $t;
				break;
			}
		}

		if (!$tag) {
			if (isset($this->_cacheVars['wptag']))
				$tag = $this->_cacheVars['wptag'];
			else
				$tag = $this->_cacheVars['internal']['route_info'];
		}

		$attr = 0; // BitMask 1: user, 2: robot, 4: cron_store, 8: cron_cust, 16: cron_auto, 32: is_ajax,
		if ($isRobot) {
			$attr |= 2;
		}
		elseif ($cronLabel ) {
			switch ($cronLabel{0}) {
				case 's': $attr |= 4; break;
				case 'c': $attr |= 8; break;
				case 'a': $attr |= 16; break;
			}
		}
		else {
			$attr |= 1;
		}
		if ($this->_cacheVars['internal']['is_ajax']) {
			$attr |= 32;
		}

		// 2. load tags cache
		$cacheId = 'LITEMAGE_AUTOURL_' . $tag;
		$updated = false;
		$now = time() - date('Z') ;

		$tagUrls = null;
		if ( $result = Mage::app()->loadCache($cacheId) ) {
			$tagUrls = unserialize($result) ;
		}

		if (!$tagUrls) { // no cache or cache bad
			$tagUrls = array();
			$updated = true;
		}

		if (!isset($tagUrls[$storeId])) {
			$tagUrls[$storeId] = array('utctime' => array($now, $now)); // utctime 0:inittime; 1:updatetime
			$updated = true;
		}
		else {
			// maintain level
			foreach (array_keys($tagUrls[$storeId]) as $k ) {
				if (is_int($k) && $k > $conf['deep'] && $k > $conf['deltaDeep']) {
					$dbgMsg .= ' found old saved level=' . $k . ' higher than defined, clean up ';
					unset($tagUrls[$storeId][$k]);
					$updated = true;
				}
			}
		}
		$tagInitTime = $tagUrls[$storeId]['utctime'][0];

		if (!isset($tagUrls[$storeId][$level])) {
			$tagUrls[$storeId][$level] = array();
			$updated = true;
		}

		if (!isset($tagUrls[$storeId][$level][$url])) {
			$tagUrls[$storeId][$level][$url] = array(0, $attr); // 0:visitor count, 1: attr
			$updated = true;
		}

		$tagUrl = &$tagUrls[$storeId][$level][$url];
		$dbgMsg .= ' attr=' . $attr . ' level=' . $level;

		if ($conf['collect']) {
			if ((($attr & 1) == 1) || ($conf['countRobot'] && (($attr & 2) == 2))) {
				$tagUrl[0] ++;
				$updated = true;
			}
			if (($attr & $tagUrl[1]) != $attr ) {
				$tagUrl[1] |= $attr;
				$updated = true;
			}

			if (($now - $tagInitTime) > $conf['frame']) {
				// window is over
				$dbgMsg .= $this->_adjustAutoWarmupList($storeId, $tag, $tagInitTime);
			}
			elseif (($tagUrl[0] >= $conf['collect']) && (($tagUrl[1] & 28) == 0)) {
				// not over the time limit, not seeing from cron, possible candidate to add, whether already in autolist will be determinted by cron
				$isAjax = (($tagUrl[1] & 32) > 0);
				$dbgMsg .= $this->_adjustAutoWarmupList($storeId, $tag, $tagInitTime, $url, ($isAjax? 2:1));
			}

			// put add/removal in cron, here only update attr
		}

		if ($updated) {
			$tagUrls[$storeId]['utctime'][1] = $now;
			$this->_config->saveInternalCache(serialize($tagUrls), $cacheId) ;
			$dbgMsg .= ' tag cache updated ';
		}

		return $dbgMsg;
	}

	protected function _removeBadUrl($cronLabel, $url, $storeId, $level, $crawlAuto)
	{
		$dbgMesg = ' in _removeBadUrl ';
		$type = $cronLabel{0};
		if ($type != 'a' && $type != 'd') {
			$dbgMesg .= ' not from auto or delta, ignore. ';
			return $dbgMesg;
		}
		$pos = strpos($cronLabel, ':');
		if (!$pos) {
			$dbgMesg .= ' no cron tag: found, ignore. ';
			return $dbgMesg;
		}
		// tag needs to retrieve from cronlabel, not from current req
		$tag = substr($cronLabel, $pos + 1);
		if (!$tag) {
			$dbgMesg .= ' no cron tag found, ignore. ';
			return $dbgMesg;
		}

		$cacheId = 'LITEMAGE_AUTOURL_' . $tag;
		$attr = 0;
		if ( $result = Mage::app()->loadCache($cacheId) ) {
			$tagUrls = unserialize($result) ;
			if (isset($tagUrls[$storeId][$level][$url])) {
				$attr = $tagUrls[$storeId][$level][$url][1];
				unset($tagUrls[$storeId][$level][$url]);
				$this->_config->saveInternalCache(serialize($tagUrls), $cacheId) ;
				$dbgMesg .= ' removed from tag cache ' . $tag ;
			}
		}
		if ($crawlAuto && ($type == 'a' || ($type == 'd' && ($attr & 16)))) { // in autolist, remove
			$dbgMesg .= $this->_adjustAutoWarmupList($storeId, $tag, $url, -1);
		}
		return $dbgMesg;
	}

	// action: -1 (remove) 1 (add regular) 2 (add ajax)
	protected function _adjustAutoWarmupList($storeId, $tag, $tagInitTime, $url='', $action='')
	{
		$cacheId = 'LITEMAGE_AUTOURL_ADJ_S' . $storeId;
		$pending = null;
		$now = time() - date('Z');
		$dbgMesg = ' _adjustAutoWarmupList for ' . $tag;
		if ( $result = Mage::app()->loadCache($cacheId) ) {
			$pending = unserialize($result) ;
		}
		if (!$pending) {
			// [utctime] = [inittime, updatetime]
			// [tag][0] = 0|1 -- full check
			//      [1][url] = 1/-1  -- url check  AddReg(1) AddAjax(2) Remove(-1)
			$pending = array('utctime' => array($now, $now));
			$dbgMesg .= ' no existing list, start new. ';
		}

		if (!isset($pending[$tag])) {
			$pending[$tag] = array(0 => 0, 't' => $tagInitTime);
		}
		elseif ($pending[$tag][0]) {
			// already full check
			$dbgMesg .= ' already in pending full check, ignore. ';
			return $dbgMesg;
		}

		if ($url == '') {
			$pending[$tag][0] = 1;
			$dbgMesg .= ' window is over, doing full check. ';

			if (isset($pending[$tag][1])) {
				unset($pending[$tag][1]);
				$dbgMesg .= ' reset previous single url check. ';
			}
		}
		else {
			if (!isset($pending[$tag][1])) {
				$pending[$tag][1] = array($url => $action);
			}
			elseif (isset($pending[$tag][1][$url]) && $pending[$tag][1][$url] == $action) {
				$dbgMesg .= ' already in pending url check, ignore. ';
				return $dbgMesg;
			}
			else {
				$pending[$tag][1][$url] = $action;
			}
			$dbgMesg .= ' add single url check ' . $action;
		}
		$pending['utctime'][1] = $now; // updated time
		$this->_config->saveInternalCache(serialize($pending), $cacheId) ;
		return $dbgMesg;
	}

	protected function _addDeltaByTags($tags)
	{
		if (!$this->_config->useInternalCache() || !$this->_config->needAddDeltaTags())
			return;

		$cacheId = Litespeed_Litemage_Helper_Data::LITEMAGE_DELTA_CACHE_ID ;

		$updated = 1; // 0: no update; 1: reinit; 2: append

		if (in_array('*', $tags)) {
			$tags = array();
		}
		elseif ($result = Mage::app()->loadCache($cacheId)) {
			$data = unserialize($result) ;
			if (is_array($data) && isset($data['time']) && isset($data['tags'])) {
				$updated = 0;
				$extra = array();
				foreach ($tags as $tag) {
				   if (!in_array($tag, $data['tags'])) {
					   $data['tags'][] = $tag;
					   $extra[] = $tag;
					   $updated = 2;
				   }
			   }
			}
		}

		if ($updated) {
			if ($updated == 1) {
				$data = array('time' => microtime(), 'tags' => $tags);
			}
			$this->_config->saveInternalCache(serialize($data), $cacheId) ;
		}

		if ($this->_isDebug) {
			if ($updated == 0)
				$msg = 'Delta tags not added, already in pending list';
			elseif ($updated == 1)
				$msg = 'Reinit Delta queue [time=' . $data['time'] . '] tags=' . implode(',', $tags);
			else
				$msg = 'Delta queue [time=' . $data['time'] . '] appended tag ' . implode(',', $extra);

			$this->_config->debugMesg($msg) ;
		}
	}

    protected function _getPurgeCacheTags()
    {
		// only for LITEMAGE_CTRL=PURGE
        $tags = $this->_cacheVars['tag'] ;
		
        if (empty($tags)) {
            // set tag for product id, cid, and pageid
            if ( ($curProduct = Mage::registry('current_product')) != null ) {
                $tags[] = self::TAG_PREFIX_PRODUCT . $curProduct->getId() ;
            }
            elseif ( ($curCategory = Mage::registry('current_category')) != null ) {
                $tags[] = self::TAG_PREFIX_CATEGORY . $curCategory->getId() ;
            }
		}
		if (empty($tags)) {
			// go by url
			$uri = str_replace('LITEMAGE_CTRL=PURGE', '', $_SERVER['REQUEST_URI']);
			if (substr($uri, -1) == '?') {
				$uri = rtrim($uri, '?');
			}
			return $uri;
		}
		$this->_addDeltaByTags($tags);

        $tag = count($tags) ? implode(',', $tags) : '' ;
        return $tag ;
    }

    public function setEnvCookie()
    {
        $changed = false;
        $this->getDefaultEnvCookie();
        foreach ($this->_cacheVars['env'] as $name => $data) {
            $newVal = '';
            $oldVal = '';
            if ($data != null) {
                ksort($data); // data is array, key sorted
                foreach ($data as $k => $v) {
                    $newVal .= $k . '~' . $v . '~';
                }
            }
            if ($cookievar = $this->getCookieEnvVars($name)) {
                $oldVal = $cookievar['_ORG_'];
            }

            if ($oldVal != $newVal) {
                Mage::getSingleton('core/cookie')->set($name, $newVal);
                $changed = true;
                if ($this->_isDebug)
                    $this->_config->debugMesg('Env ' . $name . ' changed, old=' . $oldVal . '  new=' . $newVal) ;
            }
        }
        return $changed;
    }

    protected function _getCacheVaryOn()
    {
        $vary_on = array();

        foreach ($this->_cacheVars['env'] as $name => $data) {
            if ($name != $this->_defaultEnvVaryCookie) {
                $vary_on[] = 'cookie=' . $name;
            }
        }

        switch (count($vary_on)) {
            case 0: return '';
            case 1: return $vary_on[0];
            default: return implode(',', $vary_on);
        }
    }

    public function setDefaultEnvCookie()
    {
        // when calling set, always reset, as value may change during processing
        $default = $this->_getDefaultEnvCookieValue();
        $this->_cacheVars['env'][$this->_defaultEnvVaryCookie] = count($default) > 0 ? $default : null ;
    }

    protected function _getDefaultEnvCookieValue()
    {
        $default = array() ;
        $currStore = Mage::app()->getStore();

		// check null to avoid error from soap api call
		if (!$currStore) {
			return $default;
		}

		$website = $currStore->getWebsite();
		if (!$website) {
			return $default;
		}

		$defaultStore = $website->getDefaultStore();
		if (!$defaultStore) {
			return $default;
		}

		$currStoreId = $currStore->getId() ;
		$currStoreCurrency = $currStore->getCurrentCurrencyCode() ;
		$currStoreDefaultCurrency = $currStore->getDefaultCurrencyCode() ;

		if ($currStoreCurrency != $currStoreDefaultCurrency) {
			$default['curr'] = $currStoreCurrency ;
		}


		if ( $defaultStore->getId() != $currStoreId ) {
			$default['st'] = intval($currStoreId) ;
		}
		if ($diffGrp = $this->_config->getConf(Litespeed_Litemage_Helper_Data::CFG_DIFFCUSTGRP)) {
			// diff cache copy per customer group
			$currCustomerGroup = Mage::getSingleton('customer/session')->getCustomerGroupId() ;
			if ( Mage_Customer_Model_Group::NOT_LOGGED_IN_ID != $currCustomerGroup ) {
				if ($diffGrp == 1) // diff copy per group
					$default['cgrp'] = $currCustomerGroup ;
				elseif ($diffGrp == 2)    // diff copy for logged in user
					$default['cgrp'] = 'in' ;
				elseif ($diffGrp == 3) {
					$cgset = $this->_config->getConf(Litespeed_Litemage_Helper_Data::CFG_DIFFCUSTGRP_SET);
					if (isset($cgset[$currCustomerGroup]))
						$default['cgrp'] = $cgset[$currCustomerGroup];
				}
			}
		}
		if ($this->_config->isRestrainedIP()) {
			$default['dev'] = 1;  //developer mode for restrained IP
		}
		return $default;
    }

    public function getDefaultEnvCookie()
    {
        if ( ! isset($this->_cacheVars['env'][$this->_defaultEnvVaryCookie]) ) {
            $this->setDefaultEnvCookie();
        }
        return $this->_cacheVars['env'][$this->_defaultEnvVaryCookie];
    }

    public function getEsiSharedParams()
    {
        if (!isset($this->_cacheVars['esiUrlSharedParams'])) {
            $design = Mage::getDesign() ;
			$theme_template = $design->getTheme('template') ;
			$theme_skin = $design->getTheme('skin') ;
			$theme_layout = $design->getTheme('layout') ;
			$dt = $theme_template;
			if ($theme_skin != $theme_template || $theme_layout != $theme_template) {
				$dt .= ',' . $theme_skin . ',' . $theme_layout;
			}
			
            $currStore = Mage::app()->getStore() ;
            $urlParams = array(
                's' => $currStore->getId(),  // current store id
                'dp' => $design->getPackageName(),
                'dt' => $dt ) ;

            $currency = $currStore->getCurrentCurrencyCode();
            if ($currency != $currStore->getDefaultCurrencyCode()) {
                $urlParams['cur'] = $currency;
            }

            if ($diffGrp = $this->_config->getConf(Litespeed_Litemage_Helper_Data::CFG_DIFFCUSTGRP)) {
                // diff cache copy peer customer group
                $currCustomerGroup = Mage::getSingleton('customer/session')->getCustomerGroupId() ;
                if ( Mage_Customer_Model_Group::NOT_LOGGED_IN_ID != $currCustomerGroup ) {
                    if ($diffGrp == 1) // diff copy per group
                        $urlParams['cg'] = $currCustomerGroup ;
                    elseif ($diffGrp == 2)    // diff copy for logged in user
                        $urlParams['cg'] = 'in' ;
					elseif ($diffGrp == 3) {
						$cgset = $this->_config->getConf(Litespeed_Litemage_Helper_Data::CFG_DIFFCUSTGRP_SET);
						if (isset($cgset[$currCustomerGroup]))
							$urlParams['cg'] = $cgset[$currCustomerGroup];						
						}
                }
            }
            // for public block, should consider vary on
            $this->_cacheVars['esiUrlSharedParams'] = $urlParams;

        }
        return $this->_cacheVars['esiUrlSharedParams'];
    }

    public function getCookieEnvVars( $cookieName )
    {
        if ( ! isset($this->_cacheVars['cookie'][$cookieName]) ) {
            $this->_cacheVars['cookie'][$cookieName] = null ;
            $cookieVal = Mage::getSingleton('core/cookie')->get($cookieName) ;
            if ( $cookieVal != null ) {
                $cv = explode('~', trim($cookieVal, '~')); // restore cookie value
				$num = count($cv);
				if (($num % 2) == 0) {
					for ($i = 0 ; $i < $num ; $i += 2) {
						$this->_cacheVars['cookie'][$cookieName][$cv[$i]] = $cv[$i+1];
					}
				}
				else if ($this->_isDebug) {
                    $this->_config->debugMesg('Env Cookie value parse error ' . $cookieName . ' = ' . $cookieVal) ;
				}

                $this->_cacheVars['cookie'][$cookieName]['_ORG_'] = $cookieVal ;
            }
        }
        return $this->_cacheVars['cookie'][$cookieName] ;
    }

    public function addEnvVars($cookieName, $key='', $val='' )
    {
        if ( ! isset($this->_cacheVars['env'][$cookieName]) || ($this->_cacheVars['env'][$cookieName] == null) ) {
            $this->_cacheVars['env'][$cookieName] = array() ;
        }
        if ($key != '') {
            $this->_cacheVars['env'][$cookieName][$key] = $val ;
        }
    }

	public function isRobot($userAgent = '')
	{
		// for auto collect, ignore robot visits, so don't have to be very accurate, cover common case is fine
		if ($userAgent == '') {
			$userAgent = Mage::helper('core/http')->getHttpUserAgent();
		}
		$ua = strtolower($userAgent);
		$isRobot = preg_match('/bot|slurp|spider|crawl|archiver/', $ua);
		return $isRobot;
	}

}
