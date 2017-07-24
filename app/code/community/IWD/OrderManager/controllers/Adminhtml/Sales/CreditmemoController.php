<?php

/**
 * Class IWD_OrderManager_Adminhtml_Sales_CreditmemoController
 */
class IWD_OrderManager_Adminhtml_Sales_CreditmemoController extends Mage_Adminhtml_Sales_CreditmemoController
{
    /**
     * @return void
     */
    public function deleteAction()
    {
        if (Mage::getModel('iwd_ordermanager/creditmemo')->isAllowDeleteCreditmemos()) {
            $checkedCreditMemos = $this->getRequest()->getParam('creditmemo_ids');
            if (!is_array($checkedCreditMemos)) {
                $checkedCreditMemos = array($checkedCreditMemos);
            }

            try {
                foreach ($checkedCreditMemos as $creditmemoId) {
                    $creditmemo = Mage::getModel('iwd_ordermanager/creditmemo')->load($creditmemoId);
                    if ($creditmemo->getId()) {
                        $creditmemo->deleteCreditmemo();
                    }
                }

                Mage::getSingleton('iwd_ordermanager/report')->AggregateSales();
                Mage::getSingleton('iwd_ordermanager/logger')->addMessageToPage();
            } catch (Exception $e) {
                IWD_OrderManager_Model_Logger::log($e->getMessage());
                $this->_getSession()->addError($this->__('An error arose during the deletion. %s', $e->getMessage()));
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
        return Mage::getSingleton('admin/session')->isAllowed('iwd_ordermanager/creditmemo/actions/delete');
    }
}
