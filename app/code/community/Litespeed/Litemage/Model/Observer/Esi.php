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


class Litespeed_Litemage_Model_Observer_Esi extends Varien_Event_Observer
{

    /**
     * Add the core/messages block rewrite if the flash message fix is enabled
     *
     * The core/messages block is rewritten because it doesn't use a template
     * we can replace with an ESI include tag, just dumps out a block of
     * hard-coded HTML and also frequently skips the toHtml method
     *
     * @param Varien_Object $eventObj
     * @return NULL
     */
    protected $_esi ;
    protected $_isDebug ;
    protected $_moduleEnabledForUser ;
    protected $_canInjectEsi = -1;
    protected $_helper ;
    protected $_config ;
    protected $_viewVary = array();
    protected $_routeCache;
    protected $_injectedBlocks = array();
	protected $_startDynamic = false;
	protected $_internal = array();

    protected function _construct()
    {
        $this->_helper = Mage::helper('litemage/esi') ;
        $this->_config = Mage::helper('litemage/data') ;
        $this->_isDebug = $this->_config->isDebug() ;
        $this->_moduleEnabledForUser = $this->_config->moduleEnabledForUser();
    }

    public function purgeEsiCache( $eventObj )
    {
        if ( $this->_moduleEnabledForUser ) {
            $this->_helper->addPrivatePurgeEvent($eventObj->getEvent()->getName()) ;
        }
    }

    //customer_login, customer_logout, purge all private cache for that user
    public function purgeUserPrivateCache( $eventObj )
    {
        if ( $this->_moduleEnabledForUser ) {
            // do not purge all private, session is new anyway
            $this->_viewVary[] = 'env';
			$this->_viewVary[] = 'review';
			$this->_internal['purgeUserPrivateCache'] = 1;
			$this->_helper->addPrivatePurgeEvent($eventObj->getEvent()->getName(), array('*')) ;
        }
    }

	protected function _catchMissedChecks()
	{
		if (isset($this->_internal['route_info']) && ($this->_internal['route_info'] == 'customer_account_loginPost')) {
			if (!isset($this->_internal['purgeUserPrivateCache']) && Mage::getSingleton('customer/session')->isLoggedIn()) {
				$this->_viewVary[] = 'env';
				$this->_viewVary[] = 'review';
				$this->_internal['purgeUserPrivateCache'] = 1;
			}
		}
	}

