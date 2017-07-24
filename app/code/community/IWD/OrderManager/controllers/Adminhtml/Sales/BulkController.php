<?php

/**
 * Class IWD_OrderManager_Adminhtml_Sales_BulkController
 */
class IWD_OrderManager_Adminhtml_Sales_BulkController extends Mage_Adminhtml_Controller_Action
{
    /**
     * @var null|Mage_Sales_Model_Order_Pdf_Invoice
     */
    protected $pdf = null;

    /**
     * @var null|Mage_Sales_Model_Order
     */
    protected $order = null;

    /**
     * @return $this|Mage_Core_Controller_Varien_Action
     */
    public function resentInvoiceAction()
    {
        $orderIds = $this->getOrderIds();
        foreach ($orderIds as $orderId) {
            $this->order = Mage::getModel('sales/order')->load($orderId);
            $invoices = $this->order->getInvoiceCollection();
            foreach ($invoices as $invoice) {
                $this->sendEmailWithInvoice($invoice);
            }
        }

        return $this->_redirect('*/sales_order/');
    }

    /**
     * @param $invoice Mage_Sales_Model_Order_Invoice
     */
    protected function sendEmailWithInvoice($invoice)
    {
        try {
            if ($invoice) {
                $invoice->sendEmail();
                $historyItem = Mage::getResourceModel('sales/order_status_history_collection')
                    ->getUnnotifiedForInstance($invoice, Mage_Sales_Model_Order_Invoice::HISTORY_ENTITY_NAME);
                if ($historyItem) {
                    $historyItem->setIsCustomerNotified(1);
                    $historyItem->save();
                }

                $id = $invoice->getId();
                $this->_getSession()->addSuccess(
                    $this->__(
                        'The invoice <a href="%s" target="_blank" title="Go to invoice">#%s</a> has been sent.',
                        Mage::helper('adminhtml')->getUrl('*/sales_invoice/view', array('invoice_id' => $id)),
                        $invoice->getIncrementId()
                    )
                );
            }
        } catch (Mage_Core_Exception $e) {
            $this->addErrorInvoiceMessage($invoice, $e->getMessage());
        } catch (Exception $e) {
            $this->addErrorInvoiceMessage($invoice, 'Cannot send invoice information.');
        }
    }

    /**
     * @return $this|Mage_Core_Controller_Varien_Action
     */
    public function resentShipmentAction()
    {
        $orderIds = $this->getOrderIds();
        foreach ($orderIds as $orderId) {
            $this->order = Mage::getModel('sales/order')->load($orderId);
            $shipments = $this->order->getShipmentsCollection();
            foreach ($shipments as $shipment) {
                $this->sendEmailWithShipment($shipment);
            }
        }

        return $this->_redirect('*/sales_order/');
    }

    /**
     * @param $shipment Mage_Sales_Model_Order_Shipment
     */
    public function sendEmailWithShipment($shipment)
    {
        try {
            if ($shipment) {
                $shipment->sendEmail(true)
                    ->setEmailSent(true)
                    ->save();
                $historyItem = Mage::getResourceModel('sales/order_status_history_collection')
                    ->getUnnotifiedForInstance($shipment, Mage_Sales_Model_Order_Shipment::HISTORY_ENTITY_NAME);
                if ($historyItem) {
                    $historyItem->setIsCustomerNotified(1);
                    $historyItem->save();
                }

                $id = $shipment->getId();
                $this->_getSession()->addSuccess(
                    $this->__(
                        'The shipment <a href="%s" target="_blank" title="Go to shipment">#%s</a> has been sent.',
                        Mage::helper('adminhtml')->getUrl('*/sales_shipment/view', array('shipment_id' => $id)),
                        $shipment->getIncrementId()
                    )
                );
            }
        } catch (Mage_Core_Exception $e) {
            $this->addErrorShipmentMessage($shipment, $e->getMessage());
        } catch (Exception $e) {
            $this->addErrorShipmentMessage($shipment, 'Cannot send shipment information.');
        }
    }

    public function createAction()
    {
        $orderIds = $this->getOrderIds();
        foreach ($orderIds as $orderId) {
            $this->order = Mage::getModel('sales/order')->load($orderId);
            $this->createInvoice();
            $this->createShipment();
        }

        if ($this->getIsPrint()) {
            $this->_getSession()->setData(
                'iwd_bulk_actions',
                array(
                    'invoice' => $this->getIsInvoice(),
                    'shipment' => $this->getIsShipment(),
                    'print' => 1, 'order_ids' => $orderIds)
            );
        }

        return $this->_redirect('*/sales_order/');
    }

