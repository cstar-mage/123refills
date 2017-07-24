<?php

/**
 * Class IWD_OrderManager_Adminhtml_Sales_Backup_CommentsController
 */
class IWD_OrderManager_Adminhtml_Sales_Backup_CommentsController extends Mage_Adminhtml_Controller_Action
{
    /**
     * @return void
     */
    public function indexAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('system')
            ->_title($this->__('IWD Order Manager - Backups'));

        $this->_addBreadcrumb(
            Mage::helper('iwd_ordermanager')->__('IWD Order Manager - Backup - Comments'),
            Mage::helper('iwd_ordermanager')->__('IWD Order Manager - Backup - Comments')
        );

        $this->_addContent($this->getLayout()->createBlock('iwd_ordermanager/adminhtml_sales_order_backup_comments'));
        $this->renderLayout();
    }

    /**
     * @return void
     */
    public function massDeleteAction()
    {
        $backupIds = $this->getRequest()->getParam('backup');
        if (!is_array($backupIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($backupIds as $id) {
                    $comment = Mage::getModel('iwd_ordermanager/backup_comments')->load($id);
                    $comment->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d record(s) were successfully deleted', count($backupIds))
                );
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
            $this->getLayout()->createBlock('iwd_ordermanager/adminhtml_sales_order_backup_comments_grid')->toHtml()
        );
    }

    /**
     * @return mixed
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('sales/iwd_ordermanager_backups/comments');
    }
}