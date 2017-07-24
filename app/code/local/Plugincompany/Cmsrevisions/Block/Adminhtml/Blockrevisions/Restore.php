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
 * Renderer class for block revision restore field
 *
 * Class Plugincompany_Cmsrevisions_Block_Adminhtml_Blockrevisions_Restore
 */
class Plugincompany_Cmsrevisions_Block_Adminhtml_Blockrevisions_Restore extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    /**
     * Renders the restore block column
     *
     * @param Varien_Object $row
     * @return string
     */
    public function render(Varien_Object $row)
    {
        $id = $row->getData($this->getColumn()->getIndex());
        $blockId = Mage::app()->getRequest()->getParam('block_id');
        $url = Mage::helper('adminhtml')->getUrl('cmsrevisions/index/restoreblock', array('block_id'=>$blockId,'revision_id' => $id));
        $return = '<button class="scalable back" style="cursor:pointer" onclick="window.location=\'' . $url . '\'" type="button">Restore</button>';
        return $return;
    }
}