    //customer_login
    //other are captured when pre-dispatch by action name
    public function changeEnvCookie( $eventObj )
    {
        if ( $this->_moduleEnabledForUser ) {
            $this->_viewVary[] = 'env';
        }
    }

//controller_action_predispatch
    public function predispatchCheckControllerNoCache( $eventObj )
    {
        // no need to check admin, this is frontend event only
        if ( ! $this->_moduleEnabledForUser ) {
            $this->_canInjectEsi = 0;
            return ;
        }
        $req = Mage::app()->getRequest() ;
        $controller = $eventObj->getControllerAction();
        $curActionName = $controller->getFullActionName() ;
        $reqUrl = $req->getRequestString() ;
		$session = Mage::getSingleton('core/session');
		$this->_reservForwardInfo($req);
		
		if (!isset($_COOKIE['frontend']) && isset($_COOKIE['litemage_key'])) {
			//restore formkey
			$session->setData('_form_key', $_COOKIE['litemage_key']); // new visitor
			setcookie('litemage_key', '', time()-1000);
		}
		
		$lmuser = $session->getData('_litemage_user');
		if ($lmuser == null) {
			$session->setData('_litemage_user', 1); // new visitor
		}
		else if ($lmuser == 1) {
			$session->setData('_litemage_user', 2); // existing visitor
		}

		$this->_helper->setInternal(array('route_info' => $curActionName,
			'is_ajax' => $req->isXmlHttpRequest())); // here do not use isAjax()
		$this->_internal['route_info'] = $curActionName;

        $reason = '';

		if ($this->_helper->notCacheable()) {
			// from previous redirect
			if ( $this->_isDebug ) {
				$this->_config->debugMesg('no cache from previous redirect route_action ' . $controller->getFullActionName()) ;
			}
			return;
		}

        if (($lmdebug = $req->getParam('LITEMAGE_DEBUG')) !== null) {
            // either isDebug or IP match
            if ($this->_isDebug || $this->_config->isRestrainedIP() || $this->_config->isAdminIP()) {
                if ($lmdebug == 'SHOWHOLES') {
					// for redirect, maybe already set, need to check, otherwise exception
					if ( ! Mage::registry('LITEMAGE_SHOWHOLES') ) {
						Mage::register('LITEMAGE_SHOWHOLES', 1) ;
					}
					// set to nocache later at beforeResponseSend
                }
                elseif ($lmdebug == 'NOCACHE') {
                    $reason = 'contains var LITEMAGE_DEBUG=NOCACHE';
                }
            }
            else {
                $controller->norouteAction();
                return;
            }
        }

        if ($reason == '') {
            $reason = $this->_cannotCache($req, $curActionName, $reqUrl);
        }

        if ($reason != '') {
            $this->_canInjectEsi = 0;
            $reason = ' NO_CACHE=' . $reason;
			$this->_helper->setCacheControlFlag(Litespeed_Litemage_Helper_Esi::CHBM_NOT_CACHEABLE) ;

            // special checks
            $envChanged = array('customer_account_logoutSuccess', 'directory_currency_switch');
            if (in_array($curActionName, $envChanged)) {
                $this->_viewVary[] = 'env';
            }
        }
        else {

            // hardcode for now
            if ( strncmp('catalog_category_', $curActionName, strlen('catalog_category_')) == 0 ) {
                $this->_viewVary[] = 'toolbar' ;
                Mage::Helper('litemage/viewvary')->restoreViewVary($this->_viewVary) ;
            }
            elseif ($this->_config->isWholeRouteCache($curActionName)) {
                $this->_setWholeRouteCache($curActionName, $controller);
            }

            if (($lmctrl = $req->getParam('LITEMAGE_CTRL')) !== null) {
                // either isDebug or IP match
                if ($this->_config->isAdminIP()) {
                    if ($lmctrl == 'PURGE') {
						// for redirect, maybe already set, need to check, otherwise exception
						if (!Mage::registry('LITEMAGE_PURGE')) {
							Mage::register('LITEMAGE_PURGE', 1);
						}
                        // set to nocache later at beforeResponseSend
                    }
                }
                else {
                    $controller->norouteAction();
                    return;
                }
            }

			$ttl = -1;
			if ($curActionName == 'cms_index_index') {
				$ttl = $this->_config->getConf(Litespeed_Litemage_Helper_Data::CFG_HOMETTL);
				if ($ttl == '')
					$ttl = -1;
			}
            $this->_helper->setCacheControlFlag(Litespeed_Litemage_Helper_Esi::CHBM_CACHEABLE, $ttl) ;

			$fullUrl = ltrim($reqUrl, '/');
			if (!empty($_SERVER['QUERY_STRING'])) {
				$fullUrl .= '?' . $_SERVER['QUERY_STRING'];
			}

			$internalData = array( 'url' => $fullUrl);

			$cookie = Mage::getSingleton('core/cookie');
			if ( $cron = $cookie->get('litemage_cron') ) {
				$internalData['cron'] = $cron;
                if ( ($currency = $cookie->get('currency')) != '') {
                    Mage::app()->getStore()->setCurrentCurrencyCode($currency);
				}
                if ( ($customerId = $cookie->get('lmcron_customer')) != '') {
					$cs = Mage::getSingleton('customer/session');
					$cs->setId($customerId);
					$cs->setCustomerId($customerId);
				}
            }
			$this->_helper->setInternal($internalData);

        }

        if ( $this->_isDebug ) {
            $this->_config->debugMesg('****** PRECHECK route_action [' . $curActionName . '] ' . $req->getRequestString() . $reason) ;
        }

    }

	protected function _reservForwardInfo($req)
	{
		$info = $req->getBeforeForwardInfo();
		if (!empty($info) && !isset($this->_internal['before_forward'])) {
			$tags = array();
			if ($info['controller_name'] == 'product') {
				if (isset($info['params']['id']) && $info['params']['id'] ) {
					$tags[] = Litespeed_Litemage_Helper_Esi::TAG_PREFIX_PRODUCT . $info['params']['id'];
				}
				if (isset($info['params']['category']) && $info['params']['category'] ) {
					$tags[] = Litespeed_Litemage_Helper_Esi::TAG_PREFIX_CATEGORY . $info['params']['category'];
				}
			}
			elseif ($info['controller_name'] == 'category') {
				if (isset($info['params']['id']) && $info['params']['id'] ) {
					$tags[] = Litespeed_Litemage_Helper_Esi::TAG_PREFIX_CATEGORY . $info['params']['id'];
				}
			}			
			else {
				if ($this->_isDebug)
					$this->_config->debugMesg('Uncaptured Forwarded Info ' . print_r($info,true));
			}
			$this->_internal['before_forward'] = $tags;
		}		
	}
	
	protected function _addForwardTags($resp)
	{
		if (isset($this->_internal['before_forward']) && !empty($this->_internal['before_forward'])) {
			$headers = $resp->getHeaders();
			$xtag = Litespeed_Litemage_Helper_Esi::LSHEADER_CACHE_TAG;
			$value = implode(',', $this->_internal['before_forward']);
			foreach ($headers as $header) {
				if (strcasecmp($header['name'],$xtag) == 0) {
					$value = implode(',', array_unique(array_merge(explode(',', $header['value']), $this->_internal['before_forward'])));
					break;
				}
			}
			if ($this->_isDebug) {
				$this->_config->debugMesg('Updated header ' . $xtag . ': ' . $value);
			}
			$resp->setHeader($xtag, $value, true);
		}
	}
	
