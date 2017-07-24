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

class Litespeed_Litemage_Model_Session extends Mage_Core_Model_Session_Abstract
{
    protected $_isDebug;

    public function __construct()
    {
        $this->init('litemage');
        $this->_isDebug = Mage::helper('litemage/data')->isDebug();
    }

    /**
     * Save the messages for a given block to the session
     *
     * @param  string $blockName
     * @param  array $messages
     * @return null
     */
    public function saveMessages( $blockName, $messages )
    {
        $stored = $this->getData($blockName);
        if ($stored != null) {
            $messages = array_merge($stored, $messages);
        }
        $this->setData($blockName, $messages);
        if ($this->_isDebug)
            Mage::helper('litemage/data')->debugMesg("saveMessages for $blockName " . print_r($messages, true));
    }

    /**
     * Retrieve the messages for a given messages block
     *
     * @param  string $blockName
     * @return array
     */
    public function loadMessages( $blockName )
    {
        $messages = $this->getData($blockName);
        $this->unsetData($blockName);
        return $messages;
    }

}
