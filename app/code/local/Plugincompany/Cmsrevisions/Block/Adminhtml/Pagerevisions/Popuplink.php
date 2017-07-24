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
     * Renders the Preview CMS Page section and dropdown
     *
     * @param Varien_Object $row
     * @return string
 */
class Plugincompany_Cmsrevisions_Block_Adminhtml_Pagerevisions_Popuplink extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $id = $row->getData($this->getColumn()->getIndex());
        $return = '<select style="float:left;margin-left:10px">';
        $storeViews = Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true);
        unset($storeViews[0]);
        foreach ($storeViews as $store) {
            $label = $store['label'];
            $return .= "<optgroup label='$label'>";
            if (!empty($store['value']) && is_array($store['value'])) {
                $return .= $this->getChildValues($store['value'],$id);
            }
            $return .= '</optgroup>';
        }
        $return .= '</select>';

        $return .= '<button class="scalable back" onclick="previewcms(this)" style="float:left;margin-left:5px;" class="submitpreview" type="button">Preview</button>';


        return $return;
    }

    /**
     * Returns the store dropdown HTML
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
            $url = Mage::app()->getStore($storeId)->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK) . 'previewcms/render/view/id/' . $id . '?___store=' . Mage::app()->getStore($storeId)->getCode();
            $return .= '<option value="'. $url . '">' . $value['label'] . '</option>';
        }
        return $return;
    }
}