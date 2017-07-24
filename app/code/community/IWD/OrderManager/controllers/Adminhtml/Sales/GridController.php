<?php

/**
 * Class IWD_OrderManager_Adminhtml_Sales_GridController
 */
class IWD_OrderManager_Adminhtml_Sales_GridController extends Mage_Adminhtml_Controller_Action
{
    /**
     * @return void
     */
    public function deleteAction()
    {
        $redirect = $this->getRequest()->getParam('redirect');
        $redirect = (empty($redirect)) ? "*/sales_order/index" : "*/{$redirect}/index";

        if (Mage::getModel('iwd_ordermanager/order')->isAllowDeleteOrders()) {
            try {
                $checkedOrders = $this->getCheckedOrderIds();
                foreach ($checkedOrders as $orderId) {
                    $order = Mage::getModel('iwd_ordermanager/order')->load($orderId);
                    if ($order->getEntityId()) {
                        if ($order->deleteOrder()) {
                            $this->deleteFromOrderGrid($orderId);
                        }
                    } else {
                        $this->deleteFromOrderGrid($orderId);
                    }
                }

                Mage::getSingleton('iwd_ordermanager/report')->AggregateSales();
                Mage::getSingleton('iwd_ordermanager/logger')->addMessageToPage();
            } catch (Exception $e) {
                IWD_OrderManager_Model_Logger::log($e->getMessage());
                $this->_getSession()->addError($this->__('An error during the deletion. %s', $e->getMessage()));
                $this->_redirect($redirect);
                return;
            }
        } else {
            $this->_getSession()->addError($this->__('This feature was deactivated.'));
            $this->_redirect($redirect);
            return;
        }

        $this->_redirect($redirect);
    }

    /**
     * @return void
     */
    public function hideAction()
    {
        $redirect = $this->getRequest()->getParam('redirect');
        $redirect = (empty($redirect)) ? "*/sales_order/index" : "*/{$redirect}/index";

        if (Mage::helper('iwd_ordermanager')->isAllowHideOrders()) {
            try {
                $checkedOrders = $this->getCheckedOrderIds();
                $status = $this->getRequest()->getParam('status');

                foreach ($checkedOrders as $orderId) {
                    $order = Mage::getModel('sales/order')->load($orderId);
                    Mage::getModel('iwd_ordermanager/order_info')->showHideOrderOnFront($order, $status);
                }

                $comment = $status
                    ? $this->__('Order(s) are hidden on front in customer account')
                    : $this->__('Order(s) are shown on front in customer account');

                $this->_getSession()->addSuccess($comment);
            } catch (Exception $e) {
                IWD_OrderManager_Model_Logger::log($e->getMessage());
                $this->_getSession()->addError($this->__('An error during hide order. %s', $e->getMessage()));
                $this->_redirect($redirect);
                return;
            }
        } else {
            $this->_getSession()->addError($this->__('This feature was deactivated.'));
            $this->_redirect($redirect);
            return;
        }

        $this->_redirect($redirect);
    }

    /**
     * @return void
     */
    public function orderCommentsAction()
    {
        try {
            $checkedOrders = $this->getCheckedOrderIds();

            $comment = $this->getRequest()->getParam('iwd_om_comment', '');
            $isCustomerNotified = $this->getRequest()->getParam('iwd_om_notified', false);
            $isVisibleOnFront = $this->getRequest()->getParam('iwd_om_visible', false);

            foreach ($checkedOrders as $orderId) {
                $order = Mage::getModel('sales/order')->load($orderId);
                $order->addStatusHistoryComment($comment)
                    ->setIsCustomerNotified($isCustomerNotified)
                    ->setIsVisibleOnFront($isVisibleOnFront);
                $order->save();
            }

            $this->_getSession()->addSuccess($this->__('Comment was added to order(s)'));
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log($e->getMessage());
            $this->_getSession()->addError($this->__('An error during hide order. %s', $e->getMessage()));
            $this->_redirect("*/sales_order/index");
            return;
        }

        $this->_redirect("*/sales_order/index");
    }