	// return reason string. if can be cached, return false;
    protected function _cannotCache( $req, $curActionName, $requrl )
    {
        if ( $req->isPost() ) {
            return 'POST';
        }

        $nocache = $this->_config->getNoCacheConf() ;
        foreach ( $nocache[Litespeed_Litemage_Helper_Data::CFG_NOCACHE_VAR] as $param ) {
            if ( $req->getParam($param) ) {
                return 'contains param ' . $param;
            }
        }

        // check controller level
        $cacheable = false;
		$exactMatch = false;
		if (in_array($curActionName, $nocache[Litespeed_Litemage_Helper_Data::CFG_CACHE_ROUTE])) {
			$cacheable = true;
			$exactMatch = true;
		}
		else {
			foreach ( $nocache[Litespeed_Litemage_Helper_Data::CFG_CACHE_ROUTE] as $route ) {
				if ( strncmp($route, $curActionName, strlen($route)) == 0 ) {
					$cacheable = true;
					break;
				}
			}
		}
        if ( !$cacheable ) {
            return 'route not cacheable';
        }

		if ($exactMatch) {
			// only nocache exact match will override
			if (in_array($curActionName, $nocache[Litespeed_Litemage_Helper_Data::CFG_NOCACHE_ROUTE])) {
				return 'subroute disabled';
			}
		}
		else {
			foreach ( $nocache[Litespeed_Litemage_Helper_Data::CFG_NOCACHE_ROUTE] as $route ) {
				if ( strncmp($route, $curActionName, strlen($route)) == 0 ) {
					return 'subroute disabled';
				}
			}
		}

        foreach ( $nocache[Litespeed_Litemage_Helper_Data::CFG_NOCACHE_URL] as $url ) {
			if (substr($url, -1) == '*') {
				$url = trim($url, '*');
				if ( strpos($requrl, $url) !== false ) {
					return 'disabled url (partial match) ' . $url;
				}
			}
			else if ($url == $requrl) {
				return 'disabled url (exact match) ' . $url;
			}
        }

        return ''; // can be cached
    }


    // event core_layout_block_create_after
    public function checkEsiBlock($eventObj)
    {
        if ( ! $this->_moduleEnabledForUser )
            return;

        if ($this->_canInjectEsi === -1) {
            $this->_canInjectEsi = $this->_helper->canInjectEsi();
        }

        if ( ! $this->_canInjectEsi )
            return ;

        $block = $eventObj->getData('block') ;
		if ( $this->_config->isEsiBlock($block, $this->_startDynamic) ) {
			if ($this->_startDynamic ) {
				$this->_injectEsiBlock($block);
			}
			else {
				$this->_injectedBlocks[] = $block;
			}
        }
		elseif ($block instanceof Mage_Review_Block_Form) {
			$this->_helper->initNickName($block);
			$this->_viewVary[] = 'review';
		}
    }

    //controller_action_layout_generate_blocks_after
    public function prepareInjection( $eventObj )
    {
        if ($this->_canInjectEsi === -1) {
            $this->_canInjectEsi = $this->_helper->canInjectEsi();
        }

        if ( ! $this->_canInjectEsi )
            return ;

        $this->_helper->initFormKey() ;
		
        foreach ( $this->_injectedBlocks as $block ) {
			$esiBlock = $this->_injectEsiBlock($block);
			$block->setData('litemage_lost', $esiBlock);
		}
		
		if (count($this->_injectedBlocks)) {
			$layout = $this->_injectedBlocks[0]->getLayout();
			// only check header for now, this is to capture bad coded themes
			$this->_catchLostChildBlocks('header', $layout->getBlock('header'));
		}

		$this->_startDynamic = true;
    }
	
	protected function _catchLostChildBlocks($alias, $block, $parent=null)
	{
		if ($block == null 
				|| $block instanceof Litespeed_Litemage_Block_Core_Esi 
				|| $block instanceof Litespeed_Litemage_Block_Core_Messages) {
			return;
		}

		if ($esiReplace = $block->getData('litemage_lost')) {
			$msg = 'Found Lost child ' . $alias;
			if ($parent === null) {
				$msg .= ' - EMPTY PARENT - Ignore';
			}
			else {
				$msg .= ' - REPLACED';
				$oldParent = $esiReplace->getParentBlock(); // reserve the old parent
				$parent->setChild($alias, $esiReplace);
				$esiReplace->setParentBlock($oldParent);
			}
		    if ($this->_isDebug) {
                $this->_config->debugMesg('_catchLostChildBlocks ' . $msg) ;
            }
		}
		else {
			$children = $block->getChild(); 
			foreach ($children as $alias => $child) {
				$this->_catchLostChildBlocks($alias, $child, $block);
			}
		}
	}

