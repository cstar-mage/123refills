<?php

/**
 * Class IWD_OrderManager_Model_Comment
 */
class IWD_OrderManager_Model_Comment extends Mage_Core_Model_Abstract
{
    /**
     * @param $type
     * @param $commentId
     * @return string
     */
    public function getComment($type, $commentId)
    {
        switch ($type) {
            case "order":
                $comment = Mage::getModel('sales/order_status_history')->load($commentId)->getComment();
                break;
            case "creditmemo":
                $comment = Mage::getModel('sales/order_creditmemo_comment')->load($commentId)->getComment();
                break;
            case "invoice":
                $comment = Mage::getModel('sales/order_invoice_comment')->load($commentId)->getComment();
                break;
            case "shipment":
                $comment = Mage::getModel('sales/order_shipment_comment')->load($commentId)->getComment();
                break;
            default:
                $comment = "";
        }

        return $comment;
    }

    /**
     * @param $type
     * @param $id
     * @param $commentText
     * @return null
     */
    public function updateComment($type, $id, $commentText)
    {
        switch ($type) {
            case "order":
                $comment = $this->_editComment($id, "order_status_history", $commentText, $type);
                break;
            case "creditmemo":
                $comment = $this->_editComment($id, "order_creditmemo_comment", $commentText, $type);
                break;
            case "invoice":
                $comment = $this->_editComment($id, "order_invoice_comment", $commentText, $type);
                break;
            case "shipment":
                $comment = $this->_editComment($id, "order_shipment_comment", $commentText, $type);
                break;
            default:
                $comment = null;
        }

        return $comment;
    }

    /**
     * @param $type
     * @param $commentId
     * @return int
     */
    public function deleteComment($type, $commentId)
    {
        switch ($type) {
            case "order":
                $comment = $this->_deleteComment($commentId, "order_status_history", $type);
                break;
            case "creditmemo":
                $comment = $this->_deleteComment($commentId, "order_creditmemo_comment", $type);
                break;
            case "invoice":
                $comment = $this->_deleteComment($commentId, "order_invoice_comment", $type);
                break;
            case "shipment":
                $comment = $this->_deleteComment($commentId, "order_shipment_comment", $type);
                break;
            default:
                $comment = 0;
        }

        return $comment;
    }

    protected function _editComment($id, $model, $newComment, $type)
    {

        try {
            $comment = Mage::getModel('sales/' . $model)->load($id);
            Mage::dispatchEvent(
                'iwd_ordermanager_sales_comment_update_after',
                array('comment' => $comment, 'type' => $type)
            );

            $newComment = Mage::helper('core')->escapeHtml($newComment, array('b', 'br', 'strong', 'i', 'u'));
            $comment->setComment($newComment);
            $comment->save();

            Mage::dispatchEvent(
                'iwd_ordermanager_sales_comment_update_before',
                array('comment' => $comment, 'type' => $type)
            );
            return $comment->getComment();
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log($e->getMessage());
            return null;
        }
    }

    protected function _deleteComment($id, $model, $type)
    {
        try {
            $comment = Mage::getModel('sales/' . $model)->load($id);
            Mage::dispatchEvent(
                'iwd_ordermanager_sales_comment_delete_after',
                array('comment' => $comment, 'type' => $type)
            );

            $comment->delete();

            Mage::dispatchEvent(
                'iwd_ordermanager_sales_comment_delete_before',
                array('comment' => $comment, 'type' => $type)
            );
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log($e->getMessage());
            return 0;
        }

        return 1;
    }
}