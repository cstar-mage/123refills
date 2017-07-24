<?php 
class Ideal_UrlRewriteImporter_Model_Observer {

    public function injectImportUrlRewritesButton($observer) {
        if ($observer->getEvent()->getBlock() instanceof Mage_Adminhtml_Block_Urlrewrite) {
            $observer->getEvent()->getBlock()->addButton('importProductRewrites', array(
                'label' => Mage::helper('catalog')->__('Import URL Rewrites'),
                'onclick' => "setLocation('{$observer->getEvent()->getBlock()->getUrl('*/Ideal_UrlRewriteImporter_Import/new')}')",
                'class' => 'add'
            ), 0, 2);
			
			$observer->getEvent()->getBlock()->addButton('checkProductRewrites', array(
				'label' => Mage::helper('catalog')->__('Check/Repair URL Rewrites'),
				'onclick' => "setLocation('{$observer->getEvent()->getBlock()->getUrl('*/Ideal_UrlRewriteImporter_Import/checkrepair')}')",
				'class' => 'add'
			), 0, 1);
        }
    }
}
