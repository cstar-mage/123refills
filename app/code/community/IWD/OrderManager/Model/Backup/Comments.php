<?php

/**
 * Class IWD_OrderManager_Model_Backup_Comments
 */
class IWD_OrderManager_Model_Backup_Comments extends Mage_Core_Model_Abstract
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('iwd_ordermanager/backup_comments');
    }

    /**
     * @param $comment
     * @param $type
     * @return bool|Mage_Core_Model_Abstract
     */
    public function saveBackup($comment, $type)
    {
        if (!$user = Mage::getSingleton('admin/session')->getUser()) {
            return false;
        }

        $row = serialize($comment->getData());

        $this->setDeletionAt(Mage::getModel('core/date')->date('Y-m-d H:i:s'));
        $this->setDeletionRow($row);
        $this->setHistoryBy($type);
        $this->setAdminUserId($user->getId());
        return $this->save();
    }
}
