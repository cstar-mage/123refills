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
 * Page Revision Model
 *
 * Class Plugincompany_Cmsrevisions_Model_Page
 */
class Plugincompany_Cmsrevisions_Model_Page extends Mage_Core_Model_Abstract
{

    /**
     * init
     */
    protected function _construct()
    {
        $this->_init('plugincompany_cmsrevisions/page');
    }


    /**
     * restores revision based on pageId and revisionId
     *
     * @param $pageId
     * @param $revisionId
     * @return $this
     */
    public function restoreRevision($pageId,$revisionId)
    {
        $errors = false;
        //load revision
        try
        {
            $revision = Mage::getModel('plugincompany_cmsrevisions/page')->load($revisionId);
        }
        catch(Exception $e)
        {
            Mage::getSingleton('core/session')->addError('Unable to load revision');
            $errors = true;
        }

        //load cms page
        try
        {
            $page = Mage::getModel('cms/page')->load($pageId);
        }
        catch(ErrorException $e)
        {
            Mage::getSingleton('core/session')->addError('Unable to load CMS page');
            $errors = true;
        }

        //set data to page and save
        try
        {
          $page
              ->setData('stores',$page->getData('store_id'))
              ->addData($revision->getData())
              ->save();
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

        $revision->save();
        return $this;
    }


    /**
     * Deletes the revision
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
            $revision = Mage::getModel('plugincompany_cmsrevisions/page')->load($revisionId);
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
     * saves the revision
     *
     * @return Mage_Core_Model_Abstract
     */
    public function save()
    {
        if (!$this->getIsNotLastRevision()) {
            $collection = $this->getCollection()->addFieldToFilter('is_current_revision',1)->addFieldToFilter('page_id',$this->getPageId());
            foreach ($collection as $oldRev) {
                $oldRev->setIsNotLastRevision(1)->setIsCurrentRevision(0)->save();
            };
            $this->setIsCurrentRevision(1);
        }
        return parent::save();
    }

}