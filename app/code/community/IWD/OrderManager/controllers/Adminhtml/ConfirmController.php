<?php

/**
 * Class IWD_OrderManager_Adminhtml_ConfirmController
 */
class IWD_OrderManager_Adminhtml_ConfirmController extends Mage_Adminhtml_Controller_Action
{
    /**
     * @return void
     */
    public function indexAction()
    {
        $this->logAction();
    }

    /**
     * @return void
     */
    public function logAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('system')
            ->_title($this->__('IWD Order Manager - Log Operations'));

        $this->_addBreadcrumb(
            Mage::helper('iwd_ordermanager')->__('IWD Order Manager - Log Operations'),
            Mage::helper('iwd_ordermanager')->__('IWD Order Manager - Log Operations')
        );

        $this->_addContent($this->getLayout()->createBlock('iwd_ordermanager/adminhtml_confirm_log'));
        $this->renderLayout();
    }

    /**
     * @return void
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('iwd_ordermanager/adminhtml_confirm_log_grid')->toHtml()
        );
    }

    /** http://site.com/admin/iwd_ordermanager/confirm/edit/action/confirm/pid/000000000000000 **/
    /** http://site.com/admin/iwd_ordermanager/confirm/edit/action/cancel/pid/000000000000000 **/
    public function editAction()
    {

        $action = $this->getRequest()->getParam('action');
        $id = $this->getRequest()->getParam('id');
        $helper = Mage::helper('iwd_ordermanager');
        /** error **/
        if (empty($action) || empty($id)) {
            $this->_getSession()->addError($helper->__('Error cancel query'));
            $this->_redirect('*/confirm/log');
            return;
        }

        if ($action == 'confirm') {
            /** confirm **/
            $status = Mage::getModel('iwd_ordermanager/confirm_operations')->confirmById($id);
            if ($status) {
                $this->_getSession()->addSuccess($helper->__('Query was confirmed.'));
            } else {
                $this->_getSession()->addError($helper->__('Error confirm query.'));
            }
        } else if ($action == 'cancel') {
            /** confirm **/
            $status = Mage::getModel('iwd_ordermanager/confirm_operations')->cancelConfirmById($id);

            if ($status) {
                $this->_getSession()->addSuccess($helper->__('Query was canceled.'));
            } else {
                $this->_getSession()->addError($helper->__('Error cancel query.'));
            }
        }

        $this->_redirect('*/confirm/log');
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return true;
    }
}
