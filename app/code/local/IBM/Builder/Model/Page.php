<?php

class IBM_Builder_Model_Page extends Mage_Core_Model_Abstract
{
    const BUILDER_PREVIEW_PAGE_IDENTIFIER = 'builder_temporary_preview_page';

    public function preparePreviewPage($identifier, $builderContent)
    {
        $pageCollection = Mage::getModel('Cms/Page')->getCollection()->addFieldToFilter('identifier', $identifier);
        
        /** @var Mage_Cms_Model_Page $page */
        $page = $pageCollection->getFirstItem();
        
        $temporaryPage = $this->getTemporaryPage();
//        $temporaryPageId = $this->getMaxId() + 1;

        $pageData = $page->getData();
        unset($pageData['identifier']);
        // todo
        unset($pageData['page_id']);

        $temporaryPage->setData($pageData);
        $temporaryPage->setContent($builderContent);
        // todo
//        $temporaryPage->setId($temporaryPageId);
        $temporaryPage->setIdentifier(self::BUILDER_PREVIEW_PAGE_IDENTIFIER);
        $temporaryPage->setStoreId(0);

        $temporaryPage->save();
    }

    public function delete()
    {
        $this->getTemporaryPage();
    }

    private function getTemporaryPage()
    {
        $collection = Mage::getModel('Cms/Page')->getCollection()->addFieldToFilter('identifier', array('eq'=> self::BUILDER_PREVIEW_PAGE_IDENTIFIER));
        
        if ($collection->getSize() > 0) {
            $collection->getFirstItem()->delete();
        }
        
        $page = Mage::getModel('Cms/Page');

        return $page;
    }

    private function getMaxId()
    {
        $resource = Mage::getSingleton('core/resource');
        $tableName = $resource->getConnection('core_read')->getTableName('cms_page');
        $db = $resource->getConnection('core_read');
        $result = $db->raw_fetchRow("SELECT MAX(`page_id`) as LastID FROM `{$tableName}`");
        return $result['LastID'];
    }
}