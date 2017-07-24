<?php

/**
 * Class IWD_OrderManager_Adminhtml_Sales_InvoiceController
 */
class IWD_OrderManager_Adminhtml_Sales_InvoiceController extends Mage_Adminhtml_Sales_InvoiceController
{
    /**
     * @return void
     */
    public function deleteAction()
    {
        if (Mage::getModel('iwd_ordermanager/invoice')->isAllowDeleteInvoices()) {
            $checkedInvoices = $this->getRequest()->getParam('invoice_ids');
            if (!is_array($checkedInvoices)) {
                $checkedInvoices = array($checkedInvoices);
            }

            try {
                foreach ($checkedInvoices as $invoiceId) {
                    $invoice = Mage::getModel('iwd_ordermanager/invoice')->load($invoiceId);
                    if ($invoice->getId()) {
                        $invoice->DeleteInvoice();
                    }
                }

                Mage::getSingleton('iwd_ordermanager/report')->AggregateSales();
                Mage::getSingleton('iwd_ordermanager/logger')->addMessageToPage();
            } catch (Exception $e) {
                IWD_OrderManager_Model_Logger::log($e->getMessage());
                $this->_getSession()->addError($this->__('An error arose during the deletion. %s', $e));
                $this->_redirect('*/*/');
                return;
            }
        } else {
            $this->_getSession()->addError($this->__('This feature was deactivated.'));
            $this->_redirect('*/*/');
            return;
        }

        $this->redirect();
    }

    /**
     * Set redirect into response
     */
    protected function redirect()
    {
        $orderId = $this->getRequest()->getParam('order_id', null);
        if (empty($orderId)) {
            $this->_redirect('*/*/index');
        } else {
            $this->_redirect('*/sales_order/view', array('order_id' => $orderId));
        }
    }

    /**
     * @return mixed
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('iwd_ordermanager/invoice/actions/delete');
    }
}
