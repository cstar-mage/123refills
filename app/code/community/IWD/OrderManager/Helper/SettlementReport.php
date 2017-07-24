<?php

/**
 * Class IWD_OrderManager_Helper_SettlementReport
 */
class IWD_OrderManager_Helper_SettlementReport extends Mage_Core_Helper_Abstract
{
    /**
     * @param null $storeId
     * @return array
     */
    public function checkApiCredentials($storeId = null)
    {
        try {
            if (!$this->isSettlementReportEnabled($storeId)) {
                Mage::throwException('Settlement report is disabled');
            }

            $this->checkCredentials($storeId);
            $this->checkAuthorizeCredentials();
        } catch (\Exception $e) {
            return array('error' => 1, 'message' => $this->__($e->getMessage()));
        }

        return array('error' => 0, 'message' => $this->__('Connected successfully.'));
    }

    /**
     * @param null $storeId
     * @return bool
     */
    protected function isSettlementReportEnabled($storeId = null)
    {
        return (bool)Mage::getStoreConfig('iwd_settlementreport/connection/enabled', $storeId);
    }

    /**
     * @param $storeId
     */
    protected function checkCredentials($storeId)
    {
        $standardAuth = Mage::getStoreConfig('iwd_settlementreport/connection/standard', $storeId);
        if ($standardAuth) {
            $active = Mage::getStoreConfig('payment/authorizenet/active', $storeId);
            if (!$active) {
                Mage::throwException('Authorize.net payment method is disabled.');
            }
        } else {
            $login = Mage::getStoreConfig('iwd_settlementreport/connection/login', $storeId);
            $transKey = Mage::getStoreConfig('iwd_settlementreport/connection/trans_key', $storeId);

            if (!$login || !$transKey) {
                Mage::throwException('Enter API credentials and save to test.');
            }
        }
    }

    protected function checkAuthorizeCredentials()
    {
        $date = substr(date('c', time()), 0, -6);
        $details = Mage::getModel('iwd_ordermanager/authorize_authorizeNet')->getSettledBatchList(false, $date, $date);
        $result = (array)$details->xml->messages;

        if (!isset($result['resultCode']) || $result['resultCode'] == 'Error') {
            $message = (array)$result['message'];
            Mage::throwException($message["code"] . ": " . $message["text"]);
        }
    }
}
