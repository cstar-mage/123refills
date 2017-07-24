<?php

/**
 * Class IWD_OrderManager_Adminhtml_Settlementreport_TransactionsController
 */
class IWD_OrderManager_Adminhtml_Settlementreport_TransactionsController extends Mage_Adminhtml_Controller_Action
{
    /**
     * @return $this
     */
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('iwd_settlementreport')
            ->_title($this->__('IWD - Settlement Reports'));

        $this->_addBreadcrumb(
            Mage::helper('iwd_ordermanager')->__('Settlement Reports'),
            Mage::helper('iwd_ordermanager')->__('Settlement Reports')
        );

        return $this;
    }

    /**
     * @return void
     */
    public function indexAction()
    {
        $connection = Mage::helper('iwd_ordermanager/settlementReport')->checkApiCredentials();

        if ($connection['error'] == 0) {
            $this->_showLastExecutionTime();
            $this->_initAction();
            $this->_addContent($this->getLayout()->createBlock('iwd_ordermanager/adminhtml_transactions'));
        } else {
            $this->_initAction();
            $errorBlock = $this->getLayout()->createBlock('iwd_ordermanager/adminhtml_transactions_error');
            $errorBlock->setData('message', $connection['message']);
            $this->_addContent($errorBlock);
        }

        $this->renderLayout();
    }

    /**
     * @return void
     */
    public function sendreportAction()
    {
        $helper = Mage::helper('iwd_ordermanager');

        try {
            $email = $this->getRequest()->getParam('email', null);
            if (empty($email)) {
                Mage::throwException('Email is empty.');
            }

            /* Mage::getModel("iwd_settlementreport/transactions")->refresh(); */
            Mage::getModel('iwd_ordermanager/notify_report')->sendEmail($email);

            Mage::getSingleton('adminhtml/session')->addSuccess($helper->__('The reports were successfully sent.'));
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($helper->__('Error: ') . $e->getMessage());
        }

        $this->_redirect('*/*/');
    }

    /**
     * @return void
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('iwd_ordermanager/adminhtml_transactions_grid')->toHtml()
        );
    }

    /**
     * @return void
     */
    public function updateAction()
    {
        $helper = Mage::helper('iwd_ordermanager');
        try {
            Mage::getModel("iwd_ordermanager/transactions")->refresh();

            Mage::getSingleton('adminhtml/session')->addSuccess($helper->__('Refreshed Successfully'));
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($helper->__('Error: ') . $e->getMessage());
        }

        $this->_redirect('*/*/');
    }

    /**
     * @return void
     */
    public function exportCsvAction()
    {
        $fileName = 'transactions.csv';
        $content = $this->getLayout()->createBlock('iwd_ordermanager/adminhtml_transactions_grid')->getCsvFile();

        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * @return void
     */
    public function exportExcelAction()
    {
        $fileName = 'transactions.xml';
        $content = $this->getLayout()->createBlock('iwd_ordermanager/adminhtml_transactions_grid')->getExcelFile();

        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * @return mixed
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('admin/report/iwd_settlementreport');
    }

    /**
     * @return $this
     */
    protected function _showLastExecutionTime()
    {
        $flag = Mage::getModel('reports/flag')->setReportFlagCode('iwd_settlementreport_transactions')->loadSelf();
        $format = Varien_Date::DATETIME_INTERNAL_FORMAT;
        $updatedAt = ($flag->hasData())
            ? Mage::app()->getLocale()->storeDate(0, new Zend_Date($flag->getLastUpdate(), $format), true)
            : 'undefined';

        Mage::getSingleton('adminhtml/session')->addNotice(
            Mage::helper('adminhtml')->__('Last updated: %s.', $updatedAt)
        );

        return $this;
    }
}
