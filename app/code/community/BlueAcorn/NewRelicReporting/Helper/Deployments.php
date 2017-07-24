<?php

/**
 * @package     BlueAcorn\Reporting
 * @version     1.1
 * @author      Magento, Inc. <eeadmin@magentocommerce.com>
 * @copyright   Copyright © 2014 Magento, Inc.
 */
class BlueAcorn_NewRelicReporting_Helper_Deployments
{

    /**
     * API URL for New Relic deployments
     */
    const API_URL = 'https://api.newrelic.com/deployments.xml';

    /**
     * Performs the request to make the deployment
     * @param string $description
     * @param bool $changelog
     * @param bool $user
     *
     * @return bool|string
     */
    public function setDeployment($description, $changelog = false, $user = false)
    {
        $apiUrl = Mage::helper('blueacorn_newrelicreporting/config')->getNewRelicApiUrl();

        if (empty($apiUrl)) {
            Mage::log('New Relic API URL is blank, using fallback URL');
            $apiUrl = self::API_URL;
        }

        $client = new Varien_Http_Client($apiUrl);
        $client->setMethod(Varien_Http_Client::POST);

        $client->setHeaders(array('x-api-key' => Mage::helper('blueacorn_newrelicreporting/config')->getNewRelicApiKey()));

        $params = array(
            'deployment[app_name]'       => Mage::helper('blueacorn_newrelicreporting/config')->getNewRelicAppName(),
            'deployment[application_id]' => Mage::helper('blueacorn_newrelicreporting/config')->getNewRelicAppId(),
            'deployment[description]'    => $description,
            'deployment[changelog]'      => $changelog,
            'deployment[user]'           => $user
        );

        $client->setParameterPost($params);

        try {
            $response = $client->request();
        } catch (Exception $e) {
            Mage::logException($e);
            return false;
        }
        if (($response->getStatus() < 200 || $response->getStatus() > 210)) {
            Mage::log('Deployment marker request did not send a 200 status code.');
            return false;
        }

        return true;
    }
}