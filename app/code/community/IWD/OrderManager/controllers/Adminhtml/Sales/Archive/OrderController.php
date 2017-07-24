<?php

/**
 * Class IWD_OrderManager_Adminhtml_Sales_Archive_OrderController
 */
class IWD_OrderManager_Adminhtml_Sales_Archive_OrderController extends Mage_Adminhtml_Controller_Action
{
    /**
     * @return void
     */
    public function indexAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('sales')
            ->_title($this->__('IWD Order Manager - Archive - Orders'));

        $this->_addBreadcrumb(
            Mage::helper('iwd_ordermanager')->__('IWD Order Manager - Archive - Orders'),
            Mage::helper('iwd_ordermanager')->__('IWD Order Manager - Archive - Orders')
        );

        $this->_addContent($this->getLayout()->createBlock('iwd_ordermanager/adminhtml_sales_order_archive_orders'));
        $this->renderLayout();
    }

    /**************************** ARCHIVE *********************************/
    public function archiveAction()
    {
        $orderIds = $this->getRequest()->getParam('order_ids');

        if (empty($orderIds)) {
            $this->_getSession()->addError($this->__('Please, select orders'));
        } else {
            $result = Mage::getModel('iwd_ordermanager/archive')->addSalesToArchiveByIds($orderIds);
            $this->_addResultOfArchiveToLog($result);
        }

        $this->_redirect('*/sales_order/');
    }

    /**
     * @return void
     */
    public function archiveManuallyAction()
    {
        $result = Mage::getModel('iwd_ordermanager/archive')->addSalesToArchive();
        $this->_addResultOfArchiveToLog($result);
        $this->_redirect('adminhtml/system_config/edit/section/iwd_ordermanager');
    }

    /**
     * @param $result
     */
    protected function _addResultOfArchiveToLog($result)
    {
        $linkToArchive = ' (<a href="' . Mage::helper("adminhtml")->getUrl("*/sales_archive_order/index")
            . '" title="' . $this->__('Refer to Archive Orders') . '">'
            . $this->__('Refer to "Archive Orders"') . '</a>)';

        $error = $result->resultError();
        $notAllowedOrders = $result->getNotAllowedOrders();
        $countOrderIds = $result->getCountOrderIds();

        $notArchived = 0;
        if (!empty($notAllowedOrders)) {
            $notArchived = count($notAllowedOrders);

            $message = '%d order(s) was not archived. Such order(s) is not allowed to archive. Please, check <a href="%s" target="_blank" title="System - Configuration - IWD Extensions - Order Manager - Archive Sales">configuration</a> of IWD OrderManager';
            $href = Mage::helper("adminhtml")->getUrl("adminhtml/system_config/edit", array("section" => "iwd_ordermanager"));
            $this->_getSession()->addNotice(sprintf($message, $notArchived, $href));
        }

        if (!empty($error)) {
            $this->_getSession()->addError(
                $this->__('Error archive order(s)') . ": " . $error->getMessage() . $linkToArchive
            );
        } else {
            if ($countOrderIds - $notArchived > 0) {
                $this->_getSession()->addSuccess(
                    sprintf($this->__('Orders have been archived successfully. %s'), $linkToArchive)
                );
            }
        }
    }
    /******************************************************** end ARCHIVE */


    /**************************** RESTORE *********************************/
    public function restoreAction()
    {
        $orderIds = $this->getRequest()->getParam('order_ids');

        if (empty($orderIds)) {
            $this->_getSession()->addError($this->__('Please, select orders'));
        } else {
            $result = Mage::getModel('iwd_ordermanager/archive')->restoreSalesFromArchiveByIds($orderIds);
            $this->_addResultOfRestoreToLog($result);
        }

        $this->_redirect('*/sales_archive_order/index');
    }

    /**
     * @return void
     */
    public function restoreManuallyAction()
    {
        $result = Mage::getModel('iwd_ordermanager/archive')->restoreSalesFromArchive();
        $this->_addResultOfRestoreToLog($result);
        $this->_redirect('adminhtml/system_config/edit/section/iwd_ordermanager');
    }

    /**
     * @param $result
     */
    protected function _addResultOfRestoreToLog($result)
    {
        $linkToOrderPage = ' (<a href="' . Mage::helper("adminhtml")->getUrl("*/sales_order/")
            . '" title="' . $this->__('Refer to Orders') . '">' . $this->__('Refer to "Orders"') . '</a>)';

        $error = $result->resultError();

        if (!empty($error)) {
            $this->_getSession()->addError(
                $this->__('Error restore order(s)') . ": " . $error->getMessage() . $linkToOrderPage
            );
        } else {
            $this->_getSession()->addSuccess(
                sprintf($this->__('Orders have been restored successfully %s'), $linkToOrderPage)
            );
        }
    }
    /******************************************************** end RESTORE */


    /************************** EXPORTS GRIDS ******************************/
    public function exportCsvAction()
    {
        $fileName = 'archived_orders.csv';
        $grid = $this->getLayout()->createBlock('iwd_ordermanager/adminhtml_sales_order_archive_orders_grid');

        if (empty($fileName) || empty($grid)) {
            return;
        }

        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }

    /**
     * @return void
     */
    public function exportExcelAction()
    {
        $fileName = 'archived_orders.xml';
        $grid = $this->getLayout()->createBlock('iwd_ordermanager/adminhtml_sales_order_archive_orders_grid');

        if (empty($fileName) || empty($grid)) {
            return;
        }

        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile());
    }
    /*************************************************** end EXPORTS GRIDS */


    /************************** MASS ACTIONS *******************************/
    public function massCancelAction()
    {
        $this->_forward('massCancel', 'sales_order', null, array('origin' => 'archive'));
    }

    /**
     * @return void
     */
    public function massHoldAction()
    {
        $this->_forward('massHold', 'sales_order', null, array('origin' => 'archive'));
    }

    /**
     * @return void
     */
    public function massUnholdAction()
    {
        $this->_forward('massUnhold', 'sales_order', null, array('origin' => 'archive'));
    }

    /**
     * @return void
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('iwd_ordermanager/adminhtml_sales_order_archive_orders_grid')->toHtml()
        );
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        if (Mage::helper('iwd_ordermanager')->isEnterpriseMagentoEdition()) {
            return false;
        }

        return Mage::getSingleton('admin/session')->isAllowed('sales/iwd_ordermanager_archive/archive_orders');
    }
}