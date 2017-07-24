<?php

class IWD_OrderManager_Model_Logger_Invoice extends IWD_OrderManager_Model_Logger
{
    /**
     * @var array
     */
    protected $orderParams = array(
        'invoice_increment_id' => "Changed invoice number from '%s' to '%s'",
        'invoice_created_at' => "Changed invoice date from '%s' to '%s'",
        'invoice_status' => "Changed invoice date status '%s' to '%s'"
    );

    /**
     * @param $orderId
     * @param $invoiceId
     * @param bool|false $status
     * @param bool|false $isCustomerNotified
     */
    public function addCommentToHistory($orderId, $invoiceId, $status = false, $isCustomerNotified = false)
    {
        $this->addToLogOutputInfoAboutOrderChanges();
        if (empty($this->logOutput)) {
            return;
        }

        $this->addInvoiceStatusHistoryComment($this->logOutput, $invoiceId, $status, $isCustomerNotified);
        Mage::getSingleton('iwd_ordermanager/logger')->addToLog($this->logOutput);
    }

    /**
     * @param $comment
     * @param $invoiceId
     * @param bool|false $status
     * @param bool|false $isCustomerNotified
     * @throws Exception
     */
    protected function addInvoiceStatusHistoryComment($comment, $invoiceId, $status = false, $isCustomerNotified = false)
    {
        /**
         * @var Mage_Sales_Model_Order_Invoice $invoice
         */
        $invoice = Mage::getModel('sales/order_invoice')->load($invoiceId);

        if ($status === 'wait') {
            $comment .= "<i>" . Mage::helper('iwd_ordermanager')->__("Wait confirm...") . "</i>";
        }

        $invoice->addComment($comment, $isCustomerNotified)->save();
    }
}
