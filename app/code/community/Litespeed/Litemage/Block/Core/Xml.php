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


class Litespeed_Litemage_Block_Core_Xml extends Mage_Core_Block_Abstract
{
	protected $_xmlNodes = array();

	public function addXmlNode($node)
	{
		$id = spl_object_hash($node);
		if (!isset($this->_xmlNodes[$id])) {
			$this->_xmlNodes[$id] = $node;
		}
	}

	public function getXmlString($bi)
	{
		$xml = $this->_getBlockXmlString($bi);
		return $xml;
	}
	
	// xml block not exist in ESILayout, they are not ESI block, safe to ignore
	public function __call($method, $args)
	{
		Mage::helper('litemage/data')->debugMesg('Xml block ' . $this->_name . " called $method - ignore");

	}

	public static function __callStatic($method, $args)
	{
		Mage::helper('litemage/data')->debugMesg('Xml block ' . $this->_name . " called static $method - ignore");
	}

	protected function _getBlockXmlString($bi)
	{
		$xml = '';
		$name = $this->getNameInLayout();
		foreach ($this->_xmlNodes as $node) {
			$xml .= $this->_getNodeXmlString($node, $bi);
		}
		foreach ($this->_children as $childBlock) {
			$xml .= $childBlock->_getBlockXmlString($bi);
		}
		return $xml;
	}

	protected function _getNodeXmlString($node, $bi)
	{
		if ($node->getAttribute("lm_$bi")) {
			return; // used
		}
		$xml = $node->asNiceXml();
		$this->_markNode($node, $bi);
		return $xml;
	}

	protected function _markNode($node, $bi)
	{
		$node->addAttribute("lm_$bi", true);
		foreach ($node as $child) {
			$this->_markNode($child, $bi);
		}
	}


}