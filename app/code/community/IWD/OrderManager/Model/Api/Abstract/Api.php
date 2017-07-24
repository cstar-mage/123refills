<?php

/**
 * Class IWD_OrderManager_Model_Api_Abstract_Api
 */
class IWD_OrderManager_Model_Api_Abstract_Api extends Mage_Api2_Model_Resource
{
    /**
     * @param $message
     * @param null $level
     * @param string $logFile
     * @param bool $forceLog
     */
    public function log($message, $level = null, $logFile = 'om_api.log', $forceLog = false)
    {
        Mage::log($message, $level, $logFile, $forceLog);
    }
}
