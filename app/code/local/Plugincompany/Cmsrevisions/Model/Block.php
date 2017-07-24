<?php
/**
 *
 * Created by:  Milan Simek
 * Company:     Plugin Company
 *
 * LICENSE: http://plugin.company/docs/magento-extensions/magento-extension-license-agreement
 *
 * YOU WILL ALSO FIND A PDF COPY OF THE LICENSE IN THE DOWNLOADED ZIP FILE
 *
 * FOR QUESTIONS AND SUPPORT
 * PLEASE DON'T HESITATE TO CONTACT US AT:
 *
 * SUPPORT@PLUGIN.COMPANY
 *
 */

/**
 * Class Plugincompany_Cmsrevisions_Model_Block
 */
class Plugincompany_Cmsrevisions_Model_Block extends Mage_Core_Model_Abstract
{

    protected function _construct()
    {
        $this->_init('plugincompany_cmsrevisions/block');
    }

    /**
     * Restores revision based on block ID and Revision ID
     *
     * @param $blockId
     * @param $revisionId
     * @return $this
     */
    public function restoreRevision($blockId,$revisionId)
    {
        $errors = false;
        //load revision
        try
        {
            $revision = Mage::getModel('plugincompany_cmsrevisions/block')->load($revisionId);
        }
        catch(Exception $e)
        {
            Mage::getSingleton('core/session')->addError('Unable to load revision');
            $errors = true;
        }

        //load cms block
        try
        {
            $block = Mage::getModel('cms/block')->load($blockId);
        }
        catch(ErrorException $e)
        {
            Mage::getSingleton('core/session')->addError('Unable to load CMS block');
            $errors = true;
        }

        //set data to block and save
        try
        {
            $block->addData($revision->getData())->save();
        }
        catch(Exception $e)
        {
            Mage::getSingleton('core/session')->addError($e->getMessage());
            $errors = true;
        }

        if (!$errors)
        {
            Mage::getSingleton('core/session')->addSuccess("Revision restored successfully");
        }

        //save new revision
        $revision->save();
        return $this;

    }

    /**
     * Deletes revision based on ID
     *
     * @param $revisionId
     * @return $this
     */
    public function deleteRevision($revisionId)
    {
        $errors = false;
        //load revision
        try
        {
            $revision = Mage::getModel('plugincompany_cmsrevisions/block')->load($revisionId);
        }
        catch(Exception $e)
        {
            Mage::getSingleton('core/session')->addError('Unable to load revision');
            $errors = true;
        }

        //delete
        if ($revision) {
            try
            {
                $revision->delete();
            }
            catch(Exception $e)
            {
                Mage::getSingleton('core/session')->addError("Unable to delete revision");
                $errors = true;
            }
        }

        if (!$errors)
        {
            Mage::getSingleton('core/session')->addSuccess("Revision deleted successfully");
        }
        return $this;
    }

    /**
     * save the revision
     *
     * @return Mage_Core_Model_Abstract
     */
    public function save()
    {
        //set all other revisions to not last revision
        //'is not last revision' set to prevent infinite loop
        if (!$this->getIsNotLastRevision()) {
            $collection = $this->getCollection()->addFieldToFilter('is_current_revision',1)->addFieldToFilter('block_id',$this->getBlockId());
            foreach ($collection as $oldRev) {
                $oldRev->setIsNotLastRevision(1)->setIsCurrentRevision(0)->save();
            };
            $this->setIsCurrentRevision(1);
        }
        return parent::save();
    }

}