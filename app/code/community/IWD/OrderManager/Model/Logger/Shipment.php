<?php

class IWD_OrderManager_Model_Logger_Shipment extends IWD_OrderManager_Model_Logger
{
    /**
     * @var array
     */
    protected $orderParams = array(
        'shipping_increment_id' => "Changed shipping number from '%s' to '%s'",
        'shipping_created_at' => "Changed shipping date from '%s' to '%s'"
    );

    /**
     * @param $orderId
     * @param $shipmentId
     * @param bool|false $status
     * @param bool|false $isCustomerNotified
     */
    public function addCommentToHistory($orderId, $shipmentId, $status = false, $isCustomerNotified = false)
    {
        $this->addToLogOutputInfoAboutOrderChanges();
        if (empty($this->logOutput)) {
            return;
        }

        $this->addShipmentStatusHistoryComment($this->logOutput, $shipmentId, $status, $isCustomerNotified);
        Mage::getSingleton('iwd_ordermanager/logger')->addToLog($this->logOutput);
    }

    /**
     * @param $comment
     * @param $shipmentId
     * @param bool|false $status
     * @param bool|false $isCustomerNotified
     * @throws Exception
     */
    protected function addShipmentStatusHistoryComment($comment, $shipmentId, $status = false, $isCustomerNotified = false)
    {
        /**
         * @var Mage_Sales_Model_Order_Shipment $shipment
         */
        $shipment = Mage::getModel('sales/order_shipment')->load($shipmentId);

        if ($status === 'wait') {
            $comment .= "<i>" . Mage::helper('iwd_ordermanager')->__("Wait confirm...") . "</i>";
        }

        $shipment->addComment($comment, $isCustomerNotified)->save();
    }
}
