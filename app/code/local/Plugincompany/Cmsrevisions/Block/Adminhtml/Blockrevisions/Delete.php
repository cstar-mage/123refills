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
 * Renderer for the delete block button in block revision grid
 *
 * Class Plugincompany_Cmsrevisions_Block_Adminhtml_Blockrevisions_Delete
 */
class Plugincompany_Cmsrevisions_Block_Adminhtml_Blockrevisions_Delete extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    /**
     * Renders the delete button
     *
     * @param Varien_Object $row
     * @return string
     */
    public function render(Varien_Object $row)
    {
        $id = $row->getData($this->getColumn()->getIndex());
        $blockId = Mage::app()->getRequest()->getParam('block_id');
        $url = Mage::helper('adminhtml')->getUrl('cmsrevisions/index/deleteblock', array('block_id'=>$blockId,'revision_id' => $id));

        if (!$row->getData('is_current_revision')) {
            $return = '<button class="scalable delete" style="cursor:pointer" onclick="confirmDelete(\'' . $url . '\')" type="button">Delete</button>';
        }
        return $return;
    }
}