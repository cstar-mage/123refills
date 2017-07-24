<?php

/**
 * Class IWD_OrderManager_Adminhtml_Sales_CommentController
 */
class IWD_OrderManager_Adminhtml_Sales_CommentController extends IWD_OrderManager_Controller_Abstract
{
    /**
     * @return void
     */
    public function deleteAction()
    {
        $type = $this->getType();
        $commentId = $this->getCommentId();

        $result['status'] = Mage::getModel('iwd_ordermanager/comment')->deleteComment($type, $commentId);

        $this->prepareResponse($result);
    }

    /**
     * @return void
     */
    public function updateAction()
    {
        $type = $this->getType();
        $commentId = $this->getCommentId();
        $commentText = $this->getRequest()->getParam('comment_text', '');

        $result['comment'] = Mage::getModel('iwd_ordermanager/comment')->updateComment($type, $commentId, $commentText);

        $this->prepareResponse($result);
    }

    /**
     * @return void
     */
    public function getCommentAction()
    {
        $type = $this->getType();
        $commentId = $this->getCommentId();

        $comment = Mage::getModel('iwd_ordermanager/comment')->getComment($type, $commentId);
        $breaks = array("<br />","<br>","<br/>");
        $comment = str_ireplace($breaks, "", $comment);

        $result['comment'] = $this->getLayout()
            ->createBlock('iwd_ordermanager/adminhtml_sales_order_comment_form')
            ->setData('comment', $comment)
            ->setData('comment_id', $commentId)
            ->toHtml();

        $this->prepareResponse($result);
    }

    /**
     * @return mixed
     */
    protected function getType()
    {
        return $this->getRequest()->getParam('type');
    }

    /**
     * @return mixed
     */
    protected function getCommentId()
    {
        return $this->getRequest()->getParam('comment_id');
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        $action = $this->getRequest()->getActionName();
        $action = strtolower($action);

        if ($action == 'getcomment' || $action == 'update') {
            return Mage::getSingleton('admin/session')->isAllowed('iwd_ordermanager/order/actions/edit_comment');
        }

        if ($action == 'delete') {
            return Mage::getSingleton('admin/session')->isAllowed('iwd_ordermanager/order/actions/delete_comment');
        }

        return false;
    }
}