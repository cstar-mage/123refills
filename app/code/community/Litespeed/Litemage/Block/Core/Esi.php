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

class Litespeed_Litemage_Block_Core_Esi extends Mage_Core_Block_Abstract
{

	protected $_peer ;

	public function initByPeer( $peer )
	{
		$this->_peer = $peer ;
		parent::setData('litemage_bconf', $peer->getData('litemage_bconf')) ;

		$this->_layout = $peer->_layout ;
		$this->_nameInLayout = $peer->_nameInLayout ;
		$this->_alias = $peer->_alias ;
		if ( $parent = $peer->getParentBlock() ) {
			$parent->setChild($peer->_alias, $this) ;
		}

		if ( $this->_layout->getBlock($peer->_nameInLayout) === $peer ) {
			// some bad plugins with duplicated names may lost this block, only replace if same object
			$this->_layout->setBlock($this->_nameInLayout, $this) ;
		}
	}
	
	public function __call($method, $args)
	{
		$m = substr($method, 0, 3);
		$key = parent::_underscore(substr($method,3));
		switch ($m) {
			case 'set':
				return $this->setData($key, isset($args[0]) ? $args[0] : null);
			case 'uns':
				return $this->unsetData($key);
			case 'get':
				return parent::getData($key, isset($args[0]) ? $args[0] : null);
			case 'has':
				return isset($this->_data[$key]);
			default:
				return null;
		}
	}

	public static function __callStatic($method, $args)
	{
		Mage::helper('litemage/data')->debugMesg('esi block ' . $this->_nameInLayout . " called static $method - ignore");
	}
	

	protected function _loadCache()
	{
		$esiHtml = Mage::helper('litemage/esi')->getEsiIncludeHtml($this) ;
		if ( ! $esiHtml ) {
			return false ;
		}

		$bconf = $this->getData('litemage_bconf') ;
		Mage::helper('litemage/data')->debugMesg('Injected ESI block ' . $this->_nameInLayout . ' ' . $esiHtml) ;

		if ( ! $bconf['valueonly'] && Mage::registry('LITEMAGE_SHOWHOLES') ) {
			$tip = 'LiteMage ESI block ' . $this->_nameInLayout ;
			$wrapperBegin = '<div style="position:relative;border:1px dotted red;background-color:rgba(198,245,174,0.3);margin:2px;padding:18px 2px 2px 2px;zoom:1;" title="' . $tip
					. '"><div style="position: absolute; left: 0px; top: 0px; padding: 2px 5px; color: white; font-style: normal; font-variant: normal; font-weight: normal; font-size: 11px; line-height: normal; font-family: Arial; z-index: 998; text-align: left !important; background: rgba(0,100,0,0.5);">' . $tip . '</div>' ;
			$wrapperEnd = '</div>' ;

			return $wrapperBegin . $esiHtml . $wrapperEnd ;
		}
		return $esiHtml ;
	}

	protected function _saveCache( $data )
	{
		return false ;
	}

    public function setData($key, $value=null)
    {
		if ($key == 'module_name') {
			return parent::setData($key, $value);
		}
		
		$ignored = 1;
		if (is_scalar($key) && is_scalar($value)) {
			$bconf = $this->getData('litemage_bconf');
			if (!empty($bconf)) {
				$bconf['extra'][$key] = $value;
				parent::setData('litemage_bconf', $bconf);
				$ignored = 0;
			}
		}		
		Mage::helper('litemage/data')->debugMesg('esi block ' . $this->_nameInLayout . " called setData $key=$value ignored=$ignored");
		return parent::setData($key, $value);
    }
	
	public function unsetData($key=null)
	{
		$ignored = 1;
		$bconf = $this->getData('litemage_bconf');
		if (isset($bconf['extra'][$key])) {
			unset($bconf['extra'][$key]);
			parent::setData('litemage_bconf', $bconf);
			$ignored = 0;
		}
		Mage::helper('litemage/data')->debugMesg('esi block ' . $this->_nameInLayout . " called unsetData $key ignored=$ignored");
		return parent::unsetData($key);
	}
}
