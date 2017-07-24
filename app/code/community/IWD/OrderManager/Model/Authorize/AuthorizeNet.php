<?php

/**
 * Class IWD_OrderManager_Model_Authorize_AuthorizeNet
 */
class IWD_OrderManager_Model_Authorize_AuthorizeNet extends Mage_Core_Model_Abstract
{
    protected $_api_login;
    protected $_transaction_key;
    protected $_post_string;
    protected $_sandbox = true;

    const LIVE_URL = "https://api.authorize.net/xml/v1/request.api";
    const SANDBOX_URL = "https://apitest.authorize.net/xml/v1/request.api";

    private $_xml;

    public function _construct()
    {
        parent::_construct();
        $this->initConnection();
    }

    public function initConnection($store = null)
    {
        $standard_auth = Mage::getStoreConfig('iwd_settlementreport/connection/standard', $store);

        if ($standard_auth) {
            $this->_api_login = Mage::getStoreConfig('payment/authorizenet/login', $store);
            $this->_transaction_key = Mage::getStoreConfig('payment/authorizenet/trans_key', $store);
            $this->_sandbox = Mage::getStoreConfig('payment/authorizenet/test', $store);
        } else {
            $login = Mage::getStoreConfig('iwd_settlementreport/connection/login', $store);
            $trans_key = Mage::getStoreConfig('iwd_settlementreport/connection/trans_key', $store);
            $this->_api_login = Mage::helper('core')->decrypt($login);
            $this->_transaction_key = Mage::helper('core')->decrypt($trans_key);
            $this->_sandbox = Mage::getStoreConfig('iwd_settlementreport/connection/test', $store);
        }

        return $this;
    }

    public function getPostString()
    {
        return $this->_post_string;
    }

    protected function _sendRequest()
    {
        $this->_setPostString();
        $postUrl = $this->_getPostUrl();
        $curlRequest = curl_init($postUrl);
        curl_setopt($curlRequest, CURLOPT_POSTFIELDS, $this->_post_string);
        curl_setopt($curlRequest, CURLOPT_HEADER, 0);
        curl_setopt($curlRequest, CURLOPT_TIMEOUT, 45);
        curl_setopt($curlRequest, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlRequest, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curlRequest, CURLOPT_SSL_VERIFYPEER, false);

        if (preg_match('/xml/', $postUrl)) {
            curl_setopt($curlRequest, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
        }

        $response = curl_exec($curlRequest);

        curl_close($curlRequest);

        return $this->_handleResponse($response);
    }

    /**
     * @param bool $includeStatistics
     * @param bool $firstSettlementDate
     * @param bool $lastSettlementDate
     * @param bool $utc
     * @return IWD_OrderManager_Model_Authorize_Response
     */
    public function getSettledBatchList(
        $includeStatistics = false,
        $firstSettlementDate = false,
        $lastSettlementDate = false,
        $utc = true
    ) {
        $utc = ($utc ? "Z" : "");
        $this->_constructXml("getSettledBatchListRequest");
        ($includeStatistics ?
            $this->_xml->addChild("includeStatistics", $includeStatistics) : null);
        ($firstSettlementDate ?
            $this->_xml->addChild("firstSettlementDate", $firstSettlementDate . $utc) : null);
        ($lastSettlementDate ?
            $this->_xml->addChild("lastSettlementDate", $lastSettlementDate . $utc) : null);

        return $this->_sendRequest();
    }

    /**
     * @param bool $month
     * @param bool $year
     * @return IWD_OrderManager_Model_Authorize_Response
     */
    public function getSettledBatchListForMonth($month = false, $year = false)
    {
        $month = ($month ? $month : date('m'));
        $year = ($year ? $year : date('Y'));
        $firstSettlementDate = substr(date('c', mktime(0, 0, 0, $month, 1, $year)), 0, -6);
        $lastSettlementDate = substr(date('c', mktime(0, 0, 0, $month + 1, 0, $year)), 0, -6);

        return $this->getSettledBatchList(true, $firstSettlementDate, $lastSettlementDate);
    }

    public function getTransactionList($batchId)
    {
        $this->_constructXml("getTransactionListRequest");
        $this->_xml->addChild("batchId", $batchId);
        return $this->_sendRequest();
    }

    public function getTransactionsForDay($month = false, $day = false, $year = false)
    {
        $transactions = array();
        $month = ($month ? $month : date('m'));
        $day = ($day ? $day : date('d'));
        $year = ($year ? $year : date('Y'));
        $firstSettlementDate = substr(date('c', mktime(0, 0, 0, (int)$month, (int)$day, (int)$year)), 0, -6);
        $lastSettlementDate = substr(date('c', mktime(0, 0, 0, (int)$month, (int)$day, (int)$year)), 0, -6);
        $response = $this->getSettledBatchList(true, $firstSettlementDate, $lastSettlementDate);
        $batches = $response->xpath("batchList/batch");
        foreach ($batches as $batch) {
            $batch_id = (string)$batch->batchId;
            $request = new AuthorizeNetTD;
            $tran_list = $request->getTransactionList($batch_id);
            $transactions = array_merge($transactions, $tran_list->xpath("transactions/transaction"));
        }

        return $transactions;
    }

    public function getTransactionDetails($transId)
    {
        $this->_constructXml("getTransactionDetailsRequest");
        $this->_xml->addChild("transId", $transId);
        return $this->_sendRequest();
    }

    public function getBatchStatistics($batchId)
    {
        $this->_constructXml("getBatchStatisticsRequest");
        $this->_xml->addChild("batchId", $batchId);
        return $this->_sendRequest();
    }

    public function getUnsettledTransactionList()
    {
        $this->_constructXml("getUnsettledTransactionListRequest");
        return $this->_sendRequest();
    }

    protected function _getPostUrl()
    {
        return ($this->_sandbox ? self::SANDBOX_URL : self::LIVE_URL);
    }

    protected function _handleResponse($response)
    {
        return new IWD_OrderManager_Model_Authorize_Response($response);
    }

    protected function _setPostString()
    {
        $this->_post_string = $this->_xml->asXML();
    }

    /**
     * @param $requestType
     */
    private function _constructXml($requestType)
    {
        $string = '<?xml version="1.0" encoding="utf-8"?><' . $requestType . '></' . $requestType . '>';

        $this->_xml = @new SimpleXMLElement($string);
        $this->_xml->addAttribute('xmlns', 'AnetApi/xml/v1/schema/AnetApiSchema.xsd');

        $merchant = $this->_xml->addChild('merchantAuthentication');
        $merchant->addChild('name', $this->_api_login);
        $merchant->addChild('transactionKey', $this->_transaction_key);
    }
}
