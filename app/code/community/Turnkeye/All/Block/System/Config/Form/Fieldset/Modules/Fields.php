<?php
/**
 * TurnkeyE Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0).
 * It is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you are unable to obtain it through the world-wide-web, please send
 * an email to info@turnkeye.com so we can send you a copy immediately.
 *
 * @category   Turnkeye
 * @package    Turnkeye_All
 * @copyright  Copyright (c) 2010-2012 TurnkeyE Co. (http://turnkeye.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Installed Extensions fields block on system configuration
 *
 * @category   Turnkeye
 * @package    Turnkeye_All
 * @author     Viacheslav Fedorenko <v.fedorenko@turnkeye.com>
 */

class Turnkeye_All_Block_System_Config_Form_Fieldset_Modules_Fields extends Mage_Adminhtml_Block_Abstract
{

    /**
     * Internal constructor, that is called from real constructor
     *
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('turnkeye/all/fields.phtml');
    }

}
