<?php
/**
 * Unirgy_StoreLocator extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Unirgy
 * @package    Unirgy_StoreLocator
 * @copyright  Copyright (c) 2008 Unirgy LLC
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * @category   Unirgy
 * @package    Unirgy_StoreLocator
 * @author     Boris (Moshe) Gurevich <moshe@unirgy.com>
 */
class Unirgy_StoreLocator_Helper_Data extends Mage_Core_Helper_Data
{
    protected $_locations = array();

    public function getLocation($id)
    {
        if (!isset($this->_locations[$id])) {
            $location = Mage::getModel('ustorelocator/location')->load($id);
            $this->_locations[$id] = $location->getId() ? $location : false;
        }
        return $this->_locations[$id];
    }
}
