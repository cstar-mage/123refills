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


class Litespeed_Litemage_AdminController extends Mage_Core_Controller_Front_Action
{

    protected $_helper ;
    protected $_config ;
    protected $_isDebug ;
    protected $_data;

    protected function _construct()
    {
        $this->setFlag('', Mage_Core_Controller_Varien_Action::FLAG_NO_START_SESSION, 1) ; // Do not start standart session
        $this->setFlag('', Mage_Core_Controller_Varien_Action::FLAG_NO_PRE_DISPATCH, true) ;
        $this->setFlag('', Mage_Core_Controller_Varien_Action::FLAG_NO_POST_DISPATCH, true) ;
        $this->_config = Mage::helper('litemage/data') ;
        $this->_isDebug = $this->_config->isDebug() ;
    }

    /**
     * It seems this has to exist so we just make it redirect to the base URL
     * for lack of anything better to do.
     *
     * @return null
     */
    public function indexAction()
    {
        Mage::log('Err: litemage/admin/ come to indexaction') ;
        //$this->getResponse()->setRedirect(Mage::getBaseUrl()) ;
    }

    protected function _errorExit($errorMesg)
    {
        if ( $this->_isDebug ) {
            $this->_config->debugMesg('litemage/admin ErrorExit: ' . $errorMesg) ;
        }
        $resp = $this->getResponse() ;
        $resp->setHttpResponseCode(500) ;
        $resp->setBody($errorMesg) ;
    }


    public function purgeAction()
    {
        if ( $this->_accessAllowed()) {
            if ($error = $this->_validatePurgeTags()) {
                $this->_errorExit($error);
            }
            else {
                $this->_helper->setPurgeHeader($this->_data, 'litemage/admin/purgeAction');
            }
        }
        else {
            $this->_errorExit('Access denied') ;
        }
    }

    public function shellAction()
    {
		if (Mage::helper('core/http')->getHttpUserAgent() !== 'litemage_walker'
				|| ! $this->_config->getConf(Litespeed_Litemage_Helper_Data::CFG_ENABLED)) {
			$this->_errorExit('Access denied');
		}
		
		$tags = array();
		$req = $this->getRequest();
		if ($req->getParam('all')) {
			$tags[] = '*';
		}
		else {
			if ($t = $req->getParam('tags')) {
				$tags = explode(',', $t);
			}
			$types = array('P.' => 'products', 'C.' => 'cats', 'S.' => 'stores');
			foreach ($types as $prefix => $type) {
				if ($ids = $req->getParam($type)) {
					$tids = explode(',', $ids);
					foreach ($tids as $id) {
						$tags[] = $prefix . $id;
					}
				}
			}
			$tags = array_unique($tags);
		}
		if (empty($tags)) {
			$this->_errorExit('Invalid url');
		}
		else {
			Mage::helper('litemage/esi')->setPurgeHeader($tags, 'litemage/shell/purge');
			$this->getResponse()->setBody('purged tags ' . implode(',', $tags));
		}
    }

    protected function _accessAllowed()
    {
        if ( $this->_config->moduleEnabledForUser() && $this->_config->isAdminIP() ) {
            $this->_helper = Mage::helper('litemage/esi') ;
            return true ;
        }
        else
            return false ;
    }

    protected function _validatePurgeTags()
    {
        $req = $this->getRequest() ;
        $tags = $req->getParam('tags');
        if ($tags == null) {
            return 'Missing tags value';
        }
        $data = explode(',', $tags);
        foreach ($data as $d) {
            if ( !preg_match("/^[GCPS]\.\d+$/", $d)) {
                return 'Invalid Format';
            }
        }
        $this->_data = $data;
    }

}
