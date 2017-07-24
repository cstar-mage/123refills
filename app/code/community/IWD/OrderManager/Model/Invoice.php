<?php

class IWD_OrderManager_Model_Invoice extends Mage_Sales_Model_Order_Invoice
{
    const XML_PATH_SALES_ALLOW_DEL_INVOICES = 'iwd_ordermanager/iwd_delete_invoices/allow_del_invoices';
    const XML_PATH_SALES_ALLOW_DEL_RELATED_CREDITMEMOS = 'iwd_ordermanager/iwd_delete_invoices/allow_del_related_cm_for_invoices';
    const XML_PATH_SALES_STATUS_INVOICE = 'iwd_ordermanager/iwd_delete_invoices/invoice_status';
    const XML_PATH_SALES_CREATE_INVOICE = 'iwd_ordermanager/edit/create_invoice';

    public function isAllowDeleteInvoices()
    {
        $confAllowed = Mage::getStoreConfig(self::XML_PATH_SALES_ALLOW_DEL_INVOICES, Mage::app()->getStore());
        $permissionAllowed = Mage::getSingleton('admin/session')->isAllowed('iwd_ordermanager/invoice/actions/delete');
        $engine = Mage::helper('iwd_ordermanager')->CheckInvoiceTableEngine();
        return ($confAllowed && $permissionAllowed && $engine);
    }

    public function getInvoiceStatusesForDeleteIds()
    {
        return explode(',', Mage::getStoreConfig(self::XML_PATH_SALES_STATUS_INVOICE));
    }

    public function checkInvoiceStatusForDeleting()
    {
        return (in_array($this->getState(), $this->getInvoiceStatusesForDeleteIds()));
    }

    public function canDelete()
    {
        return ($this->isAllowDeleteInvoices() && $this->checkInvoiceStatusForDeleting());
    }

    public function allowDeleteRelatedCreditMemo()
    {
        return Mage::getStoreConfig(self::XML_PATH_SALES_ALLOW_DEL_RELATED_CREDITMEMOS);
    }

    public function DeleteInvoice()
    {
        $incrementId = $this->getIncrementId();

        if (!$this->canDelete()) {
            $message = 'Maybe, you can not delete items with some statuses. Please, check <a href="'
                . Mage::helper("adminhtml")->getUrl("adminhtml/system_config/edit", array("section" => "iwd_ordermanager"))
                . '" target="_blank" title="System - Configuration - IWD Extensions - Order Manager">configuration</a> of IWD OrderManager';

            Mage::getSingleton('iwd_ordermanager/logger')->addNoticeMessage('check_invoice_status', $message);
            Mage::getSingleton('iwd_ordermanager/logger')->itemDeleteError('invoice', $incrementId);
            return false;
        }

        Mage::dispatchEvent('iwd_ordermanager_sales_invoice_delete_after', array('invoice' => $this, 'invoice_items' => $this->getItemsCollection()));

        $order = Mage::getModel('sales/order')->load($this->getOrderId());

        Mage::getSingleton('iwd_ordermanager/report')
            ->addInvoicedPeriod($this->getCreatedAt(), $this->getUpdatedAt(), $order->getCreatedAt());

        if ($order->hasCreditmemos()) {
            if (!$this->allowDeleteRelatedCreditMemo()) {
                Mage::getSingleton('iwd_ordermanager/logger')->itemDeleteError('invoice', $incrementId);

                $message = 'Invoice has related credit memo(s). You must delete all related credit memo(s) after deleting invoice. Please, check <a href="'
                    . Mage::helper("adminhtml")->getUrl("adminhtml/system_config/edit", array("section" => "iwd_ordermanager"))
                    . '" target="_blank" title="System - Configuration - IWD Extensions - Order Manager - Delete Invoice">configuration</a> of IWD OrderManager';

                Mage::getSingleton('iwd_ordermanager/logger')->addNoticeMessage('related_credit_memo', $message);

                return false;
            }

            $credit_memos = $order->getCreditmemosCollection();
            $creditmemo_deleted = true;
            foreach ($credit_memos as $credit_memo) {
                $creditmemo_deleted = Mage::getModel('iwd_ordermanager/creditmemo')
                    ->load($credit_memo->getEntityId())
                    ->deleteCreditmemo();
            }

            if (!$creditmemo_deleted) {
                Mage::getSingleton('iwd_ordermanager/logger')->itemDeleteError('invoice', $incrementId);
                return false;
            }
        }

        if (!$this->isCanceled()) {
            $this->cancel()->save()->getOrder()->save();
        }

        Mage::getSingleton('iwd_ordermanager/logger')->itemDeleteSuccess('invoice', $incrementId);

        $items = $this->getItemsCollection();
        $obj = $this;

        Mage::register('isSecureArea', true);
        $this->deleteFromGrid();
        $this->delete();
        Mage::unregister('isSecureArea');

        Mage::dispatchEvent('iwd_ordermanager_sales_invoice_delete_before', array('invoice' => $obj, 'invoice_items' => $items));

        return $incrementId;
    }

