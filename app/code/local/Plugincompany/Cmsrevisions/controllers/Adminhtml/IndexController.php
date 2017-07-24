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
 * Admin controller for revision management
 *
 * Class Plugincompany_Cmsrevisions_Adminhtml_IndexController
 */
class Plugincompany_Cmsrevisions_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Page revisions grid
     *
     */
    public function viewpagerevisionsAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Restores page revision based on page_id and revision_id params
     */
    public function restorepageAction()
    {
        $pageId = $this->getRequest()->getParam('page_id');
        $revisionId = $this->getRequest()->getParam('revision_id');
        $userId = Mage::getSingleton('admin/session')->getUser()->getId();
        Mage::getModel('plugincompany_cmsrevisions/page')->restoreRevision($pageId,$revisionId,$userId);
        $this->_redirect('adminhtml/cms_page/edit', array('_current' => true));
    }

    /**
     * Deletes page revision based on revision_id
     */
    public function deletepageAction()
    {
        $revisionId = $this->getRequest()->getParam('revision_id');
        Mage::getModel('plugincompany_cmsrevisions/page')->deleteRevision($revisionId);
        $this->_redirect('adminhtml/cms_page/edit', array('_current' => true));
    }

    /**
     * restores block revision based on block_id and revision_id
     */
    public function restoreblockAction()
    {
        $blockId = $this->getRequest()->getParam('block_id');
        $revisionId = $this->getRequest()->getParam('revision_id');
        $userId = Mage::getSingleton('admin/session')->getUser()->getId();
        Mage::getModel('plugincompany_cmsrevisions/block')->restoreRevision($blockId,$revisionId,$userId);
        $this->_redirect('adminhtml/cms_block/edit', array('_current' => true));
    }

    /**
     * deletes block revision based on revision_id
     */
    public function deleteblockAction()
    {
        $revisionId = $this->getRequest()->getParam('revision_id');
        Mage::getModel('plugincompany_cmsrevisions/block')->deleteRevision($revisionId);
        $this->_redirect('adminhtml/cms_block/edit', array('_current' => true));
    }

    /**
     * retrieves block revision data JSON
     * Based on block_revision_id param
     */
    public function retrieveblockdataAction(){
        $blockRevisionId = $this->getRequest()->getParam('block_revision_id');
        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody(
            Mage::helper('core')->jsonEncode(Mage::getModel('plugincompany_cmsrevisions/block')->load($blockRevisionId)->getData())
        );
    }

    protected function _isAllowed()
    {
        return true;
    }
}