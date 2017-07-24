<?php

/**
 * Class IWD_OrderManager_Model_Creditmemo
 */
class IWD_OrderManager_Model_Creditmemo extends Mage_Sales_Model_Order_Creditmemo
{
    const XML_PATH_SALES_ALLOW_DEL_CREDITMEMOS = 'iwd_ordermanager/iwd_delete_creditmemos/allow_del_creditmemos';
    const XML_PATH_SALES_STATUS_CREDITMEMO = 'iwd_ordermanager/iwd_delete_creditmemos/creditmemo_status';

    protected $allowDispatchAfterSave = true;

    /**
     * @return bool
     */
    public function isAllowDeleteCreditmemos()
    {
        $confAllowed = Mage::getStoreConfig(self::XML_PATH_SALES_ALLOW_DEL_CREDITMEMOS, Mage::app()->getStore());
        $permissionAllowed = Mage::getSingleton('admin/session')->isAllowed('iwd_ordermanager/creditmemo/actions/delete');
        $engine = Mage::helper('iwd_ordermanager')->CheckCreditmemoTableEngine();

        return ($confAllowed && $permissionAllowed && $engine);
    }

    /**
     * @return bool
     */
    public function isAllowCreateCreditmemo()
    {
        return true;
    }

    /**
     * @return array
     */
    public function getCreditmemoStatusesForDeleteIds()
    {
        return explode(',', Mage::getStoreConfig(self::XML_PATH_SALES_STATUS_CREDITMEMO));
    }

    /**
     * @return bool
     */
    public function checkCreditmemoStatusForDeleting()
    {
        return (in_array($this->getState(), $this->getCreditmemoStatusesForDeleteIds()));
    }

    /**
     * @return bool
     */
    public function canDelete()
    {
        return ($this->isAllowDeleteCreditmemos() && $this->checkCreditmemoStatusForDeleting());
    }

    /**
     * @return bool
     */
    public function deleteCreditmemo()
    {
        if (!$this->canDelete()) {
            $message = 'Maybe, you can not delete items with some statuses. Please, check <a href="'
                . Mage::helper("adminhtml")->getUrl("adminhtml/system_config/edit", array("section" => "iwd_ordermanager"))
                . '" target="_blank" title="System - Configuration - IWD Extensions - Order Manager">configuration</a> of IWD OrderManager';

            Mage::getSingleton('iwd_ordermanager/logger')->addNoticeMessage('check_credit_memo_status', $message);
            Mage::getSingleton('iwd_ordermanager/logger')->itemDeleteError('creditmemo', $this->getIncrementId());
            return false;
        }

        return $this->deleteCreditmemoWithoutCheck();
    }

