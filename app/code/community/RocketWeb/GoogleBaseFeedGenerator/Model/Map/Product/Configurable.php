<?php

/**
 * RocketWeb
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category  RocketWeb
 * @package   RocketWeb_GoogleBaseFeedGenerator
 * @copyright Copyright (c) 2012 RocketWeb (http://rocketweb.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author    RocketWeb
 */
class RocketWeb_GoogleBaseFeedGenerator_Model_Map_Product_Configurable extends RocketWeb_GoogleBaseFeedGenerator_Model_Map_Product_Abstract
{

    protected $_assoc_ids;
    protected $_assocs;
    protected $_cache_configurable_attribute_codes;

    public function _beforeMap()
    {
        if (!empty($this->_assocs) || $this->isSkip()) {
            return $this;
        }

        parent::_beforeMap();

        $this->_assocs = array();
        $stockStatusFlag = false;
        $stockStatus = false;

        foreach ($this->getAssocIds() as $assocId) {

            $is_skip = false;
            $assoc = Mage::getModel('catalog/product');
            $assoc->setStoreId($this->getStoreId());
            $assoc->getResource()->load($assoc, $assocId);
            $assoc->setData('quantity', 0);

            if ($this->getGenerator()->getData('verbose')) {
                echo $this->getGenerator()->formatMemory(memory_get_usage(true)) . " - Configurable non-apparel associated SKU " . $assoc->getSku() . ", ID " . $assoc->getId() . "\n";
            }

            $stock = $this->getConfig()->getOutOfStockStatus();

            if (!$this->getConfigVar('use_default_stock', 'columns')) {
                $stock_attribute = $this->getGenerator()->getAttribute($this->getConfigVar('stock_attribute_code', 'columns'));
                if ($stock_attribute === false) {
                    Mage::throwException(sprintf('Couldn\'t find attribute \'%s\'.', $this->getConfigVar('stock_attribute_code', 'columns')));
                }

                $stock = trim(strtolower($this->getAttributeValue($assoc, $stock_attribute)));
                if (array_search($stock, $this->getConfig()->getAllowedStockStatuses()) === false) {
                    $stock = $this->getConfig()->getOutOfStockStatus();
                }
            } else {
                $stockItem = Mage::getModel('cataloginventory/stock_item');
                $stockItem->setStoreId($this->getStoreId());
                $stockItem->getResource()->loadByProductId($stockItem, $assoc->getId());
                $stockItem->setOrigData();

                if ($stockItem->getId() && $stockItem->getIsInStock()) {
                    $assoc->setData('quantity', $stockItem->getQty());
                    $stock = $this->getConfig()->getInStockStatus();
                }

                // Clear stockItem memory
                unset($stockItem->_data);
                $this->getTools()->clearNestedObject($stockItem);
            }

            // Skip assoc considering the appropriate stock status
            if (!$this->getConfigVar('add_out_of_stock', 'configurable_products') && $stock != $this->getConfig()->getInStockStatus()) {
                $is_skip = true;
                if ($this->getConfigVar('log_skip')) {
                    $this->log(sprintf("product id %d sku %s, configurable item, skipped - out of stock", $assocId, $assoc->getSku()));
                }
            }

            if (!$is_skip) {
                $this->_assocs[$assocId] = $assoc;
            }

            // Set stock status of the current item and check if the status has changed
            if ($stockStatus != false && $stock != $stockStatus) {
                $stockStatusFlag = true;
            }
            $stockStatus = $stock;
        }

        // Set configurable stock status if all assocs have the same stock status, only for default stocks
        if ($this->getConfigVar('use_default_stock', 'columns') && $stockStatus && !$stockStatusFlag) {
            $this->setAssociatedStockStatus($stockStatus);
            if ($stockStatus == $this->getConfig()->getOutOfStockStatus() && !$this->getConfigVar('add_out_of_stock', 'filters')) {
                $this->setSkip(sprintf("product id %d sku %s, configurable, skipped - out of stock.", $this->getProduct()->getId(), $this->getProduct()->getSku()));
            }
        }

        // Set associated prices
        $this->setCacheAssociatedPrices();

        $assocMapArr = array();
        foreach ($this->_assocs as $assoc) {
            $assocMap = $this->getAssocMapModel($assoc);
            if ($assocMap->checkSkipSubmission(true)->isSkip()) {
                continue;
            }
            $assocMapArr[$assoc->getId()] = $assocMap;
        }

        $this->setAssocMaps($assocMapArr);
        return $this;
    }

