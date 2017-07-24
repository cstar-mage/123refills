<?php

class Gfe_SphinxSearch_Model_Observer
{
    public function reindex()
    {
        Mage::getModel('sphinxsearch/engine')->reindex();
    }
    
    public function onIndexProcessComplete()
    {
        $storeId = Mage_Core_Model_App::DISTRO_STORE_ID;

        $readConnection = Mage::getSingleton('core/resource')->getConnection('core_read');
        $TableName = $readConnection->getTableName('catalog_product_flat_' . $storeId);

        $result = $readConnection->query("SELECT * FROM `{$TableName}`");

        $writeConnection = Mage::getSingleton('core/resource')->getConnection('core_write');
        $data	= array();

        foreach ($result->fetchAll() as &$index) {
            $entityId = $index['entity_id'];

            $processedIndex = Mage::helper('sphinxsearch')->prepareIndexdata($index, '|');

            $data[] = array(
                'product_id'      => (int)$entityId,
                'store_id'        => $storeId,
                'data_index'      => $processedIndex['data_index'],
                'name'            => $processedIndex['name'],
                'name_attributes' => $index['name_attributes'],
                'category'        => $processedIndex['category'],
            );
        }

        if ($data) {
            $writeConnection->insertOnDuplicate('sphinx_catalogsearch_fulltext', $data, array('data_index', 'name', 'name_attributes', 'category'));
        }

        return $this;
    }
}