<?php

class IWD_OrderManager_Model_Transactions extends Mage_Core_Model_Abstract
{
    protected $collection = null;

    protected $methods = array(
        'authorizenet',            /* standard Authorize.net */
        'iwd_authorizecim',        /* IWD Authorize.net CIM */
        'iwd_authorizecim_echeck', /* IWD Authorize.net eCheck */
        //'authnetcim',            /* ParadoxLabs Authorize.net CIM */
        //'authnetcim_ach',        /* ParadoxLabs Authorize.net CIM */
    );

    public function _construct()
    {
        $this->_init('iwd_ordermanager/transactions');
    }

    public function refresh($forEmail = false)
    {
        $collection = $this->getCollectionForRefresh();

        /* add filter for reduce load time */
        $collection = $this->addPeriodFilter($collection, $forEmail);

        foreach ($collection as $mageTransaction) {
            $authTransaction = (array)$this->getTransactionDetails($mageTransaction->getNormalTxnId(), $mageTransaction->getStoreId());
            if (!empty($authTransaction)) {
                $this->saveTransactionData($authTransaction, $mageTransaction);
            }
        }

        Mage::getModel('core/flag', array('flag_code' => 'iwd_settlementreport_transactions'))->loadSelf()
            ->setState(0)
            ->save();
    }

    protected function getCollectionForRefresh()
    {
        $tableName_sales_flat_order_payment = Mage::getSingleton('core/resource')->getTableName('sales_flat_order_payment');
        $tableName_sales_flat_order = Mage::getSingleton('core/resource')->getTableName('sales_flat_order');

        $collection = Mage::getModel('sales/order_payment_transaction')->getCollection()
            ->addFieldToSelect(
                array(
                    'normal_txn_id' => new Zend_Db_Expr("SUBSTRING_INDEX(`main_table`.`txn_id`, '-', 1)"),
                    'created_at' => 'created_at',
                    'txn_type' => new Zend_Db_Expr('group_concat(DISTINCT `main_table`.`txn_type` SEPARATOR ",")'),
                    'order_id' => 'order_id',
                    'mage_amount' => 'amount'
                )
            );

        $collection->getSelect()->joinLeft($tableName_sales_flat_order_payment,
            "main_table.payment_id = {$tableName_sales_flat_order_payment}.entity_id",
            array(
                'mage_amount_captured' => 'base_amount_paid',
                'mage_amount_settlement' => 'base_amount_paid',
                'mage_amount_refunded' => 'base_amount_refunded',
                'mage_amount_authorized' => 'base_amount_authorized',
                'method' => 'method'
            )
        );

        $collection->addFieldToFilter('method', array('in' => $this->methods));

        $collection->getSelect()->joinLeft($tableName_sales_flat_order,
            "main_table.order_id = {$tableName_sales_flat_order}.entity_id",
            array(
                'store_id' => 'store_id',
                'order_increment_id' => 'increment_id'
            )
        );

        $collection->getSelect()->group("normal_txn_id");
        //echo $collection->getSelect(); die;

        return $collection;
    }

    protected function addPeriodFilter($collection, $forEmail)
    {
        $limitPeriod = Mage::getStoreConfig('iwd_settlementreport/default/limit_period');
        $lastDays = Mage::getStoreConfig('iwd_settlementreport/emailing/last_days');

        if (($forEmail && $lastDays != 0) || $limitPeriod) {
            $from = null;
            $to = null;

            if ($limitPeriod) {
                $filter_from = Mage::getSingleton('adminhtml/session')->getData("iwd_settlementreport_filter_from");
                $filter_to = Mage::getSingleton('adminhtml/session')->getData("iwd_settlementreport_filter_to");
                if (isset($filter_from) && isset($filter_to)) {
                    $from = DateTime::createFromFormat('m/d/Y', $filter_from)->modify('-1 day')->format('Y-m-d');
                    $to = DateTime::createFromFormat('m/d/Y', $filter_to)->modify('+1 day')->format('Y-m-d');
                }
            } elseif ($forEmail) {
                $from = new DateTime();
                $lastDays++;
                $from = $from->modify("-{$lastDays} day")->format('Y-m-d');

                $to = new DateTime();
                $to = $to->modify('+1 day')->format('Y-m-d');
            }

            if (isset($from) && isset($to) && !empty($from) && !empty($to)) {
                $from = Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s', $from);
                $to = Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s', $to);

                $collection->addFieldToFilter(
                    'main_table.created_at',
                    array('from' => $from, 'to' => $to, 'date' => true)
                );
            }
        }

        //echo $collection->getSelect(); die;
        return $collection;
    }

