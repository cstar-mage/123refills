<?php

/**
 * Class IWD_OrderManager_Adminhtml_Sales_Archive_ShipmentController
 */
class IWD_OrderManager_Adminhtml_Sales_Archive_ShipmentController extends Mage_Adminhtml_Controller_Action
{
    /**
     * @return void
     */
    public function indexAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('sales')
            ->_title($this->__('IWD Order Manager - Archive - Shipments'));

        $this->_addBreadcrumb(
            Mage::helper('iwd_ordermanager')->__('IWD Order Manager - Archive - Shipments'),
            Mage::helper('iwd_ordermanager')->__('IWD Order Manager - Archive - Shipments')
        );

        $this->_addContent($this->getLayout()->createBlock('iwd_ordermanager/adminhtml_sales_order_archive_shipments'));
        $this->renderLayout();
    }

    /**
     * @return void
     */
    public function exportCsvAction()
    {
        $fileName = 'archive_shipments.csv';
        $grid = $this->getLayout()->createBlock('iwd_ordermanager/adminhtml_sales_order_archive_shipments_grid');

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
        $fileName = 'archive_shipments.xml';
        $grid = $this->getLayout()->createBlock('iwd_ordermanager/adminhtml_sales_order_archive_shipments_grid');

        if (empty($fileName) || empty($grid)) {
            return;
        }

        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile());
    }

    /**
     * @return void
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('iwd_ordermanager/adminhtml_sales_order_archive_shipments_grid')->toHtml()
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

        return Mage::getSingleton('admin/session')->isAllowed('sales/iwd_ordermanager_archive/archive_shipments');
    }
}
