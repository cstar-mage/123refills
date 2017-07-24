<?php

class IWD_OrderManager_Model_Observer_Settlementreport
{

    public function emailReports()
    {
        try {
            if (Mage::getStoreConfig('iwd_settlementreport/emailing/enable')) {
                $request = Mage::helper('iwd_ordermanager/settlementReport')->checkApiCredentials();
                if (isset($request['error']) && $request['error'] == 0) {
                    Mage::getModel("iwd_ordermanager/transactions")->refresh(true);
                    Mage::getModel('iwd_ordermanager/email_report')->sendEmail();
                } else {
                    Mage::log("Auto-email report: " . $request['message'], null, "iwd_settlementreport.log");
                }
            }
        } catch (Exception $e) {
            Mage::log($e->getMessage(), null, "iwd_settlementreport.log");
        }
    }

    public function updateTransactionAmount($observer)
    {
        try {
            $data = $observer->getEvent()->getData('data_object')->getData();

            if (!isset($data['transaction_id'])) {
                return;
            }

            $id = $data['transaction_id'];

            if (isset($data['additional_information']) && isset($data['additional_information']['amount'])) {
                $amount = $data['additional_information']['amount'];
            } else if (isset($data['message'])) {
                $matches = array();
                preg_match('/[0-9]+[.,][0-9]+/', $data['message'], $matches);
                $amount = isset($matches[0]) ? $matches[0] : "NULL";
            } else if (isset($data['amount'])) {
                $amount = $data['amount'];
            } else {
                $amount = 0;
            }

            $resource = Mage::getSingleton('core/resource');
            $writeConnection = $resource->getConnection('core_write');
            $table = $resource->getTableName('sales_payment_transaction');

            $query = "UPDATE {$table} SET `amount` = '{$amount}' WHERE `transaction_id` = '{$id}'";
            $writeConnection->query($query);

        } catch (Exception $e) {
            Mage::log($e->getMessage(), null, 'iwd_settlementreport.log');
        }
    }
}
