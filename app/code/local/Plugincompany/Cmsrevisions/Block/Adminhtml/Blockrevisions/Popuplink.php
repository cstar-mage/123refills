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
 * Renderer for loading blockdata into block editor
 *
 * Class Plugincompany_Cmsrevisions_Block_Adminhtml_Blockrevisions_Popuplink
 */
class Plugincompany_Cmsrevisions_Block_Adminhtml_Blockrevisions_Popuplink extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    /**
     * Renders the load revision button
     *
     * @param Varien_Object $row
     * @return string
     */
    public function render(Varien_Object $row)
    {
        $id = $row->getData($this->getColumn()->getIndex());
        $url = Mage::helper('adminhtml')->getUrl('cmsrevisions/index/retrieveblockdata',array('block_revision_id' => $id));
        $return = '<button class="scalable back" onclick="loadRevisionBlockData(\'' . $url . '\')" type="button">Load in editor</button>';
        return $return;
    }

    /**
     * Returns the option HTML
     *
     * @param $values
     * @param $id
     * @return string
     */
    public function getChildValues($values,$id)
    {
        $return = '';
        foreach ($values as $value) {
            $storeId = $value['value'];
            $url = Mage::app()->getStore($storeId)->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK) . 'previewcms/render/block/id/' . $id . '?___store=' . Mage::app()->getStore($storeId)->getCode();
            $return .= '<option value="'. $url . '">' . $value['label'] . '</option>';
        }
        return $return;
    }
}