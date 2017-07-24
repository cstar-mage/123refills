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


class Litespeed_Litemage_Model_Layout_EsiUpdate extends Mage_Core_Model_Layout_Update
{
    protected $_cachePrefix;
	protected $_layoutMaster;
    protected $_isDebug;

    public function setCachePrefix($unique)
    {
        $this->_cachePrefix = 'LAYOUT_ESI_' . $unique . '_';
        $this->_isDebug = Mage::helper('litemage/data')->isDebug() ;
    }

	public function init($handles)
	{
        $this->_cacheId = null;
        $this->resetHandles();
        $this->resetUpdates();
		$this->load($handles) ;
	}

    /**
     * Get cache id
     *
     * @return string
     */
    public function getCacheId()
    {
        if (!$this->_cacheId) {
            $tags = $this->getHandles();
            $this->_cacheId = $this->_cachePrefix . md5(join('__', $tags));
			if ($this->_isDebug) {
				Mage::helper('litemage/data')->debugMesg('LU_Load  H=' . join(',',$tags) . ' ID=' . substr($this->_cacheId, 7));
			}

        }
        return $this->_cacheId;
    }

    /*
     * @return -1: no layout cache allowed, 0: nocache, 1: has cache
     */

    public function loadEsiBlockCache($blockName, $handles)
    {
        if (!Mage::app()->useCache('layout')) {
            return -1;
        }
        //reset internals
        $this->setBlockNames(array($blockName));
        $this->addHandle($handles);

        if ($this->loadCache())
            return 1;
        else
            return 0;
    }

	public function merge($handle)
    {
		if (!$this->_layoutMaster) {
			$this->_layoutMaster = Mage::getSingleton('litemage/layout_master');
		}
		if (($update = $this->_layoutMaster->getHandleUpdates($handle)) !== false) {
			return $this->addUpdate($update);
		}
		return parent::merge($handle);
    }

    public function loadCache()
    {
        if (!Mage::app()->useCache('layout')) {
            return false;
        }

        if (!$result = Mage::app()->loadCache($this->getCacheId())) {
            return false;
        }

		$this->addUpdate($result);

        return true;
    }

    public function saveCache()
    {
        if (!Mage::app()->useCache('layout')) {
            return false;
        }

        $tags = $this->getHandles();
        $tags[] = Mage_Core_Model_Layout_Update::LAYOUT_GENERAL_CACHE_TAG;
        $tags[] = Litespeed_Litemage_Helper_Data::LITEMAGE_GENERAL_CACHE_TAG;
        $content = $this->asString();
        return Mage::app()->saveCache($content, $this->getCacheId(), $tags, null);
    }

}