    public function deleteFromGrid()
    {
        try {
            $resource = Mage::getSingleton('core/resource');
            $readConnection = $resource->getConnection('core_read');
            $query = 'DELETE FROM `' . $resource->getTableName('sales_flat_invoice_grid') . '` WHERE `' . Mage::getSingleton('core/resource')->getTableName('sales_flat_invoice_grid') . '`.`entity_id` = ' . $this->getEntityId();
            $readConnection->fetchAll($query);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    public function createInvoice($orderId, $qtys = array(), $baseShippingAmount = 0, $baseShippingInclTax = 0)
    {
        $order = Mage::getModel("sales/order")->load($orderId);

        if (!$order->getId()) {
            Mage::throwException(Mage::helper('core')->__('Order not exists'));
        }

        $invoice = Mage::getModel('sales/service_order', $order)->prepareInvoice($qtys);

        if ($baseShippingAmount > 0) {

            $baseShippingTaxAmount = $baseShippingInclTax - $baseShippingAmount;

            $baseCurrencyCode = $order->getBaseCurrencyCode();
            $orderCurrencyCode = $order->getOrderCurrencyCode();
            $directory = Mage::helper('directory');
            if ($baseCurrencyCode === $orderCurrencyCode) {
                $shippingAmount = $baseShippingAmount;
                $shippingInclTax = $baseShippingInclTax;
                $shippingTaxAmount = $baseShippingTaxAmount;
            } else {
                $shippingAmount = $directory->currencyConvert($baseShippingAmount, $baseCurrencyCode, $orderCurrencyCode);
                $shippingInclTax = $directory->currencyConvert($baseShippingInclTax, $baseCurrencyCode, $orderCurrencyCode);
                $shippingTaxAmount = $directory->currencyConvert($baseShippingTaxAmount, $baseCurrencyCode, $orderCurrencyCode);
            }

            $invoice->setShippingTaxAmount($shippingTaxAmount);
            $invoice->setBaseShippingTaxAmount($baseShippingTaxAmount);

            $invoice->setShippingAmount($shippingAmount);
            $invoice->setBaseShippingAmount($baseShippingAmount);

            $invoice->setShippingInclTax($shippingInclTax);
            $invoice->setBaseShippingInclTax($baseShippingInclTax);

            $invoice->setGrandTotal($order->getGrandTotal());
            $invoice->setBaseGrandTotal($order->getBaseGrandTotal());
        }

        if (!$invoice->getTotalQty()) {
            Mage::throwException(Mage::helper('core')->__('Cannot create an invoice without products.'));
        }

        $invoice->setRequestedCaptureCase(Mage_Sales_Model_Order_Invoice::CAPTURE_OFFLINE);

        $invoice->register();

        $order->getPayment()->setBaseAmountPaid($invoice->getBaseGrandTotal())->setAmountPaid($invoice->getGrandTotal())->save();
        $order->setBaseAmountPaid($invoice->getBaseGrandTotal())->setAmountPaid($invoice->getGrandTotal())->save();

        Mage::getModel('core/resource_transaction')
            ->addObject($invoice)
            ->addObject($order)
            ->save();
    }

    public function updateInvoice($order)
    {
        $orderId = $order->getEntityId();
        $qtys = array();
        $shippingAmount = $order->getBaseShippingAmount();
        $shippingInclTax = $order->getBaseShippingInclTax();

        $this->cancelInvoices($order);

        $this->createInvoice($orderId, $qtys, $shippingAmount, $shippingInclTax);

        return true;
    }

    public function cancelInvoices($order)
    {
        $deleted = false;
        if ($order->hasInvoices()) {
            foreach ($order->getInvoiceCollection() as $invoice) {
                if ($invoice->isCanceled()) {
                    continue;
                }
                $invoice->cancel()->save()->getOrder()->save();
                Mage::register('isSecureArea', true);
                $invoice->delete();
                Mage::unregister('isSecureArea');
                $deleted = true;
            }
        }

        return $deleted;
    }
}