    public function map()
    {
        $rows = array();
        $parentRow = null;
        $this->_beforeMap();

        if ($this->getConfig()->isAllowConfigurableMode($this->getStoreId())) {
            if (!$this->isSkip()) {

                // simulate parent::map() without clearing associated_maps from memory, as associated more could be on.
                $row = parent::_map();
                reset($row); $parentRow = current($row);
                $this->_checkEmptyColumns($parentRow);

                // remove parent and skipping flag so that the associated items could still be processed.
                if ($this->isSkip()) {
                    $parentRow = null;
                }
            }
        }

        if ($this->getConfig()->isAllowConfigurableAssociatedMode($this->getStoreId()) && !$this->hasSkipAssocs() && $this->hasAssocMaps()) {
            foreach ($this->getAssocMaps() as $assocMap) {

                $row = $assocMap->map();
                reset($row); $row = current($row);

                if (!$this->getTools()->isModuleEnabled('OrganicInternet_SimpleConfigurableProducts')) {
                    // [Default Magento] Overwrite price with configurable price if no option price set.
                    if ($assocMap->getProduct()->hasOptionPrice() && !$assocMap->getProduct()->getOptionPrice() && $parentRow) {
                        $row['price'] = $parentRow['price'];
                    }
                }

                if (!$assocMap->isSkip()) {
                    $rows[] = $row;
                }
            }
        }

        // Fill in parent columns specified in $inherit_columns with values list from associated items
        if (!is_null($parentRow)) {
            $this->mergeVariantValuesToParent($parentRow, $rows);
            array_unshift($rows, $parentRow);
        }

        // if any of the associated not skipped, force add them to the feed
        if (count($rows)) {
            $this->unSkip();
        }

        return $this->_afterMap($rows);
    }

    /**
     * @param $rows
     * @return array
     */
    public function _afterMap($rows)
    {
        // Free some memory
        if (is_array($this->_assocs)) {
            foreach ($this->_assocs as $assoc) {
                if ($assoc->getEntityid()) {
                    $this->getTools()->clearNestedObject($assoc);
                }
            }
            $this->flushCacheAssociatedPrice();
        }

        $this->_cache_map_values = array();
        return $rows;
    }

    /**
     * Array with associated products ids in current store.
     *
     * @return array
     */
    public function getAssocIds()
    {
        if (is_null($this->_assoc_ids)) {
            $this->_assoc_ids = $this->loadAssocIds($this->getProduct(), $this->getStoreId());
        }
        return $this->_assoc_ids;
    }

    /**
     * @param Mage_Catalog_Model_Product $product
     * @return RocketWeb_GoogleBaseFeedGenerator_Model_Map_Product_Abstract
     */
    protected function getAssocMapModel($product)
    {
        $params = array(
            'store_code' => $this->getData('store_code'),
            'store_id' => $this->getData('store_id'),
            'website_id' => $this->getData('website_id'),
        );

        $productMap = Mage::getModel('googlebasefeedgenerator/map_product_associated', $params);
        $productMap->setProduct($product)
            ->setColumnsMap($this->_columns_map)
            ->setEmptyColumnsReplaceMap($this->getEmptyColumnsReplaceMap())
            ->setParentMap($this)
            ->setCacheAssociatedPrices($this->getCacheAssociatedPrices())
            ->initialize();

        return $productMap;
    }

