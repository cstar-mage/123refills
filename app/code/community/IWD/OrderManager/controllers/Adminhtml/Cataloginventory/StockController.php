<?php

/**
 * Class IWD_OrderManager_Adminhtml_Cataloginventory_StockController
 */
class IWD_OrderManager_Adminhtml_Cataloginventory_StockController extends Mage_Adminhtml_Controller_Action
{
    /**
     * @return $this
     */
    protected function actionInit()
    {
        $this->loadLayout()
            ->_setActiveMenu('catalog')
            ->_title($this->__('IWD Order Manager - Stock'));

        $this->_addBreadcrumb(
            Mage::helper('iwd_ordermanager')->__('IWD Order Manager - Stock'),
            Mage::helper('iwd_ordermanager')->__('IWD Order Manager - Stock')
        );

        return $this;
    }

    /**
     * @return void
     */
    public function indexAction()
    {
        $this->actionInit();

        $this->_addContent($this->getLayout()->createBlock('iwd_ordermanager/adminhtml_cataloginventory_stock'));
        $this->renderLayout();
    }

    /**
     * @return void
     */
    public function massDeleteAction()
    {
        $ids = $this->getRequest()->getParam('stock', array());
        $session = Mage::getSingleton('adminhtml/session');
        $helper = Mage::helper('adminhtml');

        if (empty($ids)) {
            $session->addError($helper->__('Please select item(s)'));
        } else {
            try {
                $stocks = Mage::getModel('iwd_ordermanager/cataloginventory_stock')->getCollection()
                    ->addFieldToFilter('stock_id', array('in' => $ids));

                foreach ($stocks as $stock) {
                    $stock->delete();
                }

                $session->addSuccess($helper->__('Total of %d record(s) were successfully deleted', count($ids)));
            } catch (Exception $e) {
                IWD_OrderManager_Model_Logger::log($e->getMessage(), true);
            }
        }

        $this->_redirect('*/*/index');
    }

    /**
     * @return void
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('iwd_ordermanager/adminhtml_cataloginventory_stock_grid')->toHtml()
        );
    }

    /**
     * @return void
     */
    public function newAction()
    {
        $this->actionInit();
        $this->prepareDefaultFormData();
        $this->stockForm();
    }

    /**
     * @return void
     */
    public function editAction()
    {
        $this->actionInit();
        $this->prepareFormData();
        $this->stockForm();
    }

    /**
     * @return void
     */
    public function saveAction()
    {
        try {
            $data = $this->getRequest()->getParams();
            $stockId = Mage::getModel('iwd_ordermanager/cataloginventory_stock')->saveStockData($data);

            Mage::getSingleton('adminhtml/session')->setFormData(false);
            Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('iwd_ordermanager')->__('Stock was successfully saved')
            );

            if ($this->getRequest()->getParam('back')) {
                $this->_redirect('*/*/edit', array('stock_id' => $stockId));
                return;
            }
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log(
                $e->getMessage(),
                Mage::helper('iwd_ordermanager')->__('Stock was not saved')
            );

            $id = $this->getRequest()->getParam('stock_id');
            if (!empty($id)) {
                $data = Mage::getModel('iwd_ordermanager/cataloginventory_stock')->load($id);
                Mage::getSingleton('adminhtml/session')->setFormData($data->getData());
                $this->_redirect('*/*/edit', array('stock_id' => $id));
                return;
            }
        }

        $this->_redirect('*/*/');
    }

    /**
     *
     */
    protected function prepareFormData()
    {
        $id = $this->getRequest()->getParam('stock_id');
        $stock = Mage::getModel('iwd_ordermanager/cataloginventory_stock')->load($id);
        $stockId = $stock->getStockId();

        if (isset($stockId) && !empty($stockId)) {
            $stock = $stock->joinAddress();
            $stock = $stock->joinStoreIds();
            Mage::register('iwd_om_stock_data', $stock);
        }
    }

    /**
     *
     */
    protected function prepareDefaultFormData()
    {
        $stock = Mage::getModel('iwd_ordermanager/cataloginventory_stock');
        $stock->setData('country_id', 'US');

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $stock->setData($data);
        }

        Mage::register('iwd_om_stock_data', $stock);
    }

    /**
     *
     */
    protected function stockForm()
    {
        $this->_addContent($this->getLayout()->createBlock('iwd_ordermanager/adminhtml_cataloginventory_stock_edit'))
            ->_addLeft($this->getLayout()->createBlock('iwd_ordermanager/adminhtml_cataloginventory_stock_edit_tabs'));

        $this->renderLayout();
    }

    /**
     *
     */
    protected function validateAction()
    {
        $response = new Varien_Object();
        $response->setError(false);

        $this->getResponse()->setBody($response->toJson());
    }

    /**
     * @return mixed
     */
    protected function _isAllowed()
    {
        return Mage::helper('iwd_ordermanager')->isMultiInventoryEnable();
    }
}
