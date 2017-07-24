<?php

class IBM_Builder_Model_Observer
{
    /**
     * Add scripts and styles to admin part of Builder
     * @param Varien_Event_Observer $observer
     */
    public function eventCmsPageEditAction(Varien_Event_Observer $observer)
    {
        Mage::app()->getLayout()->getBlock('head')->addJs('lib/jquery/jquery-1.10.2.min.js');
        Mage::app()->getLayout()->getBlock('head')->addJs('ibmbuilder/jqueryui/jquery-ui.js');

        Mage::app()->getLayout()->getBlock('head')->addJs('ibmbuilder/builder_storage.js');
        Mage::app()->getLayout()->getBlock('head')->addJs('ibmbuilder/main.js');
        Mage::app()->getLayout()->getBlock('head')->addJs('ibmbuilder/main_backend.js');
        Mage::app()->getLayout()->getBlock('head')->addJs('ibmbuilder/editor.js');
        Mage::app()->getLayout()->getBlock('head')->addJs('ibmbuilder/editor_css.js');
        Mage::app()->getLayout()->getBlock('head')->addJs('ibmbuilder/builder_history.js');
        Mage::app()->getLayout()->getBlock('head')->addJs('ibmbuilder/api_manager.js');

        // Popline Plugin for live text editing
        Mage::app()->getLayout()->getBlock('head')->addJs('ibmbuilder/popline/jquery.popline.js');
        Mage::app()->getLayout()->getBlock('head')->addJs('ibmbuilder/popline/plugins/jquery.popline.textcolor.js');
        Mage::app()->getLayout()->getBlock('head')->addJs('ibmbuilder/popline/plugins/jquery.popline.fontfamily.js');
        Mage::app()->getLayout()->getBlock('head')->addJs('ibmbuilder/popline/plugins/jquery.popline.fontsize.js');
        Mage::app()->getLayout()->getBlock('head')->addJs('ibmbuilder/popline/plugins/jquery.popline.subsuper.js');
        Mage::app()->getLayout()->getBlock('head')->addJs('ibmbuilder/popline/plugins/jquery.popline.blockformat.js');
        Mage::app()->getLayout()->getBlock('head')->addJs('ibmbuilder/popline/plugins/jquery.popline.blockquote.js');
        Mage::app()->getLayout()->getBlock('head')->addJs('ibmbuilder/popline/plugins/jquery.popline.justify.js');
        Mage::app()->getLayout()->getBlock('head')->addJs('ibmbuilder/popline/plugins/jquery.popline.link.js');
        Mage::app()->getLayout()->getBlock('head')->addJs('ibmbuilder/popline/plugins/jquery.popline.list.js');
        Mage::app()->getLayout()->getBlock('head')->addJs('ibmbuilder/popline/plugins/jquery.popline.decoration.js');
        // --------------------------------------

        Mage::app()->getLayout()->getBlock('head')->addJs('ibmbuilder/tools/links.js');
        Mage::app()->getLayout()->getBlock('head')->addJs('ibmbuilder/tools/images.js');

        Mage::app()->getLayout()->getBlock('head')->addJs('ibmbuilder/setequalheights.js');
        Mage::app()->getLayout()->getBlock('head')->addJs('ibmbuilder/webfont.js');
        Mage::app()->getLayout()->getBlock('head')->addJs('ibmbuilder/builder_functions.js');
        Mage::app()->getLayout()->getBlock('head')->addJs('ibmbuilder/EQCSS.min.js');

        Mage::app()->getLayout()->getBlock('head')->addJs('ibmbuilder/globalize.js');
        Mage::app()->getLayout()->getBlock('head')->addJs('ibmbuilder/globalize.culture.de-DE.js');
        Mage::app()->getLayout()->getBlock('head')->addJs('ibmbuilder/jquery.mousewheel.js');

        Mage::app()->getLayout()->getBlock('head')->addCss('ibmbuilder/css/editor.css');
        Mage::app()->getLayout()->getBlock('head')->addCss('ibmbuilder/css/popline.css');
        Mage::app()->getLayout()->getBlock('head')->addCss('ibmbuilder/css/jquery-ui.css');

        // Scripts and styles from frontend
        Mage::app()->getLayout()->getBlock('head')->addCss('../../../frontend/base/default/css/ibmbuilder/bootstrap-grid.css');
        Mage::app()->getLayout()->getBlock('head')->addCss('../../../frontend/base/default/css/ibmbuilder/general_site_style.css');

        Mage::app()->getLayout()->getBlock('head')->addCss('../../../frontend/base/default/css/ibmbuilder/royalslider/royalslider.css');
        Mage::app()->getLayout()->getBlock('head')->addCss('../../../frontend/base/default/css/ibmbuilder/royalslider/white.css');

        Mage::app()->getLayout()->getBlock('head')->addCss('../../../frontend/base/default/css/ibmbuilder/jquery-ui.css');
    }

    /**
     * Add scripts and styles to frontend for Builder`s blocks
     * @param Varien_Event_Observer $observer
     */
    public function eventGenerateBlocksAfter(Varien_Event_Observer $observer)
    {
        if ($observer->getAction()->getRequest()->getControllerModule() == 'Mage_Cms') {
            Mage::app()->getLayout()->getBlock('head')->addCss('css/ibmbuilder/bootstrap-grid.css');
            Mage::app()->getLayout()->getBlock('head')->addCss('css/ibmbuilder/general_site_style.css');
            Mage::app()->getLayout()->getBlock('head')->addCss('css/ibmbuilder/layout_modification.css');
            Mage::app()->getLayout()->getBlock('head')->addCss('css/ibmbuilder/royalslider/royalslider.css');
            Mage::app()->getLayout()->getBlock('head')->addCss('css/ibmbuilder/royalslider/white.css');

            Mage::app()->getLayout()->getBlock('head')->addCss('css/ibmbuilder/jquery-ui.css');

            Mage::app()->getLayout()->getBlock('head')->addJs('lib/jquery/jquery-1.10.2.min.js');
            Mage::app()->getLayout()->getBlock('head')->addJs('ibmbuilder/jqueryui/jquery-ui.js');
            Mage::app()->getLayout()->getBlock('head')->addJs('ibmbuilder/main.js');

            Mage::app()->getLayout()->getBlock('head')->addJs('ibmbuilder/setequalheights.js');
            Mage::app()->getLayout()->getBlock('head')->addJs('ibmbuilder/webfont.js');
            Mage::app()->getLayout()->getBlock('head')->addJs('ibmbuilder/builder_functions.js');
            Mage::app()->getLayout()->getBlock('head')->addJs('ibmbuilder/EQCSS.min.js');

            Mage::app()->getLayout()->getBlock('head')->addJs('ibmbuilder/globalize.js');
            Mage::app()->getLayout()->getBlock('head')->addJs('ibmbuilder/globalize.culture.de-DE.js');
            Mage::app()->getLayout()->getBlock('head')->addJs('ibmbuilder/jquery.mousewheel.js');
        }
    }
}