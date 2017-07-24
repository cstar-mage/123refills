<?php
class Dolphin_Brandfilter_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getBrandPrinterSeries() {
		
		$_category  = Mage::registry('current_category');
		$products = Mage::getModel('catalog/product')
					->getCollection()
					->addAttributeToSelect('type_id')
					->addAttributeToSelect('printer_series')
					->addAttributeToFilter('type_id', array('eq' => 'grouped'))
					->addCategoryFilter($_category)
					->addAttributeToSort('printer_series', 'ASC');;
		
		/* $name='printer_series';
		$attributeInfo = Mage::getResourceModel('eav/entity_attribute_collection')->setCodeFilter($name)->getFirstItem();
		$attributeId = $attributeInfo->getAttributeId();
		$attribute = Mage::getModel('catalog/resource_eav_attribute')->load($attributeId);
		$attributeOptions = $attribute ->getSource()->getAllOptions(false);
		return $attributeOptions; // for all options */
		$printer_series = array();
		foreach ($products as $product) {
			$printer_series[$product->getData('printer_series')] = array('value'=>$product->getData('printer_series'),'label'=>$product->getAttributeText('printer_series'));
		}
		
		return $printer_series;
	}

	public function getProductAttributeValue($product, $attributeCode)
    {
        $store = Mage::app()->getStore()->getStoreId();
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        $eavAttributeTableName = $resource->getTableName('eav/attribute');
        $eavAttributeOptionTableName = $resource->getTableName('eav/attribute_option');
        $eavAttributeOptionValueTableName = $resource->getTableName('eav/attribute_option_value');

        $attrValue = Mage::getResourceModel('catalog/product')->getAttributeRawValue($product->getId(), $attributeCode, 0);

        $query = <<<SQL
            SELECT EAOV.*
            FROM $eavAttributeTableName EA
            LEFT JOIN $eavAttributeOptionTableName EAO ON EAO.ATTRIBUTE_ID = EA.ATTRIBUTE_ID
            LEFT JOIN $eavAttributeOptionValueTableName EAOV ON EAOV.OPTION_ID = EAO.OPTION_ID
            WHERE EA.ATTRIBUTE_CODE = '$attributeCode' AND EAOV.OPTION_ID = $attrValue
            AND EAOV.STORE_ID = 0
SQL;
        $results = $readConnection->fetchAll($query);

        $attrTextValue = '';
        foreach ($results as $row) {
            if ($row['option_id'] == $attrValue) {
                $attrTextValue = $row['value'];
                break;
            }
        }

        return $attrTextValue;
    }
}