    /**
     * @return bool
     */
    public function deleteCreditmemoWithoutCheck()
    {
        Mage::dispatchEvent('iwd_ordermanager_sales_creditmemo_delete_after', array('creditmemo' => $this, 'creditmemo_items' => $this->getItemsCollection()));
        $this->disallowDispatchAfterSave();

        if ($this->getState() != Mage_Sales_Model_Order::STATE_CANCELED) {
            $this->cancel()->save()->getOrder()->save();
        }

        $orderId = $this->getOrderId();
        $order = Mage::getModel('sales/order')->load($orderId);

        Mage::getSingleton('iwd_ordermanager/report')->addRefundedPeriod($this->getCreatedAt(), $this->getUpdatedAt(), $order->getCreatedAt());

        $creditmemoItems = $this->getItemsCollection();
        foreach ($creditmemoItems as $creditmemoItem) {
            $creditmemoItem->getProductId();
            $orderItems = Mage::getResourceModel('sales/order_item_collection')
                ->addFieldToFilter('order_id', $orderId)
                ->addFieldToFilter('product_id', $creditmemoItem->getProductId());

            /** @var $orderItem Mage_Sales_Model_Order_Item */
            foreach ($orderItems as $orderItem) {
                $amountRefunded        = $orderItem->getAmountRefunded() - $creditmemoItem->getRowTotal();
                $baseAmountRefunded   = $orderItem->getBaseAmountRefunded() - $creditmemoItem->getRowTotal();
                $taxRefunded           = $orderItem->getTaxRefunded() - $creditmemoItem->getTaxAmount();
                $baseTaxRefunded      = $orderItem->getBaseTaxRefunded() - $creditmemoItem->getBaseTaxAmount();
                $discountRefunded      = $orderItem->getDiscountRefunded() - $creditmemoItem->getDiscountAmount();
                $baseDiscountRefunded = $orderItem->getBaseDiscountRefunded() - $creditmemoItem->getBaseDiscountAmount();
                $hiddenTaxRefunded    = $orderItem->getHiddenTaxRefunded() - $creditmemoItem->getHiddenTaxAmount();
                $baseHiddenTaxRefunded = $orderItem->getBaseHiddenTaxRefunded() - $creditmemoItem->getBaseHiddenTaxAmount();


                if ($amountRefunded >= 0) {
                    $orderItem->setAmountRefunded($amountRefunded);
                }
                if ($baseAmountRefunded >= 0) {
                    $orderItem->setBaseAmountRefunded($baseAmountRefunded);
                }
                if ($taxRefunded >= 0) {
                    $orderItem->setTaxRefunded($taxRefunded);
                }
                if ($baseTaxRefunded >= 0) {
                    $orderItem->setBaseTaxRefunded($baseTaxRefunded);
                }
                if ($discountRefunded >= 0) {
                    $orderItem->setDiscountRefunded($discountRefunded);
                }
                if ($baseDiscountRefunded >= 0) {
                    $orderItem->setBaseDiscountRefunded($baseDiscountRefunded);
                }
                if ($hiddenTaxRefunded >= 0) {
                    $orderItem->setHiddenTaxRefunded($hiddenTaxRefunded);
                }
                if ($baseHiddenTaxRefunded >= 0) {
                    $orderItem->setBaseHiddenTaxRefunded($baseHiddenTaxRefunded);
                }

                $orderItem->save();
            }
        }

        if ($order->hasInvoices() && $order->hasShipments()){
            $state = Mage_Sales_Model_Order::STATE_COMPLETE;
        } else if ($order->hasInvoices()) {
            $state = Mage_Sales_Model_Order::STATE_PROCESSING;
        } else {
            $state = $order->getState();
        }

        $order->setData('state', $state);
        $order->setStatus($order->getConfig()->getStateDefaultStatus($state));

        $totalRefunded = $order->getTotalRefunded() - $this->getBaseGrandTotal();
        $baseTotalRefunded = $order->getTotalRefunded() - $this->getBaseGrandTotal();
        $order->setTotalRefunded($totalRefunded);
        $order->setBaseTotalRefunded($baseTotalRefunded);
        $order->save();

        Mage::getSingleton('iwd_ordermanager/logger')->itemDeleteSuccess('creditmemo', $this->getIncrementId());

        $items = $this->getItemsCollection();
        $obj = $this;

        Mage::register('isSecureArea', true);
        $this->delete();
        Mage::unregister('isSecureArea');

        Mage::dispatchEvent('iwd_ordermanager_sales_creditmemo_delete_before', array('creditmemo' => $obj, 'creditmemo_items' => $items));

        return true;
    }

    /**
     * @param $items
     */
    protected function updateOrderItems($items)
    {
        foreach ($items as $id => $amount) {
            /** @var $orderItem Mage_Sales_Model_Order_Item */
            $orderItem = Mage::getModel('sales/order_item')->load($id);

            if (isset($amount['row_total']) && $amount['row_total'] > 0) {
                $orderItem->setAmountRefunded($orderItem->getAmountRefunded() + $amount['row_total']);
            }
            if (isset($amount['base_row_total']) && $amount['base_row_total'] > 0) {
                $orderItem->setBaseAmountRefunded($orderItem->getBaseAmountRefunded() + $amount['base_row_total']);
            }
            if (isset($amount['tax_refunded']) && $amount['tax_refunded'] > 0) {
                $orderItem->setTaxRefunded($orderItem->getTaxRefunded() + $amount['tax_refunded']);
            }
            if (isset($amount['base_tax_amount']) && $amount['base_tax_amount'] > 0) {
                $orderItem->setBaseTaxRefunded($orderItem->getBaseTaxRefunded() + $amount['base_tax_amount']);
            }
            if (isset($amount['hidden_tax_amount']) && $amount['hidden_tax_amount'] > 0) {
                $orderItem->setHiddenTaxRefunded($orderItem->getHiddenTaxRefunded() + $amount['hidden_tax_amount']);
            }
            if (isset($amount['base_hidden_tax_amount']) && $amount['base_hidden_tax_amount'] > 0) {
                $orderItem->setBaseHiddenTaxRefunded($orderItem->getBaseHiddenTaxRefunded() + $amount['base_hidden_tax_amount']);
            }
            if (isset($amount['discount_amount']) && $amount['discount_amount'] > 0) {
                $orderItem->setDiscountRefunded($orderItem->getDiscountRefunded() + $amount['discount_amount']);
            }
            if (isset($amount['base_discount_amount']) && $amount['base_discount_amount'] > 0) {
                $orderItem->setBaseDiscountRefunded($orderItem->getBaseDiscountRefunded() + $amount['base_discount_amount']);
            }

            $orderItem->save();
        }
    }

    /**
     * After save object manipulations
     *
     * @return Mage_Sales_Model_Order_Creditmemo
     */
    protected function _afterSave()
    {
        if ($this->allowDispatchAfterSave) {
            return parent::_afterSave();
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function disallowDispatchAfterSave()
    {
        $this->allowDispatchAfterSave = false;
        return $this;
    }
}
