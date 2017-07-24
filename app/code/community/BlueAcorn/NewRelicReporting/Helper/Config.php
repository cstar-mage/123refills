<?php

/**
 * @package     BlueAcorn\Reporting
 * @version     1.1
 * @author      Magento, Inc. <eeadmin@magentocommerce.com>
 * @copyright   Copyright © 2014 Magento, Inc.
 */
class BlueAcorn_NewRelicReporting_Helper_Config extends Mage_Core_Helper_Abstract
{
    /**
     * Returns module's enabled status
     *
     * @return bool
     */
    public function isNewRelicEnabled()
    {
        return Mage::getStoreConfigFlag('blueacorn_newrelicreporting/general/enable');
    }

    /**
     * Returns configured account ID for New Relic
     *
     * @return string
     */
    public function getNewRelicAccountId()
    {
        return (string)Mage::getStoreConfig('blueacorn_newrelicreporting/general/account_id');
    }

    /**
     * Returns configured URL for Insights API
     *
     * @return string
     */

    public function getInsightsApiUrl()
    {
        return (string)Mage::getStoreConfig('blueacorn_newrelicreporting/general/insights_api_url');
    }



    /**
     * Returns configured URL for API
     *
     * @return string
     */
    public function getNewRelicApiUrl()
    {
        return (string)Mage::getStoreConfig('blueacorn_newrelicreporting/general/api_url');
    }

    /**
     * Return configured NR Application ID
     *
     * @return string
     */
    public function getNewRelicAppId()
    {
        return (int)Mage::getStoreConfig('blueacorn_newrelicreporting/general/app_id');
    }

    /**
     * Returns configured NR Application name
     *
     * @return string
     */
    public function getNewRelicAppName()
    {
        return (string)Mage::getStoreConfig('blueacorn_newrelicreporting/general/app_name');
    }

    /**
     * Returns config setting for overall cron to be enabled
     *
     * @return bool
     */
    public function isCronEnabled()
    {
        return (bool)Mage::getConfig('blueacorn_newrelicreporting/cron/enable_cron');
    }

    /**
     * Returns configured event key for New Relic events related to cron jobs
     * AKA Insights API key
     *
     * @return string
     */
    public function getCronEventKey()
    {
        $value = (string)Mage::getStoreConfig('blueacorn_newrelicreporting/general/cron_event_key');
        return Mage::helper('core')->decrypt($value);
    }


    /**
     * Returns configured API key for APM
     *
     * @return string
     */
    public function getNewRelicApiKey()
    {
        $value = (string)Mage::getStoreConfig('blueacorn_newrelicreporting/general/api');
        return Mage::helper('core')->decrypt($value);
    }

}