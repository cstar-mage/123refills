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

class Plugincompany_Cmsrevisions_Model_Cms_Block extends Mage_Cms_Model_Block {

    protected function _beforeSave(){
        $needle = 'block_id="' . $this->getBlockId() . '"';
        if (false == strstr($this->getContent(), $needle)) {
            Mage::dispatchEvent('cms_block_save_before', $this->_getEventData());
            return Mage_Core_Model_Abstract::_beforeSave();
        }
        Mage::throwException(
            Mage::helper('cms')->__('The static block content cannot contain  directive with its self.')
        );
    }
}