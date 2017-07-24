<?php

/**
 * Class IWD_OrderManager_Adminhtml_Cataloginventory_ProductController
 */
class IWD_OrderManager_Adminhtml_Cataloginventory_ProductController extends Mage_Adminhtml_Controller_Action
{
    /**
     * @return $this
     */
    protected function actionInit()
    {
        $this->loadLayout()
            ->_setActiveMenu('catalog')
            ->_title($this->__('IWD Order Manager - Product'));

        $this->_addBreadcrumb(
            Mage::helper('iwd_ordermanager')->__('IWD Order Manager - Stocks for Products'),
            Mage::helper('iwd_ordermanager')->__('IWD Order Manager - Stocks for Products')
        );

        return $this;
    }

    /**
     * @return void
     */
    public function indexAction()
    {
        $this->actionInit();

        $this->_addContent($this->getLayout()->createBlock('iwd_ordermanager/adminhtml_cataloginventory_product'));
        $this->renderLayout();
    }

    /**
     * @return void
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('iwd_ordermanager/adminhtml_cataloginventory_product_grid')->toHtml()
        );
    }

    /**
     * @return void
     */
    public function saveAction()
    {
        try {
            $data = $this->getRequest()->getParam('stock', array());

            foreach ($data as $productId => $stocks) {
                $product = Mage::getModel('catalog/product')->load($productId);

                foreach ($stocks as $stockId=>$param) {
                    $stockItem = $this->getStockItem($stockId, $productId);

                    $stockItem->setProduct($product);
                    $stockItem->setData('stock_id', $stockId);
                    $stockItem->setData('product_id', $productId);

                    if (isset($param['qty'])) {
                        $stockItem->setData('qty', $param['qty']);
                    }

                    if (isset($param['is_in_stock'])) {
                        $stockItem->setData('is_in_stock', $param['is_in_stock']);
                    }

                    $stockItem->save();
                }
            }

            $message = '<ul class="messages"><li class="success-msg"><ul><li><span>'
                . Mage::helper('iwd_ordermanager')->__('Stock data was updated.')
                . '</span></li></ul></li></ul>';
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log($e->getMessage());

            $message = '<ul class="messages"><li class="error-msg"><ul><li><span>'
                . Mage::helper('iwd_ordermanager')->__('Something went wrong. Stock data was not updated.')
                . '</span></li></ul></li></ul>';
        }

        $this->getResponse()->setHeader('Content-type', 'application/html', true);
        $this->getResponse()->setBody($message);
    }


    /**
     * @param $stockId
     * @param $productId
     * @return Mage_CatalogInventory_Model_Stock_Item
     */
    protected function getStockItem($stockId, $productId)
    {
        $stockItem = Mage::getModel('cataloginventory/stock_item')->getCollection()
            ->addFieldToFilter('stock_id', $stockId)
            ->addFieldToFilter('product_id', $productId);

        return $stockItem->getFirstitem();
    }

    /**
     * @return mixed
     */
    protected function _isAllowed()
    {
        return Mage::helper('iwd_ordermanager')->isMultiInventoryEnable();
    }
}