	protected function _injectEsiBlock($block)
	{
		$bconf = $block->getData('litemage_bconf');
		if (!$bconf) {
			// log something wrong
			return;
		}

		if ( $bconf['tag'] == 'messages' ) {
			$esiBlock = new Litespeed_Litemage_Block_Core_Messages() ;
		}
		else {
			$esiBlock = new Litespeed_Litemage_Block_Core_Esi() ;
		}
		// just init, maynot be used
		$esiBlock->initByPeer($block) ;
	}

	protected function _setWholeRouteCache($actionName, $controller)
    {
        $app = Mage::app();
        $design = Mage::getDesign() ;
		$tags = $this->_helper->getEsiSharedParams();
        $tags[] = $actionName;
        $cacheId = 'LITEMAGE_ROUTE_' . md5(join('__', $tags));

        $this->_routeCache = array('actionName' => $actionName, 'cacheId' => $cacheId);
        if ($result = $app->loadCache($cacheId)) {
            $this->_routeCache['content'] = unserialize($result);
            $controller->setFlag('', Mage_Core_Controller_Varien_Action::FLAG_NO_DISPATCH, 1);
        }
    }

    //event: http_response_send_before
    public function beforeResponseSend( $eventObj )
    {
        if ( !$this->_moduleEnabledForUser )
            return;

        $resp = $eventObj->getResponse();

        if (isset($this->_routeCache['content'])) {
            // serve cached whole page
            $resp->setBody($this->_routeCache['content']['body']);
            foreach($this->_routeCache['content']['header'] as $key => $val) {
                $resp->setHeader($key, $val);
            }
			if (isset($this->_routeCache['content']['respcode'])) {
				$resp->setHttpResponseCode($this->_routeCache['content']['respcode']);
			}
			$this->_addForwardTags($resp);
            if ($this->_isDebug) {
                // last debug mesg
                $this->_config->debugMesg('###### Served whole route from cache') ;
            }
            return;
        }

		$this->_catchMissedChecks();

        if ( count($this->_viewVary) ) {
            // this needs to run before helper's beforeResponseSend
            Mage::Helper('litemage/viewvary')->persistViewVary($this->_viewVary) ;
        }

        $extraHeaders = $this->_helper->beforeResponseSend($resp) ;

        if (isset($this->_routeCache['cacheId']) && $this->_config->useInternalCache()) {
            $content = array();
            $content['body'] = $resp->getBody();
			$cheaders = array();
			$headers = $resp->getHeaders();
			foreach ($headers as $header) {
				$cheaders[$header['name']] = $header['value'];
			}
			foreach($extraHeaders as $key => $val) {
				$cheaders[$key] = $val;
			}
            $content['header'] = $cheaders;
			$curRespCode = $resp->getHttpResponseCode();
			if ($curRespCode != 200) {
				$content['respcode'] = $curRespCode;
			}

            $this->_config->saveInternalCache(serialize($content), $this->_routeCache['cacheId']);
        }

		$this->_addForwardTags($resp);
        if ($this->_isDebug) {
            $this->_config->debugMesg('###### end of process, body length ' . strlen($resp->getBody()));
        }

    }

    //catalog_controller_product_view
    public function onCatalogProductView( $eventObj )
    {
        if ( $this->_moduleEnabledForUser && ! $this->_helper->isEsiRequest() ) {
            $productId = $eventObj->getProduct()->getId() ;
            $this->_helper->addCacheEntryTag(Litespeed_Litemage_Helper_Esi::TAG_PREFIX_PRODUCT . $productId) ;

            if ( $this->_config->trackLastViewed() ) {
                $this->_helper->addPrivatePurgeEvent($eventObj->getEvent()->getName()) ;// for T:Mage_Reports_Block_Product_Viewed
                $this->_helper->trackProduct($productId) ;
            }
        }
    }

    // cms_page_render
    public function onCmsPageRender( $eventObj )
    {
        if ( $this->_moduleEnabledForUser ) {
            $pageId = $eventObj->getPage()->getId() ;
            $this->_helper->addCacheEntryTag(Litespeed_Litemage_Helper_Esi::TAG_PREFIX_CMS . $pageId) ;
        }
    }

    public function initNewVisitor($eventObj)
    {
        if ( $this->_moduleEnabledForUser ) {
            if ($value = Mage::registry('LITEMAGE_NEWVISITOR')) {
				Mage::unregister('LITEMAGE_NEWVISITOR'); // to be safe
            }
            else {
                Mage::register('LITEMAGE_NEWVISITOR', 2);
            }
        }
    }

}
