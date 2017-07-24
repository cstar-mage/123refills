<?php

/**
 * Class IWD_OrderManager_Frontend_ConfirmController
 */
class IWD_OrderManager_Frontend_ConfirmController extends Mage_Core_Controller_Front_Action
{
    /** http://site.com/iwd_order_manager/confirm/edit/action/confirm/pid/000000000000000 **/
    /** http://site.com/iwd_order_manager/confirm/edit/action/cancel/pid/000000000000000 **/
    public function editAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('root')->setTemplate('page/1column.phtml');

        $cmsBlock = $this->_confirm();
        $this->getLayout()->getBlock('content')->insert($cmsBlock, 'iwd_ordermanager_confirm');

        $this->renderLayout();
    }

    /**
     * @return mixed
     */
    protected function _confirm()
    {
        $action = $this->getRequest()->getParam('action');
        $pid = $this->getRequest()->getParam('pid');

        $cmsBlock = $this->getLayout()->createBlock('cms/block');

        /** error **/
        if (empty($action) || empty($pid)) {
            return $cmsBlock->setBlockId('iwd_ordermanager_confirm_error');
        }

        if ($action == 'confirm') {
            /** confirm **/
            $status = Mage::getModel('iwd_ordermanager/confirm_operations')->confirmByPid($pid);
            if ($status) {
                return $cmsBlock->setBlockId('iwd_ordermanager_confirm_success');
            }
        } else if ($action == 'cancel') {
            /** cancel **/
            $status = Mage::getModel('iwd_ordermanager/confirm_operations')->cancelConfirmByPid($pid);
            if ($status) {
                return $cmsBlock->setBlockId('iwd_ordermanager_confirm_cancel');
            }
        }

        return $cmsBlock->setBlockId('iwd_ordermanager_confirm_error');
    }
}