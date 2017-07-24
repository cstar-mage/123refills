<?php

/**
 * @package     BlueAcorn\Reporting
 * @version     1.1
 * @author      Magento, Inc. <eeadmin@magentocommerce.com>
 * @copyright   Copyright © 2014 Magento, Inc.
 */
class BlueAcorn_NewRelicReporting_Helper_CronEvent
{
    /**
     * @var Zend_Http_Client
     */
    protected $_request;

    /**
     * URL for Insights API, generated via method getEventsUrl
     * @var string
     */
    protected $_eventsUrl = '';

    /**
     * Parameters to be sent to New Relic for a job run
     * @var array
     */
    protected $_customParameters = array();

    /**
     * @return string
     * @throws Mage_Core_Exception
     */
    protected function getEventsUrl()
    {
        if (empty($this->eventsUrl)) {
            $accountId = Mage::helper('blueacorn_newrelicreporting/config')->getNewRelicAccountId();
            if (empty($accountId)) {
                throw new Mage_Core_Exception(
                    'No New Relic Application ID configured, cannot continue with Cron Event reporting'
                );
            }
            $this->_eventsUrl = sprintf(
                Mage::helper('blueacorn_newrelicreporting/config')->getInsightsApiUrl(),
                $accountId
            );
        }
        return $this->_eventsUrl;
    }

    /**
     * @return Zend_Http_Client
     */
    protected function _getRequest()
    {
        if (!isset($this->_request)) {
            $this->_request = new Varien_Http_Client($this->getEventsUrl());
            $insertKey = Mage::helper('blueacorn_newrelicreporting/config')->getCronEventKey();

            $this->_request->setMethod(Varien_Http_Client::POST);
            $this->_request->setHeaders(
                array(
                    'X-Insert-Key' => $insertKey,
                    'Content-Type' => 'application/json'
                )
            );
        }
        return $this->_request;
    }

    /**
     * Add custom parameters to send with API request
     *
     * @param $data
     *
     * @return $this
     */
    public function addData($data)
    {
        $this->_customParameters = array_merge($this->_customParameters, $data);
        return $this;
    }

    /**
     * Returns all set custom parameters as JSON string
     *
     * @return string
     */
    protected function getJsonForResponse()
    {
        $json = array(
            'eventType' => 'Cron',
            'appName'   => Mage::helper('blueacorn_newrelicreporting/config')->getNewRelicAppName(),
            'appId'     => Mage::helper('blueacorn_newrelicreporting/config')->getNewRelicAppId(),
        );

        foreach ($json as $key => $value) {
            if (array_key_exists($key, $this->_customParameters)) {
                unset($this->_customParameters[$key]);
            }
        }

        $json = array_merge($json, $this->_customParameters);

        return Mage::helper('core')->jsonEncode($json);
    }

    /**
     * Instantiates request if necessary and sends off with collected data
     *
     * @return bool
     */
    public function sendRequest()
    {
        $response = $this->_getRequest()
            ->setRawData($this->getJsonForResponse())
            ->request();

        if ($response->getStatus() >= 200 && $response->getStatus() < 300) {
            return true;
        }
        return false;
    }
}