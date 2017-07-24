<?php

/**
 * Class IWD_OrderManager_Model_Logger_Creditmemo
 */
class IWD_OrderManager_Model_Logger_Creditmemo extends IWD_OrderManager_Model_Logger
{
    /**
     * @var array
     */
    protected $orderParams = array(
        'creditmemo_increment_id' => "Changed creditmemo number from '%s' to '%s'",
        'creditmemo_created_at' => "Changed creditmemo date from '%s' to '%s'",
        'creditmemo_status' => "Changed creditmemo status from '%s' to '%s'"
    );

    /**
     * @param $orderId
     * @param $creditmemoId
     * @param bool|false $status
     * @param bool|false $isCustomerNotified
     */
    public function addCommentToHistory($orderId, $creditmemoId, $status = false, $isCustomerNotified = false)
    {
        $this->addToLogOutputInfoAboutOrderChanges();
        if (empty($this->logOutput)) {
            return;
        }

        $this->addCreditmemoStatusHistoryComment($this->logOutput, $creditmemoId, $status, $isCustomerNotified);
        Mage::getSingleton('iwd_ordermanager/logger')->addToLog($this->logOutput);
    }

    /**
     * @param $comment
     * @param $creditmemoId
     * @param bool|false $status
     * @param bool|false $isCustomerNotified
     * @throws Exception
     */
    protected function addCreditmemoStatusHistoryComment($comment, $creditmemoId, $status = false, $isCustomerNotified = false)
    {
        /**
         * @var IWD_OrderManager_Model_Creditmemo $creditmemo
         */
        $creditmemo = Mage::getModel('iwd_ordermanager/creditmemo')->load($creditmemoId);

        if ($status === 'wait') {
            $comment .= "<i>" . Mage::helper('iwd_ordermanager')->__("Wait confirm...") . "</i>";
        }

        $creditmemo->disallowDispatchAfterSave()->addComment($comment, $isCustomerNotified)->save();
    }
}