    /**
     * @param $orderId
     */
    public function deleteFromOrderGrid($orderId)
    {
        $connection = Mage::getSingleton('core/resource')->getConnection('core_write');

        /* from order grid table */
        try {
            $salesFlatOrderGrid = Mage::getSingleton('core/resource')->getTableName('sales_flat_order_grid');
            $connection->beginTransaction();
            $connection->delete($salesFlatOrderGrid, array($connection->quoteInto('entity_id=?', $orderId)));
            $connection->commit();
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log($e->getMessage());
        }

        /* from archive order grid table */
        if (!Mage::helper('iwd_ordermanager')->isEnterpriseMagentoEdition()) {
            try {
                $connection->beginTransaction();
                $connection->delete(
                    Mage::getSingleton('core/resource')->getTableName('iwd_sales_archive_order_grid'),
                    array($connection->quoteInto('entity_id=?', $orderId))
                );
                $connection->commit();
            } catch (Exception $e) {
                IWD_OrderManager_Model_Logger::log($e->getMessage());
            }
        }
    }

    /**
     * @return void
     */
    public function changeStatusAction()
    {
        $redirect = "*/sales_order/index";

        if (Mage::getModel('iwd_ordermanager/order')->isAllowChangeOrderStatus()) {
            try {
                $statusId = $this->getRequest()->getParam('status');
                $checkedOrders = $this->getCheckedOrderIds();

                foreach ($checkedOrders as $orderId) {
                    $order = Mage::getModel('iwd_ordermanager/order')->load($orderId);
                    if ($order->getId()) {
                        $logger = Mage::getSingleton('iwd_ordermanager/logger');
                        $oldStatusId = $order->getStatus();
                        $oldStatus = Mage::getResourceModel('sales/order_status_collection')
                            ->addStateFilter($oldStatusId)
                            ->getData();
                        $logger->addChangesToLog('order_status', $oldStatus[0]['label'], $statusId);
                        $logger->addCommentToOrderHistoryInGrid($orderId, $statusId, false);
                        $logger->addLogToLogTable(IWD_OrderManager_Model_Confirm_Options_Type::ORDER_INFO, $orderId);
                        $order->setData('status', $statusId)->save();
                    }
                }

                $this->_getSession()->addSuccess($this->__('Status was successfully changed'));
            } catch (Exception $e) {
                IWD_OrderManager_Model_Logger::log($e->getMessage());
                $this->_getSession()->addError($this->__('An error arose during the updating. %s', $e));
            }
        } else {
            $this->_getSession()->addError($this->__('This feature was deactivated.'));
        }

        $this->_redirect($redirect);
    }

    /**
     * @return void
     */
    public function orderedItemsAction()
    {
        $result = array('status' => 1);

        try {
            $orderId = $this->getRequest()->getPost('order_id');
            $ordered = Mage::getModel('sales/order')->load($orderId)->getItemsCollection();

            $result['table'] = $this->getLayout()
                ->createBlock('iwd_ordermanager/adminhtml_sales_order_grid_ordereditems')
                ->setData('ordered', $ordered)
                ->setData('order_id', $orderId)
                ->toHtml();
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log($e->getMessage());
            $result = array('status' => 0, 'error' => $e->getMessage());
        }

        $this->prepareResponse($result);
    }

    /**
     * @return void
     */
    public function productItemsAction()
    {
        $result = array('status' => 1);

        try {
            $orderId = $this->getRequest()->getPost('order_id');
            $ordered = Mage::getModel('sales/order')->load($orderId)->getItemsCollection();

            $products = array();
            foreach ($ordered as $item) {
                $productId = $item->getProductId();
                $products[$productId] = Mage::getModel('catalog/product')->load($productId);
            }

            $result['table'] = $this->getLayout()
                ->createBlock('iwd_ordermanager/adminhtml_sales_order_grid_productitems')
                ->setData('products', $products)
                ->setData('order_id', $orderId)
                ->toHtml();
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log($e->getMessage());
            $result = array('status' => 0, 'error' => $e->getMessage());
        }

        $this->prepareResponse($result);
    }

    /**
     * @return array|mixed
     */
    protected function getCheckedOrderIds()
    {
        $checkedOrders = $this->getRequest()->getParam('order_ids');
        if (!is_array($checkedOrders)) {
            $checkedOrders = array($checkedOrders);
        }

        return $checkedOrders;
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        $action = $this->getRequest()->getActionName();
        $action = strtolower($action);
        if ($action == 'delete') {
            return Mage::getSingleton('admin/session')->isAllowed('iwd_ordermanager/order/actions/delete');
        }

        return true;
    }

    /**
     * @param $result
     */
    protected function prepareResponse($result)
    {
        $this->getResponse()->setHeader('Content-type', 'application/json', true);
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }
}