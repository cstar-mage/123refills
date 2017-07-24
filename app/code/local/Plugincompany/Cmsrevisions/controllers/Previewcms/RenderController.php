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


class Plugincompany_Cmsrevisions_Previewcms_RenderController extends Mage_Core_Controller_Front_Action
{
    /**
     * Renders preview based on revision ID
     */
    public function viewAction()
    {
        $revisionId = $this->getRequest()->getParam('id');
        if (!Mage::helper('plugincompany_cmsrevisions/render')->renderPreview($this, $revisionId)) {
            $this->_forward('noRoute');
        }
    }
}