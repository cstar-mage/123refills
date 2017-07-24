<?php

class IBM_Builder_Model_APIManager extends Mage_Core_Model_Abstract
{
    // Should be modified dependent of API URL.
    const API_URL = 'http://ibmhosts.com/builderapi/public/get';

    const APPLICATION_KEY = '19e8a49458a522742ac792fdfd3a52a6';

    public function executeCommand($command, $option = NULL)
    {
        $url = self::API_URL . '/' . $command . '/' . self::APPLICATION_KEY;
        !is_null($option) && $url .= '/' . $option;
        
        $curlResult = $this->curlRequest($url);
        
        $result = array();
        
        if ($curlResult === false) {
            $result['error'] = true;
            $result['message'] = 'API connection error';
        } else {
            $result['data'] = json_decode($curlResult, true);
        }
        
        return $result;
    }

    private function curlRequest($url)
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_REFERER, $_SERVER['HTTP_HOST']);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }
}