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
 * Turnkeye All data helper
 *
 * @category   Turnkeye
 * @package    Turnkeye_All
 * @author     Viacheslav Fedorenko <v.fedorenko@turnkeye.com>
 */
class Turnkeye_All_Helper_Data extends Mage_Core_Helper_Abstract
{

    /**
     * This text display on Turnkeye about and support configuration tabs.
     * If you change it here you should change it in translate file!
     */
    const ABOUT_TEXT   = "<a href='http://turnkeye.com' target='_blank'>Turnkey Ecommerce Solutions (TurnkeyE)</a> is a full service Internet solution agency and custom development company with a b team of IT eCommerce professionals. We are specializing in eCommerce solutions with full life cycle support.<br /><br />The solutions provided by Turnkey Ecommerce Solutions include: Consulting, Magento development, Web design, Mobile web development, Facebook Apps development.";
    const SUPPORT_TEXT = "Please <a href='http://turnkeye.com/contact_us.html' target='_blank'>contact us</a>, if you have some issues with one of our modules.";

    /**
     * Get extension prefix name (company)
     *
     * @return string - extension prefix
     */
    public function getExtensionPrefix()
    {
        static $module = null;
        if (is_null($module)) {
            $_data = explode('_', __CLASS__);
            $module = $_data[0] . '_';
        }

        return $module;
    }

    /**
     * Get main extension name
     *
     * @return string - main extension name
     */
    public function getMainExtensionName()
    {
        static $module = null;
        if (is_null($module)) {
            $_data = explode('_', __CLASS__);
            $module = $_data[1];
        }

        return $module;
    }

    /**
     * Get info text for config about tab information
     */
    public function getAboutText()
    {
        return self::ABOUT_TEXT;
    }

    /**
     * Get info text for config about tab information
     */
    public function getSupportText()
    {
        return self::SUPPORT_TEXT;
    }

    /**
     * getting information about company's installed extensions
     *
     * @return array - installed extensions info
     */
    public function getInstalledExtensionsInfo()
    {
        $return = array();
        $modules = Mage::getConfig()->getNode('modules')->children();
        foreach ($modules as $module_name => $module_data) {
            if (strpos($module_name, $this->getExtensionPrefix()) !== 0) {
                continue;
            }

            if ($module_name == ($this->getExtensionPrefix() . $this->getMainExtensionName())) {
                continue;
            }

            $is_active = ((string)$module_data->active === 'true')? true: false;
            $version = $is_active ?(string)$module_data->version:'';
            $_t = explode('_', $module_name);
            $model_label = isset($_t[1])? $_t[1] : $module_name;
            $check_url = 'http://turnkeye.com/extension.html?name=' . $module_name . '&version=' . $version;
            if ($is_active && Mage::getConfig()->getNode('global/helpers/' . strtolower($module_name))) {
                $model_label = Mage::helper(strtolower($module_name))->getTranslatedExtensionName();
                $check_url = Mage::helper(strtolower($module_name))->getCheckUpdateUrl();
            }

            $return[$model_label] = array(
                'label'    => $model_label,
                'active'   => $is_active,
                'version'  => $version,
                'checkurl' => $check_url,
            );
        }

        asort($return);
        return $return;
    }

}