    public function printAction()
    {
        $orderIds = $this->getOrderIds();
        foreach ($orderIds as $orderId) {
            $this->order = Mage::getModel('sales/order')->load($orderId);
            $this->printInvoice();
            $this->printShipment();
        }

        return $this->printPdf();
    }

    /**
     * @return array
     */
    protected function getOrderIds()
    {
        return $this->getRequest()->getParam('order_ids', array());
    }

    /**
     * @return bool
     */
    protected function createInvoice()
    {
        if (!$this->getIsInvoice()) {
            return true;
        }

        try {
            if ($this->order->getBaseTotalDue() == 0) {
                return true;
            }

            if (!$this->order->canInvoice()) {
                $this->addErrorOrderMessage('Does not allow creating an invoice.');
                return false;
            }

            /**
             * @var $invoice Mage_Sales_Model_Order_Invoice
             */
            $invoice = Mage::getModel('sales/service_order', $this->order)->prepareInvoice();
            if (!$invoice->getTotalQty()) {
                $this->addErrorOrderMessage('Cannot create an invoice without products.');
                return false;
            }

            Mage::unregister('current_invoice');
            Mage::register('current_invoice', $invoice);

            $invoice->setRequestedCaptureCase(Mage_Sales_Model_Order_Invoice::CAPTURE_ONLINE);
            $invoice->register();

            $invoice->setEmailSent($this->getIsNotify());
            $invoice->getOrder()->setCustomerNoteNotify($this->getIsNotify());
            $invoice->getOrder()->setIsInProcess(true);

            $transactionSave = Mage::getModel('core/resource_transaction')
                ->addObject($invoice)
                ->addObject($invoice->getOrder());
            $transactionSave->save();

            try {
                $invoice->sendEmail($this->getIsNotify(), '');
            } catch (Exception $e) {
                Mage::logException($e);
                $this->addErrorInvoiceMessage($invoice, 'Unable to send email.');
            }

            $this->_getSession()->addSuccess(
                $this->__(
                    'The invoice <a href="%s" target="_blank" title="Go to invoice">#%s</a> has been created.',
                    Mage::helper('adminhtml')->getUrl('*/sales_invoice/view', array('invoice_id' => $invoice->getId())),
                    $invoice->getIncrementId()
                )
            );
        } catch (Exception $e) {
            $this->addErrorOrderMessage($e->getMessage());
            return false;
        }

        return true;
    }

    /**
     * @param $message
     */
    protected function addErrorOrderMessage($message)
    {
        $this->_getSession()->addError(
            $this->__(
                'The order <a href="%s" target="_blank" title="Go to order">#%s</a>: %s',
                Mage::helper('adminhtml')->getUrl('*/sales_order/view', array('order_id' => $this->order->getId())),
                $this->order->getIncrementId(),
                $message
            )
        );
    }

    /**
     * @param $invoice
     * @param $message
     */
    protected function addErrorInvoiceMessage($invoice, $message)
    {
        $this->_getSession()->addError(
            $this->__(
                'The invoice <a href="%s" target="_blank" title="Go to invoice">#%s</a>: %s',
                Mage::helper('adminhtml')->getUrl('*/sales_invoice/view', array('invoice_id' => $invoice->getId())),
                $invoice->getIncrementId(),
                $message
            )
        );
    }

    /**
     * @param $shipment
     * @param $message
     */
    protected function addErrorShipmentMessage($shipment, $message)
    {
        $this->_getSession()->addError(
            $this->__(
                'The shipment <a href="%s" target="_blank" title="Go to shipment">#%s</a>: %s',
                Mage::helper('adminhtml')->getUrl('*/sales_shipment/view', array('shipment_id' => $shipment->getId())),
                $shipment->getIncrementId(),
                $message
            )
        );
    }

