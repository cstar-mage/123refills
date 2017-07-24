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
class Litespeed_Litemage_Block_Core_Messages extends Mage_Core_Block_Messages
{

	protected $_peer ;
	protected $_messageBlock ;
	protected $_outputCall ;
	protected $_peerClass ;
	protected $_peerTemplate ;
	protected $_blockIndex ;
	protected $_isEsiInject ;

	/* Override Mage_Core_Block_Abstract:getMessagesBlock */

	public function getMessagesBlock()
	{
		return $this ;
	}

	public function initByPeer( $peer )
	{
		$this->_peer = $peer ;
		$this->setData('litemage_bconf', $peer->getData('litemage_bconf')) ;
		$this->_peerClass = get_class($peer) ;
		$this->_peerTemplate = $peer->getTemplate() ; // todo: check if null;
		$this->_isEsiInject = true ;

		$this->_layout = $peer->_layout ;
		if ( $peer instanceof Mage_Core_Block_Messages ) {
			$this->_messageBlock = $peer ;
		}
		else {
			$this->_messageBlock = $this->_layout->getMessagesBlock() ;
		}

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

	public function getEsiOutput( $esiData )
	{
		$data = $esiData->getData() ;
		$this->_usedStorageTypes = explode(',', $data['st']) ;
		$this->_outputCall = $data['call'] ;
		$this->_peerClass = $data['pc'] ;
		$this->_blockIndex = $esiData->getLayoutAttribute('bi') ;
		$this->_isEsiInject = false ;

		$peer = new $this->_peerClass() ;
		if ( $peer instanceof Mage_Core_Block_Messages ) {
			$this->_messageBlock = $peer ;
		}
		else {
			$this->_messageBlock = new Mage_Core_Block_Messages() ;
		}

		$this->_loadMessages() ;
		if ( ! empty($data['pt']) ) {
			$this->_peerTemplate = $data['pt'] ;
			$this->setTemplate($this->_peerTemplate) ;
			$this->setScriptPath(Mage::getBaseDir('design')) ;
			return $this->fetchView($this->getTemplateFile()) ;
		}
		else {
			// default is getGroupedHtml
			if ( strncmp($this->_outputCall, 'getHtml', 7) == 0 ) {
				$type = ($this->_outputCall == 'getHtml') ? null : substr($this->_outputCall, 7) ;
				return $this->_messageBlock->getHtml($type) ;
			}
			else {
				return $this->_messageBlock->getGroupedHtml() ;
			}
		}
	}

	public function renderView()
	{
		if ( ! $this->_isEsiInject ) {
			return $this->_messageBlock->renderView() ;
		}

		$messages = $this->getMessages() ;
		if ( count($messages) > 0 ) {
			// maybe multiple places point to same mesg block if use getMessageBlock(), use the name of the this->_messagesBlock, not itself
			//Mage::getSingleton('litemage/session')->saveMessages($this->_messageBlock->_nameInLayout, $messages) ;
			// todo: change to bi
			Mage::getSingleton('litemage/session')->saveMessages($this->_nameInLayout, $messages) ;
			$this->getMessageCollection()->clear() ;
		}

		$esiHtml = $this->getData('esiHtml') ;
		Mage::helper('litemage/data')->debugMesg('Injected ESI Message block renderview ' . $this->_nameInLayout . ' ' . $esiHtml) ;

		if ( Mage::registry('LITEMAGE_SHOWHOLES') ) {
			$tip = 'LiteMage ESI message block ' . $this->_nameInLayout ;
			$wrapperBegin = '<div style="position:relative;border:1px dotted red;background-color:rgba(255,255,0,0.3);margin:2px;padding:18px 2px 2px 2px;zoom:1;" title="' . $tip
					. '"><div style="position: absolute; left: 0px; top: 0px; padding: 2px 5px; color: green; font-style: normal; font-variant: normal; font-weight: normal; font-size: 11px; line-height: normal; font-family: Arial; z-index: 998; text-align: left !important;">' . $tip . '</div>' ;
			$wrapperEnd = '</div>' ;

			return $wrapperBegin . $esiHtml . $wrapperEnd ;
		}
		else
			return $esiHtml ;
	}

	public function getGroupedHtml()
	{
		if ( ! $this->_isEsiInject ) {
			return $this->_messageBlock->getGroupedHtml() ;
		}

		$esiHtml = Mage::helper('litemage/esi')->getEsiIncludeHtml($this) ;
		$this->_adjustEsiUrl($esiHtml, 'getGroupedHtml') ;
		return $this->renderView() ;
	}

	public function getHtml( $type = null )
	{
		if ( ! $this->_isEsiInject ) {
			return $this->_messageBlock->getHtml() ;
		}
		$esiHtml = Mage::helper('litemage/esi')->getEsiIncludeHtml($this) ;
		$this->_adjustEsiUrl($esiHtml, 'getHtml', $type) ;
		return $this->renderView() ;
	}

	public function _prepareLayout()
	{
		// do nothing, as data already carried over
		return $this ;
	}

	protected function _loadCache()
	{
		$esiHtml = Mage::helper('litemage/esi')->getEsiIncludeHtml($this) ;
		$this->_adjustEsiUrl($esiHtml, '_toHtml') ;
		return $this->renderView() ;
	}

	protected function _toHtml()
	{
		if ( $this->getTemplate() ) {
			$this->setScriptPath(Mage::getBaseDir('design')) ;
			$html = $this->fetchView($this->getTemplateFile()) ;
			return $html ;
		}
		$this->_loadMessages() ;

		// default is getGroupedHtml
		if ( strncmp($this->_outputCall, 'getHtml', 7) == 0 ) {
			$type = ($this->_outputCall == 'getHtml') ? null : substr($this->_outputCall, 7) ;
			return $this->getHtml($type) ;
		}
		else {
			return $this->getGroupedHtml() ;
		}
	}

	protected function _adjustEsiUrl( $esiHtml, $caller, $type = null )
	{
		if ( strpos($esiHtml, '/getBlock/') ) {
			$params = array(
				'st' => join(',', $this->_getStorageTypes()),
				'call' => $caller . $type,
				'pc' => $this->_peerClass,
				'pt' => $this->_peerTemplate ) ;
			$eparams = Mage::helper('litemage/data')->encodeEsiUrlParams($params) ;
			$replaced = '/getMessage' ;
			foreach ( $eparams as $key => $v ) {
				if ( $v ) {
					$replaced .= '/' . $key . '/' . $v ;
				}
			}
			$replaced .= '/' ;

			$esiHtml = str_replace('/getBlock/', $replaced, $esiHtml) ;
			$this->setData('esiHtml', $esiHtml) ;
		}
	}

	protected function _loadMessages( $type = null )
	{
		$session = Mage::getSingleton('litemage/session') ;
		if ( ($savedMessages = $session->loadMessages($this->_blockIndex)) != null ) {
			foreach ( $savedMessages as $savedMessage ) {
				$this->addMessage($savedMessage) ;
			}
		}

		$types = ($type == null) ? $this->_usedStorageTypes : (is_array($type) ? $type : array( $type )) ;

		foreach ( $types as $storageName ) {
			if ( ($storage = Mage::getSingleton($storageName)) != null ) {
				$this->addMessages($storage->getMessages(true)) ;
				if ( $flag = $storage->getEscapeMessages(true) ) {
					$this->setEscapeMessageFlag($flag) ;
				}
			}
		}
	}

	public function setEscapeMessageFlag( $flag )
	{
		$this->_messageBlock->setEscapeMessageFlag($flag) ;
		return $this ;
	}

	/**
	 * Set messages collection
	 *
	 * @param   Mage_Core_Model_Message_Collection $messages
	 * @return  Mage_Core_Block_Messages
	 */
	public function setMessages( Mage_Core_Model_Message_Collection $messages )
	{
		$this->_messageBlock->setMessages($messages) ;
		return $this ;
	}

	/**
	 * Add messages to display
	 *
	 * @param Mage_Core_Model_Message_Collection $messages
	 * @return Mage_Core_Block_Messages
	 */
	public function addMessages( Mage_Core_Model_Message_Collection $messages )
	{
		if ( $messages->count() > 0 ) {
			$this->_messageBlock->addMessages($messages) ;
		}
		return $this ;
	}

	/**
	 * Retrieve messages collection
	 *
	 * @return Mage_Core_Model_Message_Collection
	 */
	public function getMessageCollection()
	{
		return $this->_messageBlock->getMessageCollection() ;
	}

	/**
	 * Adding new message to message collection
	 *
	 * @param   Mage_Core_Model_Message_Abstract $message
	 * @return  Mage_Core_Block_Messages
	 */
	public function addMessage( Mage_Core_Model_Message_Abstract $message )
	{
		$this->_messageBlock->addMessage($message) ;
		return $this ;
	}

	/**
	 * Retrieve messages array by message type
	 *
	 * @param   string $type
	 * @return  array
	 */
	public function getMessages( $type = null )
	{
		return $this->_messageBlock->getMessages($type) ;
	}

	/**
	 * Set messages first level html tag name for output messages as html
	 *
	 * @param string $tagName
	 */
	public function setMessagesFirstLevelTagName( $tagName )
	{
		$this->_messageBlock->setMessagesFirstLevelTagName($tagName) ;
	}

	/**
	 * Set messages first level html tag name for output messages as html
	 *
	 * @param string $tagName
	 */
	public function setMessagesSecondLevelTagName( $tagName )
	{
		$this->_messageBlock->setMessagesSecondLevelTagName($tagName) ;
	}

	/**
	 * Get cache key informative items
	 *
	 * @return array
	 */
	public function getCacheKeyInfo()
	{
		return $this->_messageBlock->getCacheKeyInfo() ;
	}

	/**
	 * Add used storage type
	 *
	 * @param string $type
	 */
	public function addStorageType( $type )
	{
		$this->_messageBlock->addStorageType($type) ;
		if ( ! in_array($type, $this->_usedStorageTypes) )
			$this->_usedStorageTypes[] = $type ;
	}

	protected function _getStorageTypes()
	{
		// it's possible, messageblock already replaced with esi one, when using layout->getMessageBlock
		$types = array_merge($this->_usedStorageTypes, $this->_messageBlock->_usedStorageTypes) ;
		if ( ($this->_messageBlock instanceof Litespeed_Litemage_Block_Core_Messages) && ($this->_messageBlock->_messagesBlock
				!= null) ) {
			$types = array_merge($types, $this->_messageBlock->_messagesBlock->_usedStorageTypes) ;
		}
		return array_unique($types) ;
	}

}