    /**
     * @param array $params
     * @return string
     */
    protected function mapDirectiveShippingWeight($params = array())
    {
        $map = $params['map'];
        $map['attribute'] = 'weight';
        $unit = $map['param'];

        // @var $product Mage_Catalog_Model_Product
        $product = $this->getProduct();

        // Get attribute value
        $weight_attribute = $this->getGenerator()->getAttribute($map['attribute']);
        if ($weight_attribute === false) {
            Mage::throwException(sprintf('Couldn\'t find attribute \'%s\'.', $map['attribute']));
        }

        $weight = $this->getAttributeValue($product, $weight_attribute);
        if ($weight != "" && strpos($weight, $unit) === false) {
            $weight = number_format((float)$weight, 2). ' '. $unit;
        }

        // Configurable doesn't have weight of it's own.
        if ($weight == "") {
            $min_price = PHP_INT_MAX;
            foreach ($this->_assocs as $assoc) {
                if ($this->getCacheAssociatedPrice($assoc->getId()) !== false && $min_price > $this->getCacheAssociatedPrice($assoc->getId())) {
                    $weight = $this->getAttributeValue($assoc, $weight_attribute);
                    break;
                }
            }
        }

        if ($weight != "") {
            if (strpos($weight, $unit) === false) {
                $weight = number_format((float)$weight, 2). ' '. $unit;
            }
        }

        return $this->cleanField($weight);
    }

    public function getPrice($product = null)
    {
        $price = 0;
        if (is_null($product)) {
            $product = $this->getProduct();
        }

        if ($price <= 0) {
            $price = $product->getPrice();
        }

        if ($price <= 0) {
            $this->setSkip(sprintf("product id %d sku %s, configurable associated, skipped - can't determine the minimal price: '%s'.", $product->getId(), $product->getSku(), $price));
        }

        return $price;
    }

    /**
     * @return float
     */
    public function calcMinimalPrice($product)
    {
        $price = 0.0;
        $minimal_price = PHP_INT_MAX;
        foreach ($this->_assocs as $assoc) {
            if ($minimal_price > $this->getCacheAssociatedPrice($assoc->getId())) {
                $minimal_price = $this->getCacheAssociatedPrice($assoc->getId());
            }
        }
        if ($minimal_price < PHP_INT_MAX) {
            $price = $minimal_price;
        }

        return $price;
    }

    /**
     * @return array()
     */
    public function getOptionCodes($assoc_id = null)
    {
        if (is_null($this->_cache_configurable_attribute_codes)) {
            $this->_cache_configurable_attribute_codes = $this->getTools()
                ->getOptionCodes($this->getProduct()->getId());
        }
        return $this->_cache_configurable_attribute_codes;
    }

    /**
     * @param array $params
     * @return string
     */
    protected function mapDirectiveQuantity($params = array())
    {
        $cell = $this->getInventoryCount();

        // If Qty not set at parent item, summarize it from associated items
        if ($params['map']['param'] == RocketWeb_GoogleBaseFeedGenerator_Model_Source_Directive_Product_Quantity::ITEM_SUM_DEFAULT_QTY) {
            $qty = 0;
            foreach ($this->_assocs as $assoc) {
                $qty += $assoc->getData('quantity');
            }
            $cell = $qty ? $qty : $cell;
        }

        $cell = sprintf('%d', $cell);
        $this->_findAndReplace($cell, $params['map']['column']);
        return $cell;
    }

    /**
     * @param array $params
     * @return string
     */
    protected function mapDirectiveAvailability($params = array())
    {
        // Set the computed configurable stock status
        if ($this->hasAssociatedStockStatus() && $this->getAssociatedStockStatus() == $this->getConfig()->getOutOfStockStatus()) {
            return $this->cleanField($this->getAssociatedStockStatus(), $params);
        }

        return parent::mapDirectiveAvailability($params);
    }
}