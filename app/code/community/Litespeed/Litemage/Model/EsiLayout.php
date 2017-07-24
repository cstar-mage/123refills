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

// should only be used by EsiController

class Litespeed_Litemage_Model_EsiLayout extends Mage_Core_Model_Layout
{

	protected $_collecting ;

	/**
	 * Class constructor
	 *
	 * @param array $data
	 */
	public function __construct( $data = array() )
	{
		$this->_elementClass = Mage::getConfig()->getModelClassName('core/layout_element') ;
		$this->setXml(simplexml_load_string('<layout/>', $this->_elementClass)) ;
		$this->_update = Mage::getModel('litemage/layout_esiUpdate') ;
	}

	public function getBlock( $name )
	{
		if (isset($this->_blocks[$name] )) {
			return $this->_blocks[$name] ;
		}
		elseif (strpos($name, 'price') !== false) {
			// catalog_product_price_template
			return null;
		}
		else {
			// root head
			return new Litespeed_Litemage_Block_Core_Dummy($name);
		}
	}

	public function loadEsiLayout( $esiData )
	{
		$this->_output = array() ;
		$this->_blocks = array() ;
		$this->_collecting = false ;

		$updates = '<?xml version="1.0"?><layout>' . $esiData->getLayoutXml() . '</layout>' ;
		$this->setXml(simplexml_load_string($updates, $this->_elementClass)) ;
		parent::generateBlocks() ;
	}

	public function loadHanleXml( $handles )
	{
		$this->_output = array() ;
		$this->_blocks = array() ;
		$this->_collecting = true ;

		$this->_update->init($handles) ;
		$this->generateXml() ;
		$this->generateXmlBlocks() ;
	}

	public function generateXmlBlocks( $parent = null )
	{
		if ( empty($parent) ) {
			$parent = $this->getNode() ;
		}
		foreach ( $parent as $node ) {
			$attributes = $node->attributes() ;
			if ( (bool) $attributes->ignore ) {
				continue ;
			}
			switch ( $node->getName() ) {
				case 'block':
					$this->_generateXmlBlock($node, $parent) ;
					$this->generateXmlBlocks($node) ;
					break ;

				case 'reference':
					$this->generateXmlBlocks($node) ;
					break ;

				case 'action':
					$this->_generateXmlAction($node, $parent) ;
					break ;
			}
		}
	}

	protected function _generateXmlBlock( $node, $parent )
	{
		$name = (string) $node['name'] ;
		if ( empty($name) || '.' === $name{0} ) { // ignore
			return false ;
		}
		$block = new Litespeed_Litemage_Block_Core_Xml() ;
		$block->setNameInLayout($name) ;
		$block->setLayout($this) ;

		$this->_blocks[$name] = $block ;

		if ( ! empty($node['parent']) ) {
			$parentBlock = $this->getBlock((string) $node['parent']) ;
		}
		else {
			$parentName = $parent->getBlockName() ;
			if ( ! empty($parentName) && isset($this->_blocks[$parentName]) ) {
				$parentBlock = $this->_blocks[$parentName] ;
			}
		}
		if ( ! empty($parentBlock) ) {
			$alias = isset($node['as']) ? (string) $node['as'] : '' ;
			$parentBlock->append($block, $alias) ;
			if ( $parent != null && $parent->getName() == 'reference' ) {
				$parentBlock->addXmlNode($parent) ;
			}
		}
		$block->addXmlNode($node) ;

		return $this ;
	}

	protected function _generateXmlAction( $node, $parent )
	{
		if ( ! empty($node['block']) ) {
			$parentName = (string) $node['block'] ;
			$collectNode = $node ;
		}
		else {
			$parentName = $parent->getBlockName() ;
			$collectNode = $parent ;
		}

		if ( ! empty($parentName) && isset($this->_blocks[$parentName]) ) {
			$this->_blocks[$parentName]->addXmlNode($collectNode) ;
		}

		return $this ;
	}

	public function getBiBlock( $blockIndex )
	{
		if ( strpos($blockIndex, ';') === false ) {
			return isset($this->_blocks[$blockIndex]) ?
					$this->_blocks[$blockIndex] : null ;
		}

		$bi = explode(';', $blockIndex) ;

		$pn = array_shift($bi) ;
		if ( ! isset($this->_blocks[$pn]) ) {
			return null ;
		}

		$parent = $this->_blocks[$pn] ;
		foreach ( $bi as $bn ) {
			if ( $pos = strpos($bn, ',') ) {
				$bn = substr($bn, $pos + 1) ;
			}
			if ( $block = $parent->getChild($bn) ) {
				$parent = $block ;
			}
			else {
				return null ;
			}
		}
		return $parent ;
	}

	public function getEsiBlock( $blockIndex )
	{
		if ( strpos($blockIndex, ';') ) {
			$bi = explode(';', $blockIndex) ;
			$bn = array_pop($bi) ;
			if ( $pos = strpos($bn, ',') ) {
				$bn = substr($bn, 0, $pos) ;
			}
		}
		else {
			$bn = $blockIndex ;
		}

		return isset($this->_blocks[$bn]) ? $this->_blocks[$bn] : null ;
	}

}