    protected function getPaymentTransactionByTxnId($txnId)
    {
        $collection = Mage::getModel('sales/order_payment_transaction')->getCollection()
            ->addFieldToFilter('txn_id', array("like" => "{$txnId}%"));

        $collection->getSelect()->order(new Zend_Db_Expr('`main_table`.`created_at` DESC'));

        if ($collection->getSize() > 0) {
            return $collection->getFirstItem();
        }

        return null;
    }

    protected function saveTransactionData($authTransaction, $mageTransaction)
    {
        if (!isset($authTransaction['transId'])) {
            return null;
        }

        $transId = $authTransaction['transId'];

        $iwdAuthPaymentTransaction = $this->loadTransactionByTransId($transId);

        if (isset($authTransaction['transactionType'])) {
            $iwdAuthPaymentTransaction->setData('transaction_type', $authTransaction['transactionType']);
        }

        $transactionStatus = null;

        if (isset($authTransaction['transactionStatus'])) {
            $transactionStatus = $authTransaction['transactionStatus'];
            $iwdAuthPaymentTransaction->setData('auth_transaction_status', $authTransaction['transactionStatus']);
        }

        $paymentTrans = $this->getPaymentTransactionByTxnId($transId);
        $txnType = (!empty($paymentTrans)) ? $paymentTrans->getTxnType() : $mageTransaction->getTxnType();
        $txnType = explode(',', $txnType);
        $txnType = array_pop($txnType);

        /* Reset */
        $iwdAuthPaymentTransaction->setData('mage_amount_authorized', NULL);
        $iwdAuthPaymentTransaction->setData('mage_amount_settlement', NULL);
        $iwdAuthPaymentTransaction->setData('mage_amount_captured', NULL);
        $iwdAuthPaymentTransaction->setData('mage_amount_refund', NULL);
        $iwdAuthPaymentTransaction->setData('auth_amount_authorized', NULL);
        $iwdAuthPaymentTransaction->setData('auth_amount_settlement', NULL);
        $iwdAuthPaymentTransaction->setData('auth_amount_captured', NULL);
        $iwdAuthPaymentTransaction->setData('auth_amount_refund', NULL);

        /* Voided */
        if ($transactionStatus == "voided" && $txnType != "void") {
            $iwdAuthPaymentTransaction->setData('mage_amount_authorized', $mageTransaction->getMageAmountAuthorized());
            $iwdAuthPaymentTransaction->setData('mage_amount_captured', $mageTransaction->getMageAmountCaptured());
        }


        /* Refunded */
        if (isset($authTransaction['authAmount']) && ($transactionStatus == 'refundPendingSettlement' || $transactionStatus == 'refundSettledSuccessfully')) {

            $authAmount = $authTransaction['authAmount'];

            $iwdAuthPaymentTransaction->setData('auth_amount_refund', $authAmount);
            if ($transactionStatus == 'refundSettledSuccessfully' && isset($authTransaction['settleAmount'])) {
                $iwdAuthPaymentTransaction->setData('auth_amount_settlement', $authTransaction['settleAmount']);
            }

            $creditMemos = Mage::getModel('sales/order_creditmemo')->getCollection()
                ->addFieldToSelect(
                    array(
                        "base_grand_total" => "base_grand_total",
                        "created_at" => "created_at",
                        "order_id" => "order_id"
                    )
                )
                ->addFieldToFilter('order_id', $mageTransaction->getOrderId());

            $mageAmountRefund = NULL;
            if ($creditMemos->getSize() == 1) {
                $mageAmountRefund = $creditMemos->getFirstItem()->getBaseGrandTotal();
            } else {
                /** by created at */
                $baseGrandTotal = array();

                $transaction_created_at = DateTime::createFromFormat('Y-m-d H:i:s', $mageTransaction->getCreatedAt());
                foreach ($creditMemos as $credit_memo) {
                    $credit_memo_created_at = DateTime::createFromFormat('Y-m-d H:i:s', $credit_memo->getCreatedAt());
                    $diff = $transaction_created_at->getTimestamp() - $credit_memo_created_at->getTimestamp();
                    if (abs($diff) < 30) {
                        $baseGrandTotal[] = $credit_memo->getBaseGrandTotal();
                    }
                }

                /** by total */
                if (count($baseGrandTotal) == 1) {
                    $mageAmountRefund = $baseGrandTotal[0];
                } elseif (count($baseGrandTotal) >= 2) {
                    if (in_array($authAmount, $baseGrandTotal)) {
                        $mageAmountRefund = $authAmount;
                    } else {
                        $mageAmountRefund = array_sum($baseGrandTotal);
                    }
                }
            }

            $amount = $mageTransaction->getMageAmount();
            $amount = !empty($amount) ? $amount : $mageAmountRefund;

            $iwdAuthPaymentTransaction->setData('mage_amount_refund', $amount);
            $iwdAuthPaymentTransaction->setData('mage_amount_settlement', $amount);
            $iwdAuthPaymentTransaction->setData('mage_amount_captured', NULL);
        }


        /* Authorized / Captured / Settled */
        if ($transactionStatus == 'authorizedPendingCapture' || $transactionStatus == 'settledSuccessfully' || $transactionStatus == 'capturedPendingSettlement') {
            $iwdAuthPaymentTransaction->setData('auth_amount_authorized', $authTransaction['authAmount']);

            if ($txnType == 'authorization') {
                $amount = $mageTransaction->getMageAmount();
                $amount = !empty($amount) ? $amount : $mageTransaction->getMageAmountAuthorized();
                $iwdAuthPaymentTransaction->setData('mage_amount_authorized', $amount);
            }

            if ($txnType == 'capture') {
                $amountCapture = Mage::getModel('sales/order_payment_transaction')->getCollection()
                    ->addFieldToFilter('parent_txn_id', $mageTransaction->getNormalTxnId())
                    ->addFieldToFilter('txn_type', 'capture')
                    ->getFirstItem()->getAmount();

                $amountCapture = !empty($amountCapture) ? $amountCapture : $mageTransaction->getMageAmountCaptured();
                if ($amountCapture != 0) {
                    $iwdAuthPaymentTransaction->setData('mage_amount_captured', $amountCapture);
                }

                $amount = Mage::getModel('sales/order_payment_transaction')->getCollection()
                    ->addFieldToFilter('txn_id', $mageTransaction->getNormalTxnId())
                    ->addFieldToFilter('txn_type', 'authorization')
                    ->getFirstItem()->getAmount();
                if ($amount != 0) {
                    $iwdAuthPaymentTransaction->setData('mage_amount_authorized', $amount);
                } else if ($amountCapture != 0) {
                    $iwdAuthPaymentTransaction->setData('mage_amount_authorized', $amountCapture);
                }
            }

            if ($transactionStatus == 'settledSuccessfully') {
                if (isset($authTransaction['settleAmount'])) {
                    $iwdAuthPaymentTransaction->setData('auth_amount_settlement', $authTransaction['settleAmount']);
                    $iwdAuthPaymentTransaction->setData('auth_amount_captured', $authTransaction['settleAmount']);
                }

                $amount = $mageTransaction->getMageAmount();
                $amount = !empty($amount) ? $amount : $mageTransaction->getMageAmountSettlement();
                if ($amount != 0) {
                    $iwdAuthPaymentTransaction->setData('mage_amount_settlement', $amount);
                }
            }

            if ($transactionStatus == 'capturedPendingSettlement') {
                if (isset($authTransaction['settleAmount'])) {
                    $iwdAuthPaymentTransaction->setData('auth_amount_captured', $authTransaction['settleAmount']);
                }
            }
        }

        $iwdAuthPaymentTransaction->setData('payment_transaction_id', $mageTransaction->getTransactionId());
        $iwdAuthPaymentTransaction->setData('transaction_id', $transId);
        $iwdAuthPaymentTransaction->setData('created_at', $mageTransaction->getCreatedAt());
        $iwdAuthPaymentTransaction->setData('order_id', $mageTransaction->getOrderId());
        $iwdAuthPaymentTransaction->setData('order_increment_id', $mageTransaction->getOrderIncrementId());

        $iwdAuthPaymentTransaction->setData('mage_transaction_status', $txnType);


        $iwdAuthPaymentTransaction->save();

        $this->updateStatus($iwdAuthPaymentTransaction);

        return $iwdAuthPaymentTransaction;
    }

