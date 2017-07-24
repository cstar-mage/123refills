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


/* This is place holder block to adjust javascript variables. This is a private block, so javascript variable can be adjusted to correct value.
 *
 * The template file is jsvar.phtml

 */

class Litespeed_Litemage_Block_Inject_Jsvar extends Mage_Core_Block_Template
{
    public function isAllowed()
    {
        // only allow this block output if the current url allow ESI injection.
        $helper = Mage::helper('litemage/esi');
        if ($helper->isEsiRequest() || $helper->canInjectEsi()) {
            return true;
        }
        else {
            return false;
        }
    }

    // you can add your own function here to handle customized javascript variable
}
