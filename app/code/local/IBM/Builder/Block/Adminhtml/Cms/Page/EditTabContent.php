<?php

class IBM_Builder_Block_Adminhtml_Cms_Page_EditTabContent extends Mage_Adminhtml_Block_Cms_Page_Edit_Tab_Content
{
    protected function getStoreUrl($type = Mage_Core_Model_Store::URL_TYPE_LINK)
    {
        return Mage::getBaseUrl($type, array('_secure' => $this->getRequest()->isSecure()));
    }

    protected function _toHtml()
    {
        $data = array(
            'label'   => Mage::helper('core')->__('IBM Builder'),
            'onclick' => 'IBMEditor.showEditor();'
        );
        $buttonBlockHtml = Mage::app()->getLayout()->createBlock('adminhtml/widget_button')
            ->setData($data)
            ->setId('open_ibm_builder_editor')
            ->toHtml();

        $getBaseUrlJsHtml = '
            <script type="text/javascript">
                function getBaseUrl() { return \''. $this->getStoreUrl() .'\'; };
                function getBaseJsUrl() { return \''. $this->getStoreUrl(Mage_Core_Model_Store::URL_TYPE_JS) .'\'; };
            </script>
        ';

        return parent::_toHtml() .
            '<div id="builder_button_container" style="display: none;">'.$buttonBlockHtml.'</div>' . $getBaseUrlJsHtml .
            Mage::app()->getLayout()->createBlock('IBMBuilder/Adminhtml_Editor_Content')->_toHtml()
            ;
    }
}