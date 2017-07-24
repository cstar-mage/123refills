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


/* This is sample code to inject a private block which shows customer name only.
    * In litemage config.xml, this block needs to have <valueonly>1</valueonly>. It will output pure value, no added html tags.
    *
    * For example, if nickname is used in an input value field, we need to inject a private block for it.
    * Original template code:
    * <input type="text" name="nickname" id="nickname_field" class="input-text required-entry" value="php echo $this->htmlEscape($data->getNickname()) ?>" required/>
    * We need to add a nickname block in xml under the current block, and add this block class.
    * Update template code to:
    * <input type="text" name="nickname" id="nickname_field" class="input-text required-entry" value="<?php echo $this->getChildHtml('nickname') ?>" required/>
    * For regular esi injected block, we'll output html comment tags around it, however for this case, we can only output pure value.
	*
	* This is just one example. As of 1.2.0, the nickname output inside Review Form on a cacheable page (like in product view page) is handled automatically.
	* You no longer need to manually adjust layout file.

 */

class Litespeed_Litemage_Block_Inject_Nickname extends Mage_Core_Block_Abstract
{

    /**
     * Get block messsage
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (empty($this->_data['nickname'])) {
            $session = Mage::getSingleton('customer/session');
            if ($session->isLoggedIn()) {
                $this->_data['nickname'] = Mage::helper('core')->escapeHtml($session->getCustomer()->getFirstname());
            }
            else {
                $this->_data['nickname'] = '';
            }
        }

        return $this->_data['nickname'];
    }

}
