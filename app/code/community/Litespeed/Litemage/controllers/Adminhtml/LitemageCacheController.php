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



class Litespeed_Litemage_Adminhtml_LitemageCacheController extends Mage_Adminhtml_Controller_Action
{
    public function purgeAllAction()
    {
        Mage::getModel( 'litemage/observer_purge' )->adminPurgeCache(null);
        $this->_redirect('*/cache/index');
    }

    public function purgeTagAction()
    {
        $req = $this->getRequest();
        Mage::getModel( 'litemage/observer_purge' )->adminPurgeCacheBy($req->getParam('tag_types'), $req->getParam('purge_tag'));
        $this->_redirect('*/cache/index');
    }

    public function purgeUrlAction()
    {
        Mage::getModel( 'litemage/observer_purge' )->adminPurgeCacheBy('U', $this->getRequest()->getParam('purge_url'));
        $this->_redirect('*/cache/index');
    }

	public function resetCrawlerListAction()
	{
        $req = $this->getRequest();
        Mage::getModel( 'litemage/observer_cron' )->resetCrawlerList($req->getParam('list'));
        $this->_redirect('*/cache/index');
	}

	public function getCrawlerListAction()
	{
        $req = $this->getRequest();
        $output = Mage::getModel( 'litemage/observer_cron' )->getCrawlerList($req->getParam('list'));
		$this->getResponse()->setBody($output);
	}
	
	public function productSaveOptionAction()
	{
		$req = $this->getRequest();
		$session = Mage::getSingleton('admin/session');
		$id = $req->getParam('id');
		
		if ($req->getParam('litemage_purgeprod')) {
			Mage::dispatchEvent('litemage_purge_trigger',
				 array('action'=>'admin_prod_save', 'option'=>'p', 'id'=>$id));	
		}
		elseif ($req->getParam('litemage_purgepcats')) {
			Mage::dispatchEvent('litemage_purge_trigger',
				 array('action'=>'admin_prod_save', 'option'=>'c', 'id'=>$id));	
		}
		elseif ($req->getParam('litemage_prodpurgeoption')) {
			$option = $req->getParam('litemage_prodpurgeoption');
			if (in_array($option, array('c','p','n'))) {
				$session->setData(Litespeed_Litemage_Block_Adminhtml_ItemSave::SAVE_PROD_SESSION_KEY, $option);
			}
		}
		$this->_redirect('*/catalog_product/edit', array('id'=>$id));
	}

	public function categorySaveOptionAction()
	{
		$req = $this->getRequest();
		$session = Mage::getSingleton('admin/session');
		$id = $session->getLastEditedCategory(false);
		$params = array( 'id' => $id);
		$storeId = (int) $req->getParam('store');
		$parentId = (int) $req->getParam('parent');
		$prevStoreId = $session->getLastViewedStore(false);
		if (!empty($prevStoreId)) {
			$storeId = $prevStoreId;
		}
		if (!empty($storeId)) {
			$params['store'] = $storeId;
		}
		if (!empty($parentId))
			$params['parent'] = $parentId;
		
		if ($req->getParam('saveoption')) {
			$option = $req->getParam('saveoption');
			if (in_array($option, array('c','s','p','a','n'))) {
				$session->setData(Litespeed_Litemage_Block_Adminhtml_ItemSave::SAVE_CAT_SESSION_KEY, $option);
			}
		}
		else if ($req->getParam('useoption')) {
			$use = $req->getParam('useoption');
			$option = 'c';
			if ($use == 2) {
				$option = $session->getData(Litespeed_Litemage_Block_Adminhtml_ItemSave::SAVE_CAT_SESSION_KEY);
			}
			if ($option != 'n') {
				Mage::dispatchEvent('litemage_purge_trigger',
					 array('action'=>'admin_cat_purge', 'option'=>$option, 'id'=>$id));	
			}
		}

		$this->_forward('edit', 'catalog_category',null,$params);
	}

	protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('system/cache/litemage');
    }
}
