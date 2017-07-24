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
 * @package    Turnkeye_Testimonial
 * @copyright  Copyright (c) 2010-2012 TurnkeyE Co. (http://turnkeye.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Turnkeye Testimonial data helper
 *
 * @category   Turnkeye
 * @package    Turnkeye_Testimonial
 * @author     Viacheslav Fedorenko <v.fedorenko@turnkeye.com>
 */
class Turnkeye_Testimonial_Helper_Data extends Mage_Core_Helper_Abstract
{

    /**
     * Get name of the extension
     *
     * @return string - name
     */
    public function getTranslatedExtensionName()
    {
        return $this->__('Testimonials');
    }

    /**
     * Get url for check updates
     *
     * @return string - URL
     */
    public function getCheckUpdateUrl()
    {
        $_t = explode('_', __CLASS__);
        $module_name = $_t[0] . '_' . $_t[1];
        $version = (string)Mage::getConfig()->getModuleConfig($module_name)->version;
        $check_url = 'http://turnkeye.com/extension.html?name=' . $module_name . '&version=' . $version;
        return $check_url;
    }

}
