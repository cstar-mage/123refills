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
 * Observer class for hooking into CMS events
 *
 * Class Plugincompany_Cmsrevisions_Model_Observer
 */
class Plugincompany_Cmsrevisions_Model_Observer
{
    /**
     * Before page save, revision data is saved also
     */
    public function cmsPageSaveBefore()
    {
        $pageData = Mage::app()->getRequest()->getPost();
        $userId = Mage::getSingleton('admin/session')->getUser()->getId();
        $pageData['admin_user_id'] = $userId;
        Mage::getModel('plugincompany_cmsrevisions/page')->setData($pageData)->save();
    }

    /**
     * Before block save, revision data is saved also
     */
    public function cmsBlockSaveBefore()
    {
        $blockData = Mage::app()->getRequest()->getPost();
        $userId = Mage::getSingleton('admin/session')->getUser()->getId();
        $blockData['admin_user_id'] = $userId;
        Mage::getModel('plugincompany_cmsrevisions/block')->setData($blockData)->save();
    }

    /**
     * Adds Revision tab to CMS Page page
     *
     * @param Varien_Event_Observer $observer
     */
    public function coreBlockAbstractToHtmlBefore(Varien_Event_Observer $observer)
    {
        $block = $observer->getBlock();
        if ($block instanceof Mage_Adminhtml_Block_Cms_Page_Edit_Tabs) {
            $block->addTab('revisions', array(
                'label'     => Mage::helper('catalog')->__('Revisions'),
                'url'       => Mage::helper('adminhtml')->getUrl('cmsrevisions/index/viewpagerevisions/', array('_current' => true)),
                'class'     => 'ajax',
            ));
        }

    }

}