    /**
     * @return bool
     */
    protected function createShipment()
    {
        if (!$this->getIsShipment()) {
            return true;
        }

        try {
            if (!$this->order->canShip()) {
                return false;
            }

            if ($this->order->getForcedDoShipmentWithInvoice()) {
                $this->addErrorOrderMessage('Cannot do shipment for the order separately from invoice.');
                return false;
            }

            /**
             * @var $shipment Mage_Sales_Model_Order_Shipment
             */
            $shipment = Mage::getModel('sales/service_order', $this->order)->prepareShipment();
            if (!$shipment) {
                $this->addErrorOrderMessage('Cannot create shipment.');
                return false;
            }

            Mage::unregister('current_shipment');
            Mage::register('current_shipment', $shipment);

            $shipment->register();

            $shipment->setEmailSent($this->getIsNotify());
            $shipment->getOrder()->setCustomerNoteNotify($this->getIsNotify());
            $shipment->getOrder()->setIsInProcess(true);
            Mage::getModel('core/resource_transaction')
                ->addObject($shipment)
                ->addObject($shipment->getOrder())
                ->save();

            try {
                $shipment->sendEmail($this->getIsNotify(), '');
            } catch (Exception $e) {
                $this->addErrorShipmentMessage($shipment, 'Unable to send email.');
            }

            $shipmentUrl = Mage::helper('adminhtml')
                ->getUrl('*/sales_shipment/view', array('shipment_id' => $shipment->getId()));
            $this->_getSession()->addSuccess(
                $this->__(
                    'The shipment <a href="%s" target="_blank" title="Go to shipment">#%s</a> has been created.',
                    $shipmentUrl,
                    $shipment->getIncrementId()
                )
            );
        } catch (Exception $e) {
            $this->addErrorOrderMessage($e->getMessage());
            return false;
        }

        return true;
    }

    /**
     * @return void
     */
    protected function printInvoice()
    {
        if (!$this->getIsPrint() || !$this->getIsInvoice()) {
            return;
        }

        $orderId = $this->order->getId();
        $invoices = Mage::getResourceModel('sales/order_invoice_collection')->setOrderFilter($orderId)->load();
        if ($invoices->getSize() > 0) {
            if (empty($this->pdf)) {
                $this->pdf = Mage::getModel('sales/order_pdf_invoice')->getPdf($invoices);
            } else {
                $pages = Mage::getModel('sales/order_pdf_invoice')->getPdf($invoices);
                $this->pdf->pages = array_merge($this->pdf->pages, $pages->pages);
            }
        }
    }

    /**
     * @return void
     */
    protected function printShipment()
    {
        if (!$this->getIsPrint() || !$this->getIsShipment()) {
            return;
        }

        $orderId = $this->order->getId();
        $shipments = Mage::getResourceModel('sales/order_shipment_collection')->setOrderFilter($orderId)->load();
        if ($shipments->getSize() > 0) {
            if (empty($this->pdf)) {
                $this->pdf = Mage::getModel('sales/order_pdf_shipment')->getPdf($shipments);
            } else {
                $pages = Mage::getModel('sales/order_pdf_shipment')->getPdf($shipments);
                $this->pdf->pages = array_merge($this->pdf->pages, $pages->pages);
            }
        }
    }

    /**
     * @return $this|Mage_Core_Controller_Varien_Action
     */
    protected function printPdf()
    {
        if (!empty($this->pdf) && $this->getIsPrint()) {
            $title = 'docs-';
            if ($this->getIsInvoice() && $this->getIsShipment()) {
                $title = 'invoices-shipments-';
            } elseif ($this->getIsInvoice()) {
                $title = 'invoices-';
            } elseif ($this->getIsShipment()) {
                $title = 'shipments-';
            }

            return $this->_prepareDownloadResponse(
                $title . Mage::getSingleton('core/date')->date('Y-m-d_H-i-s') . '.pdf',
                $this->pdf->render(),
                'application/pdf'
            );
        }

        return 'ERROR';
    }

    /**
     * @return bool
     */
    protected function getIsInvoice()
    {
        return (bool)(int)$this->getRequest()->getParam('invoice', 0);
    }

    /**
     * @return bool
     */
    protected function getIsShipment()
    {
        return (bool)(int)$this->getRequest()->getParam('shipment', 0);
    }

    /**
     * @return bool
     */
    protected function getIsPrint()
    {
        return (bool)(int)$this->getRequest()->getParam('print', 0);
    }

    /**
     * @return bool
     */
    protected function getIsNotify()
    {
        return (bool)(int)$this->getRequest()->getParam('notify', 0);
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return true;
    }
}
