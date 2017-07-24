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
class Plugincompany_Cmsrevisions_Block_Adminhtml_Pagerevisions_Delete extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $id = $row->getData($this->getColumn()->getIndex());
        $pageId = Mage::app()->getRequest()->getParam('page_id');
        $url = Mage::helper('adminhtml')->getUrl('cmsrevisions/index/deletepage', array('page_id'=>$pageId,'revision_id' => $id));

        $return = '';
        if (!$row->getData('is_current_revision')) {
            $return = '<button class="scalable delete" style="cursor:pointer" onclick="confirmDelete(\'' . $url . '\')" type="button">Delete</button>';
        }
        return $return;
    }
}