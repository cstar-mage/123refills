<?php

class IBM_Builder_Block_Adminhtml_Editor_Content extends Mage_Adminhtml_Block_Widget
{
    protected function _construct()
    {
        parent::_construct();

        $this->setTemplate('ibmbuilder/editor/content.phtml');
    }
    
    public function getImageEditorOnClickUrl()
    {
        return Mage::getSingleton('adminhtml/url')->getUrl('*/cms_wysiwyg_images/index');
    }

    public function getPageId()
    {
        $pageId = $this->getRequest()->getParam('page_id');
        return Mage::getModel('cms/page')->load($pageId)->getIdentifier();
    }

    public function getBackgroundColor()
    {
        $color = '#f5f5f5';
        if (class_exists('Ideal_Evolved_Block_Evolved')) {
            $theme = array();
            try {
                $evolved = new Ideal_Evolved_Block_Evolved();
                $theme = $evolved->getConfig();
            } catch (Exception $e) {}
            isset($theme['general_main_color']) && $theme['general_main_color'] != '' && $color = $theme['general_main_color'];
        }
        return $color;
    }
}