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


class Litespeed_Litemage_Helper_Viewvary
{
    protected $_vary = array( 'toolbar' => '_adjustToolbar', 'env' => '_setEnv', 'review' => '_checkReviewVary' ) ;

    public function persistViewVary( $tags )
    {
		$tags = array_unique($tags);
        foreach ( $tags as $tag ) {
            $func = $this->_vary[$tag] ;
            $this->$func(true) ;
        }
    }

    public function restoreViewVary( $tags )
    {
        foreach ( $tags as $tag ) {
            $func = $this->_vary[$tag] ;
            $this->$func(false) ;
        }
    }

    protected function _setEnv( $isSave )
    {
        if ($isSave) {
            // run before exit, as value maybe changed during process.
            Mage::helper('litemage/esi')->setDefaultEnvCookie();
        }
    }

	protected function _checkReviewVary($isSave)
	{
		if ($isSave) {
			// only set if there's existing cookie
			if (!Mage::helper('review')->getIsGuestAllowToWrite()) {
				// only logged in allow to write review
				$diffGrp = Mage::helper('litemage/data')->getConf(Litespeed_Litemage_Helper_Data::CFG_DIFFCUSTGRP);
				$addReviewVary = 0;
				if (0 == $diffGrp) {
					// no seperate copy per user group, so need to distinguish here
					$addReviewVary = Mage::getSingleton('customer/session')->isLoggedIn() ? 2 : 1;
				}
				elseif (3 == $diffGrp) {
					$cgset = Mage::helper('litemage/data')->getConf(Litespeed_Litemage_Helper_Data::CFG_DIFFCUSTGRP_SET);
					$currCustomerGroup = Mage::getSingleton('customer/session')->getCustomerGroupId() ;
					if (!isset($cgset[$currCustomerGroup])) {
						// mixed logged in group with non-logged-in
						$addReviewVary = (Mage_Customer_Model_Group::NOT_LOGGED_IN_ID != $currCustomerGroup) ? 2 : 1;
					}
				}
				
				if ($addReviewVary == 1) { // cookie only
					Mage::helper('litemage/esi')->addEnvVars('_lscache_vary_review') ;
				}
				elseif ($addReviewVary == 2) { // cookie & value
					Mage::helper('litemage/esi')->addEnvVars('_lscache_vary_review', 'write', '1') ;
				}
			}
		}
	}

    protected function _adjustToolbar( $isSave )
    {
        // for Mage_Catalog_Block_Product_List
        $helper = Mage::helper('litemage/esi') ;
        $isDebug = $helper->isDebug() ;
        $session = Mage::getSingleton('catalog/session') ;
        $cookieName = '_lscache_vary_toolbar' ;
        $keys = array( 'sort_order', 'sort_direction', 'display_mode', 'limit_page' ) ;
        // limit_page is linked to display_mode, sort_direction is linked to sort_order
        $cookieVars = $helper->getCookieEnvVars($cookieName) ;

        if ( $isSave ) {
            $saved = false ;
            $mesg = 'addEnv ' . $cookieName;
            foreach ( $keys as $key ) {
                if ( $value = $session->getData($key) ) {
                    // only save limit_page if mode is same
                    if ( $key == 'limit_page' ) {
                        $old_mode = ( $cookieVars != null && isset($cookieVars['display_mode']) ) ? $cookieVars['display_mode'] : '' ;
                        $cur_mode = $session->getData('display_mode') ;
                        if ( $old_mode != $cur_mode )
                            continue ;
                    }

                    $helper->addEnvVars($cookieName, $key, $value) ;
                    if ($isDebug) {
                        $mesg .= ' ' . $key . '=' . $value ;
                    }
                    $saved = true ;
                }
            }

            if ( ! $saved ) {
                $helper->addEnvVars($cookieName) ;
            }

            if ( $isDebug ) {
                Mage::helper('litemage/data')->debugMesg($mesg) ;
            }

        }
        else {
            // restore
            if ( $cookieVars != null ) {
                foreach ( $keys as $key ) {
                    if ( isset($cookieVars[$key]) )
                        $session->setData($key, $cookieVars[$key]) ;
                    else
                        $session->unsetData($key) ;
                }
            }
        }
    }

}