    protected function updateStatus($iwdAuthPaymentTransaction)
    {
        $status = $this->checkAmountDifference($iwdAuthPaymentTransaction);

        if ($status == 1) {
            $status = $this->checkTransactionStatusDifference($iwdAuthPaymentTransaction) ? 1 : 0;
        }

        $iwdAuthPaymentTransaction->setData('status', $status)->save();
    }

    protected function checkAmountDifference($authTransaction)
    {
        if ($authTransaction->getData('auth_amount_authorized') != $authTransaction->getData('mage_amount_authorized') ||
            $authTransaction->getData('auth_amount_captured') != $authTransaction->getData('mage_amount_captured') ||
            $authTransaction->getData('auth_amount_settlement') != $authTransaction->getData('mage_amount_settlement') ||
            $authTransaction->getData('auth_amount_refund') != $authTransaction->getData('mage_amount_refund')
        ) {
            return 0;
        }

        return 1;
    }

    protected function checkTransactionStatusDifference($transaction)
    {
        $status = $transaction->getData('auth_transaction_status');

        switch ($transaction->getData('mage_transaction_status')) {
            case Mage_Sales_Model_Order_Payment_Transaction::TYPE_PAYMENT:
                return false;
            case Mage_Sales_Model_Order_Payment_Transaction::TYPE_ORDER:
                return ($status == "authorizedPendingCapture");
            case Mage_Sales_Model_Order_Payment_Transaction::TYPE_AUTH:
                return ($status == "authorizedPendingCapture");
            case Mage_Sales_Model_Order_Payment_Transaction::TYPE_CAPTURE:
                return ($status == "capturedPendingSettlement" || $status == "settledSuccessfully");
            case Mage_Sales_Model_Order_Payment_Transaction::TYPE_VOID:
                return ($status == "voided");
            case Mage_Sales_Model_Order_Payment_Transaction::TYPE_REFUND:
                return ($status == "refundSettledSuccessfully" || $status == "refundPendingSettlement");
        }

        return false;
    }

    public function loadTransactionByTransId($transId)
    {
        $authTransaction = Mage::getModel('iwd_ordermanager/transactions')->getCollection()
            ->addFieldToFilter('transaction_id', $transId);

        if ($authTransaction->getSize() > 0) {
            return $authTransaction->getFirstItem();
        }

        return Mage::getModel('iwd_ordermanager/transactions');
    }

    protected function getTransactionDetails($id, $store_id)
    {
        $details = Mage::getModel('iwd_ordermanager/authorize_authorizeNet')
            ->initConnection($store_id)
            ->getTransactionDetails($id);
        return (array)$details->xml->transaction;
    }

    public function getTransactionsCollection()
    {
        if (!empty($this->collection)) {
            return $this->collection;
        }

        $collection = $this->getCollection()
            ->addFieldToSelect(array(
                'auth_amount_captured' => 'auth_amount_captured',
                'auth_amount_settlement' => 'auth_amount_settlement',
                'auth_amount_refund' => 'auth_amount_refund',
                'auth_amount_authorized' => 'auth_amount_authorized',

                'mage_amount_captured' => 'mage_amount_captured',
                'mage_amount_settlement' => 'mage_amount_settlement',

                'mage_amount_refund' => 'mage_amount_refund',
                'mage_amount_authorized' => 'mage_amount_authorized',

                'transaction_type' => 'transaction_type',
                'auth_transaction_status' => 'auth_transaction_status',
                'mage_transaction_status' => 'mage_transaction_status',

                'status' => 'status',
                'payment_transaction_id' => 'payment_transaction_id',
                'transaction_id' => 'transaction_id',

                'order_id' => 'order_id',
                'order_increment_id' => 'order_increment_id',

                'created_at' => 'created_at',
            ));

        $this->collection = $collection;

        return $this->collection;
    }
}
