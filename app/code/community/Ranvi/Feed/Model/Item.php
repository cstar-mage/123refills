<?php
class Ranvi_Feed_Model_Item extends Mage_Core_Model_Abstract
{
    protected $_productCollection;
    protected $_categoryCollection;
    protected $_parentProductsCache = array();

    public function _construct()
    {
        parent::_construct();
        $this->_init('ranvi_feed/item');
    }

    public function getBaseUrl($useRewrites = false)
    {
        $baseUrl = Mage::app()
            ->getStore($this->getStoreId())
            ->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB, false);
        if (!$useRewrites) {
            $baseUrl .= 'index.php/';
        }
        return $baseUrl;
    }

    public function getProductUrl($product, $baseUrl)
    {
        $value = $baseUrl . $product->getUrlPath();
        return $value;
    }

    public function getCategoriesCollection()
    {
        if (is_null($this->_categoryCollection)) {
            $this->_categoryCollection = Mage::getResourceModel('catalog/category_collection')->addAttributeToSelect('name');
        }
        return $this->_categoryCollection;
    }

    public function getParentProduct(Varien_Object $product, $collection = null)
    {
        $childId = $product->getId();
        if (!isset($this->_parentProductsCache[$childId])) {
            $connection = Mage::getSingleton('core/resource')->getConnection('read');
            $table = Mage::getSingleton('core/resource')->getTableName('catalog_product_relation');
            $sql = 'SELECT `parent_id` FROM ' . $table . ' WHERE `child_id` = ' . intval($childId);
            $parent_id = $connection->fetchOne($sql);
            $parent_product = null;
            if ($parent_id) {
                if ($collection) {
                    $parent_product = $collection->getItemById($parent_id);
                }
                if (!$parent_product->getId()) {
                    $parent_product = Mage::getModel('catalog/product')->load($parent_id);
                }
                $this->_parentProductsCache[$childId] = $parent_product;
            } else {
                $this->_parentProductsCache[$childId] = new Varien_Object();
            }
        }
        return $this->_parentProductsCache[$childId];
    }

    public function getRootCategory()
    {
        $category = Mage::getModel('catalog/category')->load(Mage::app()->getStore()->getRootCategoryId());
        return $category;
    }

    public function getProductsCollection($filterData = '', $current_page = 0, $length = 50)
    {
        //if (is_null($this->_productCollection) && $this->getId()){
        $collection = Mage::getModel('ranvi_feed/product_collection')->addAttributeToSelect('*');
        $collection->addStoreFilter(Mage::app()->getStore());
        /*if($length != 0){
           $collection->setPage($current_page+1, $length);
        }*/
        $fileDir = sprintf('%s/productsfeed', Mage::getBaseDir('media'));

        $collection->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
            ->addMinimalPrice()
            ->addFinalPrice()
            ->addTaxPercents()
            ->addUrlRewrite($this->getRootCategory()->getId());
        $this->addStockToCollection($collection);
        // Filter by Stock
        if ($this->getUseLayer()) {
            //   filter only in stock product
            //   addSaleableFilterToCollection is required
            //   for Configurable products to properly manage the stock

            Mage::getSingleton('cataloginventory/stock')
                ->addInStockFilterToCollection($collection);

            Mage::getSingleton('catalog/product_status')
                ->addSaleableFilterToCollection($collection);
        }

        // Filter Disabled
        if ($this->getUseDisabled()) {
            Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
            $collection->addAttributeToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED);
        }
        $this->_productCollection = $collection;
        //}
        return $this->_productCollection;
    }

    public function _beforeSave()
    {
        if (!$this->getFilename()) {
            $this->setFilename(preg_replace('/[^\w\d]/', '-', trim(strtolower($this->getName()))) . '.csv');
        }
        if (strpos($this->getFilename(), '.') === false) {
            $this->setFilename($this->getFilename() . '.csv');
        }
        if ($id = Mage::getModel('ranvi_feed/item')->load($this->getFilename(), 'filename')->getId()) {
            if ($id != $this->getId()) {
                throw new Mage_Core_Exception(Mage::helper('ranvi_feed')->__('Filename "%s" exists', $this->getFilename()));
            }
        }
        return parent::_beforeSave();
    }

    public function getDirPath()
    {
        return sprintf('%s/productsfeed', Mage::getBaseDir('media'));
    }

    public function getTempFilePath($start = '')
    {
        $filename = 'feed-gen-data-' . $this->getId() . $start . '.tmp';
        return sprintf('%s/productsfeed/%s', Mage::getBaseDir('media'), $filename);
    }

    public function writeTempFile($start, $length, $filename = '')
    {
        try {
            //echo " length ".$length;
            $filePath = $this->getTempFilePath($start);
            $fileDir = sprintf('%s/productsfeed', Mage::getBaseDir('media'));
            $hasRewriteEnabled = Mage::getStoreConfig('web/seo/use_rewrites', $this->getStoreId());
            $baseUrl = $this->getBaseUrl($hasRewriteEnabled);
            if (!file_exists($fileDir)) {
                mkdir($fileDir);
                chmod($fileDir, 0777);
            }
            if (is_dir($fileDir)) {
                switch ($this->getDelimiter()) {
                    case('comma'):
                    default:
                        $delimiter = ",";
                        break;
                    case('tab'):
                        $delimiter = "\t";
                        break;
                    case('colon'):
                        $delimiter = ":";
                        break;
                    case('space'):
                        $delimiter = " ";
                        break;
                    case('vertical pipe'):
                        $delimiter = "|";
                        break;
                    case('semi-colon'):
                        $delimiter = ";";
                        break;
                }
                switch ($this->getEnclosure()) {
                    case(1):
                    default:
                        $enclosure = "'";
                        break;
                    case(2):
                        $enclosure = '"';
                        break;
                    case(3):
                        $enclosure = ' ';
                        break;
                }
                $collection = $this->getProductsCollection();
                $collection->getSelect()->limit($length, $start);
                //echo "<br><br>Count: ". count($collection);
                $maping = json_decode($this->getContent());
                $fp = fopen($filePath, 'w');
                $codes = array();
                foreach ($maping as $col) {
                    //echo "<pre>";print_r($col);exit;
                    //if($col->type == 'attribute'){
                    $codes[] = $col->attribute_value;
                    //}
                }
                $attributes = Mage::getModel('eav/entity_attribute')
                    ->getCollection()
                    ->setEntityTypeFilter(Mage::getResourceModel('catalog/product')->getEntityType()->getData('entity_type_id'))
                    ->setCodeFilter($codes);
                $log_fp = fopen(sprintf('%s/productsfeed/%s', Mage::getBaseDir('media'), 'log-' . $this->getId() . '.txt'), 'a');
                fwrite($log_fp, date("F j, Y, g:i:s a") . ', page:' . $start . ', items selected:' . count($collection) . "\n");
                fclose($log_fp);
                $store = Mage::getModel('core/store')->load($this->getStoreId());
                $root_category = Mage::getModel('catalog/category')->load($store->getRootCategoryId());
                if (Mage::getStoreConfig('ranvi_feedpro/imagesettings/enable')) {
                    $image_width = intval(Mage::getStoreConfig('ranvi_feedpro/imagesettings/width'));
                    $image_height = intval(Mage::getStoreConfig('ranvi_feedpro/imagesettings/height'));
                } else {
                    $image_width = 0;
                    $image_height = 0;
                }
                foreach ($collection as $product) {
                    //echo "<br>Product: ".$product->getId();
                    $fields = array();
                    $category = null;
                    foreach ($product->getCategoryIds() as $id) {
                        $_category = $this->getCategoriesCollection()->getItemById($id);
                        if (is_null($category) || ($category && $_category && $category->getLevel() < $_category->getLevel())) {
                            $category = $_category;
                        }
                    }
                    if ($category) {
                        $category_path = array($category->getName());
                        $parent_id = $category->getParentId();
                        if ($category->getLevel() > $root_category->getLevel()) {
                            while ($_category = $this->getCategoriesCollection()->getItemById($parent_id)) {
                                if ($_category->getLevel() <= $root_category->getLevel()) {
                                    break;
                                }
                                $category_path[] = $_category->getName();
                                $parent_id = $_category->getParentId();
                            }
                        }
                        $product->setCategory($category->getName());
                        $product->setCategoryId($category->getEntityId());
                        $product->setCategorySubcategory(implode(' > ', array_reverse($category_path)));
                    } else {
                        $product->setCategory('');
                        $product->setCategorySubcategory('');
                    }
                    $parent_product = $this->getParentProduct($product, $collection);
                    $_prod = Mage::getModel('catalog/product')->load($product->getId());
                    foreach ($maping as $col) {
                        $value = null;
                        if ($col->attribute_value) {
                            switch ($col->attribute_value) {
                                case ('parent_sku'):
                                    if ($parent_product && $parent_product->getEntityId()) {
                                        $value = $parent_product->getSku();
                                    } else {
                                        $value = '';
                                    }
                                    break;
                                case ('price'):
                                    if (in_array($product->getTypeId(), array(Mage_Catalog_Model_Product_Type::TYPE_GROUPED, Mage_Catalog_Model_Product_Type::TYPE_BUNDLE)))
                                        $value = $store->convertPrice($product->getMinimalPrice(), false, false);
                                    else
                                        $value = $store->convertPrice($product->getPrice(), false, false);
                                    break;
                                case ('store_price'):
                                    $value = $store->convertPrice($product->getFinalPrice(), false, false);
                                    break;
                                case ('parent_url'):
                                    if ($parent_product && $parent_product->getEntityId()) {
                                        $value = $this->getProductUrl($parent_product, $baseUrl);
//                                        $value = $parent_product->getProductUrl(false);
                                    } else {
                                        $value = $this->getProductUrl($product, $baseUrl);
                                    }
                                    break;
                                case 'parent_base_image':
                                    if ($parent_product && $parent_product->getEntityId() > 0) {
                                        $_prod = Mage::getModel('catalog/product')->load($parent_product->getId());
                                    }
                                    try {
                                        if ($image_width || $image_height) {
                                            $image_url = (string)Mage::helper('catalog/image')->init($_prod, 'image')->resize($image_width, $image_height);
                                        } else {
                                            $image_url = (string)Mage::helper('catalog/image')->init($_prod, 'image');
                                        }
                                    } catch (Exception $e) {
                                        $image_url = '';
                                    }
                                    $value = $image_url;
                                    break;
                                case 'parent_description':
                                    $description = '';
                                    if ($parent_product && $parent_product->getEntityId() > 0) {
                                        $_prod = Mage::getModel('catalog/product')->load($parent_product->getId());
                                    }
                                    try {
                                        $description = $_prod->getDescription();
                                    } catch (Exception $e) {
                                        $description = '';
                                    }
                                    $value = $description;
                                    break;
                                case 'parent_product_price':
                                    if ($parent_product && $parent_product->getEntityId() > 0) {
                                        $_prod = Mage::getModel('catalog/product')->load($parent_product->getId());
                                    }
                                    try {
                                        $price = $_prod->getResource()->getAttribute('price')->getFrontend()->getValue($_prod);
                                    } catch (Exception $e) {
                                        $price = '';
                                    }
                                    $value = number_format($price);
                                    break;
                                case 'parent_product_special_price':
                                    if ($parent_product && $parent_product->getEntityId() > 0) {
                                        $_prod = Mage::getModel('catalog/product')->load($parent_product->getId());
                                    }
                                    try {
                                        $specialprice = $_prod->getResource()->getAttribute('special_price')->getFrontend()->getValue($_prod);
                                    } catch (Exception $e) {
                                        $specialprice = '';
                                    }
                                    $value = number_format($specialprice);
                                    break;
                                case 'parent_brand':
                                    $brand = '';
                                    if ($parent_product && $parent_product->getEntityId() > 0) {
                                            $_prod = Mage::getModel('catalog/product')->load($parent_product->getId());
                                        try {
                                            $brandAttr = $_prod->getResource()->getAttribute('brand');
                                            if ($brandAttr){
                                                $brand = $brandAttr->getFrontend()->getValue($_prod);
                                            }
                                        } catch (Exception $e) {
                                            $brand = '';
                                        }
                                    }
                                    $value = $brand;
                                    break;
                                case 'image_link':
                                    $url = Mage::getBaseUrl('media') . "catalog/product" . $_prod->getImage();
                                    if (!$_prod->getImage()) {
                                        if ($parent_product && $parent_product->getEntityId() > 0) {
                                            $_prod = Mage::getModel('catalog/product')->load($parent_product->getId());
                                            $url = Mage::getBaseUrl('media') . "catalog/product" . $_prod->getImage();
                                        }
                                    } else {
                                        $url = Mage::getBaseUrl('media') . "catalog/product" . $_prod->getImage();
                                    }
                                    if ($url == Mage::getBaseUrl('media') . "catalog/product" || $url == Mage::getBaseUrl('media') . "catalog/productno_selection") {
                                        $url = Mage::getBaseUrl('media') . "catalog/product/i/m/img-na-450_1.jpg";
                                    }
                                    $value = $url;
                                    break;
                                case 'parent_name':
                                    if ($parent_product && $parent_product->getEntityId() > 0) {
                                        $_prod = Mage::getModel('catalog/product')->load($parent_product->getId());
                                        $name = $_prod->getName();
                                    } else {
                                        $name = '';
                                    }
                                    $value = $name;
                                    break;
                                case('image'):
                                case('gallery'):
                                case('media_gallery'):
                                    if (!$product->hasData('product_base_image')) {
                                        try {
                                            if ($image_width || $image_height) {
                                                $image_url = (string)Mage::helper('catalog/image')->init($_prod, 'image')->resize($image_width, $image_height);
                                            } else {
                                                $image_url = (string)Mage::helper('catalog/image')->init($_prod, 'image');
                                            }
                                        } catch (Exception $e) {
                                            $image_url = '';
                                        }
                                        $product->setData('product_base_image', $image_url);
                                        $value = $image_url;
                                    } else {
                                        $value = $product->getData('product_base_image');
                                    }
                                    break;
                                case('image_2'):
                                case('image_3'):
                                case('image_4'):
                                case('image_5'):
                                    if (!$product->hasData('media_gallery_images')) {
                                        $product->setData('media_gallery_images', $_prod->getMediaGalleryImages());
                                    }
                                    $i = 0;
                                    foreach ($product->getMediaGalleryImages() as $_image) {
                                        $i++;
                                        if (('image_' . $i) == $col->attribute_value) {
                                            if ($image_width || $image_height) {
                                                $value = (string)Mage::helper('catalog/image')->init($product, 'image', $_image->getFile())->resize($image_width, $image_height);
                                            } else {
                                                $value = $_image['url'];
                                            }
                                        }
                                    }
                                    break;
                                case('url'):
                                    $value = $this->getProductUrl($product, $baseUrl);
//                                    $value = $product->getProductUrl();
                                    break;
                                case('qty'):
                                    $value = ceil((int)Mage::getModel('cataloginventory/stock_item')->loadByProduct($product)->getQty());
                                    break;
                                case('category'):
                                    $value = $product->getCategory();
                                    break;
                                case ('product_type'):
                                    $value = $product->getTypeId();
                                    break;
                                case('is_in_stock'):
//                                    $value = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product);
                                    $value = $product->getData('is_in_stock');
//                                    $value = $product->getData('is_salable');
                                    break;
                                default:
                                    if ($attribute = $attributes->getItemByColumnValue('attribute_code', $col->attribute_value)) {
                                        if ($attribute->getFrontendInput() == 'select' || $attribute->getFrontendInput() == 'multiselect') {
                                            $value = implode(', ', (array)$product->getAttributeText($col->attribute_value));
                                        } else {
                                            $value = $product->getData($col->attribute_value);
                                        }
                                    } else {
                                        $value = $product->getData($col->attribute_value);
                                    }
                                    break;
                            }
                        } else {
                            $value = '';
                        }
                        $fields[] = $value;
                    }
                    if ($enclosure != ' ') {
                        fputcsv($fp, $fields, $delimiter, $enclosure);
                    } else {
                        $this->myfputcsv($fp, $fields, $delimiter);
                    }
                    // only simple can be unset or we will lose the parents
                    if ($product->getTypeId() == 'simple') {
                        $product->clearInstance();
                    }
                }
                fclose($fp);
                foreach ($this->_parentProductsCache as $one_cache_key => $one_cache_val) {
                    if ($one_cache_val != null && $one_cache_val instanceof Mage_Core_Model_Abstract) {
                        $one_cache_val->clearInstance();
                    }
                    unset($this->_parentProductsCache[$one_cache_key]);
                    unset($one_cache_val);
                }
                $this->_parentProductsCache = array();
                $collection->clear();
                unset($collection);
                gc_collect_cycles();
            }
        } catch (Mage_Core_Exception $e) {
            //mail('___CHANGEME___','exception1',$e->getMessage());
        } catch (Exception $e) {
            Mage::logException($e);
            //mail('___CHANGEME___',' exception #2', date('r') ."\n===============================================\n". $e->getMessage() ."\n\n=========================================\n". $e->getTraceAsString() );
        }
    }

    public function generateFeed()
    {
        //ini_set("memory_limit", "-1");
        //ini_set("upload_max_filesize", "100M");
        //ini_set("post_max_size", "100M");
        //set_time_limit(intval(9999999));
        //ini_set("max_execution_time", 9999999);
        $fileDir = sprintf('%s/productsfeed', Mage::getBaseDir('media'));
        $filePath = sprintf('%s/productsfeed/%s', Mage::getBaseDir('media'), $this->getFilename());
        $logFilepath = sprintf('%s/productsfeed/%s', Mage::getBaseDir('media'), 'log-' . $this->getId() . '.txt');
        @unlink($filePath);
        @unlink($logFilepath);
        if (!file_exists($fileDir)) {
            mkdir($fileDir);
            chmod($fileDir, 0777);
        }
        if (is_dir($fileDir)) {
            switch ($this->getDelimiter()) {
                case('comma'):
                default:
                    $delimiter = ",";
                    break;
                case('tab'):
                    $delimiter = "\t";
                    break;
                case('colon'):
                    $delimiter = ":";
                    break;
                case('space'):
                    $delimiter = " ";
                    break;
                case('vertical pipe'):
                    $delimiter = "|";
                    break;
                case('semi-colon'):
                    $delimiter = ";";
                    break;
            }
            switch ($this->getEnclosure()) {
                case(1):
                default:
                    $enclosure = "'";
                    break;
                case(2):
                    $enclosure = '"';
                    break;
                case(3):
                    $enclosure = ' ';
                    break;
            }
            $maping = json_decode($this->getContent());
            $fp = fopen($filePath, 'w');
            if ($this->getData('use_addition_header') == 1) {
                fwrite($fp, $this->getData('addition_header'));
            }
            if ($this->getShowHeaders()) {
                $fields = array();
                foreach ($maping as $col) {
                    $fields[] = $col->name;
                }
                fputcsv($fp, $fields, $delimiter, $enclosure);
            }
            $write = Mage::getSingleton('core/resource')->getConnection('core_write');
            for ($i = 0; $i < 2000000; $i += 500) {
                $current_time = time();
                $write->query("UPDATE ranvi_feed SET vartimestamp='$current_time' WHERE id=1");
                //continue;
                $this->writeTempFile($i, 500);
                if (0 == filesize($this->getTempFilePath($i))) {
                    if (file_exists($this->getTempFilePath($i))) {
                        unlink($this->getTempFilePath($i));
                    }
                    break;
                } else {
                    $csv_data = @file_get_contents($this->getTempFilePath($i));
                    fwrite($fp, $csv_data);
                    unset($csv_data);
                    gc_collect_cycles();
                    if (file_exists($this->getTempFilePath($i))) {
                        unlink($this->getTempFilePath($i));
                    }
                }
            }
            //mail('___CHANGEME___','Done Feed','FEED Done - Memory Usage : '. round( ( memory_get_usage() / 1024 / 1024 ) , 2 ) . date('r') ."\n===============================================\n" );
            //fwrite($fp, $csv_data);
            /* if (file_exists($this->getTempFilePath()))
                     {
                         unlink($this->getTempFilePath());
                     }
                     fclose($fp);*/
        }
        $this->setData('restart_cron', 0);
        $this->setData('generated_at', date('Y-m-j H:i:s', time()));
        $this->save();
    }

    public function generate()
    {
        $fileDir = sprintf('%s/productsfeed', Mage::getBaseDir('media'));
        $filePath = sprintf('%s/productsfeed/%s', Mage::getBaseDir('media'), $this->getFilename());
        $logFilepath = sprintf('%s/productsfeed/%s', Mage::getBaseDir('media'), 'log-' . $this->getId() . '.txt');
        @unlink($filePath);
        @unlink($logFilepath);
        $filePath = sprintf('%s/productsfeed/%s', Mage::getBaseDir('media'), $this->getFilename());
        if (!file_exists($fileDir)) {
            mkdir($fileDir);
            chmod($fileDir, 0777);
        }
        if (is_dir($fileDir)) {
            switch ($this->getDelimiter()) {
                case('comma'):
                default:
                    $delimiter = ",";
                    break;
                case('tab'):
                    $delimiter = "\t";
                    break;
                case('colon'):
                    $delimiter = ":";
                    break;
                case('space'):
                    $delimiter = " ";
                    break;
                case('vertical pipe'):
                    $delimiter = "|";
                    break;
                case('semi-colon'):
                    $delimiter = ";";
                    break;
            }
            //$delimiter = $this->getDelimiter();
            switch ($this->getEnclosure()) {
                case(1):
                default:
                    $enclosure = "'";
                    break;
                case(2):
                    $enclosure = '"';
                    break;
                case(3):
                    $enclosure = ' ';
                    break;
            }
            $maping = json_decode($this->getContent());
            $fp = fopen($filePath, 'w');
            if ($this->getData('use_addition_header') == 1) {
                fwrite($fp, $this->getData('addition_header'));
            }
            if ($this->getShowHeaders()) {
                $fields = array();
                foreach ($maping as $col) {
                    $fields[] = $col->name;
                }
                fputcsv($fp, $fields, $delimiter, $enclosure);
            }
            if ($csv_data = @file_get_contents($this->getTempFilePath())) {
                fwrite($fp, $csv_data);
            }
            if (file_exists($this->getTempFilePath())) {
                unlink($this->getTempFilePath());
            }
            fclose($fp);
        }
        $this->setData('generated_at', date('Y-m-j H:i:s', time()));
        $this->save();
    }

    public function getUrl()
    {
        $file_path = sprintf('productsfeed/%s', $this->getFilename());
        if (file_exists(Mage::getBaseDir('media') . '/' . $file_path)) {
            return Mage::getBaseUrl('media', false) . $file_path;
        }
        return '';
    }

    public function delete()
    {
        if ($this->getFilename()) {
            $fileDir = sprintf('%s/productsfeed', Mage::getBaseDir('media'));
            $filePath = sprintf('%s/productsfeed/%s', Mage::getBaseDir('media'), $this->getFilename());
            $logFilepath = sprintf('%s/productsfeed/%s', Mage::getBaseDir('media'), 'log-' . $this->getId() . '.txt');
            @unlink($filePath);
            @unlink($logFilepath);
        }
        return parent::delete();
    }

    public function myfputcsv($fp, $fields, $delimiter = ';', $enclosure = ' ')
    {
        for ($i = 0; $i < sizeof($fields); $i++) {
            $use_enclosure = false;
            if (strpos($fields[$i], $delimiter) !== false) {
                $use_enclosure = true;
            }
            if (strpos($fields[$i], $enclosure) !== false) {
                $use_enclosure = true;
            }
            if (strpos($fields[$i], "\\") !== false) {
                $use_enclosure = true;
            }
            if (strpos($fields[$i], "\n") !== false) {
                $use_enclosure = true;
            }
            if (strpos($fields[$i], "\r") !== false) {
                $use_enclosure = true;
            }
            if (strpos($fields[$i], "\t") !== false) {
                $use_enclosure = true;
            }
            if (strpos($fields[$i], " ") !== false) {
                $use_enclosure = true;
            }
            if ($use_enclosure == true) {
                $fields[$i] = explode("\$enclosure", $fields[$i]);
                for ($j = 0; $j < sizeof($fields[$i]); $j++) {
                    $fields[$i][$j] = explode($enclosure, $fields[$i][$j]);
                    $fields[$i][$j] = implode("{$enclosure}", $fields[$i][$j]);
                }
                $fields[$i] = implode("\$enclosure", $fields[$i]);
                $fields[$i] = "{$fields[$i]}";
            }
        }
        return fwrite($fp, implode($delimiter, $fields) . "\n");
    }

    public function addStockToCollection($collection)
    {
        $manageStockConfig = Mage::getStoreConfig('cataloginventory/item_options/manage_stock', $this->getStoreId());
        $stkConditions = 'e.entity_id=stk.product_id';

        if ($manageStockConfig) {
            // System Manage stock is On
            $ifCase = $this->_getCheckSql('(stk.use_config_manage_stock = 1 OR ( stk.use_config_manage_stock = 0 AND stk.manage_stock = 1) )', 'stk.is_in_stock', '1');
        } else {
            // System Manage stock is On
            $ifCase = $this->_getCheckSql('((stk.use_config_manage_stock = 0 AND stk.manage_stock = 0 ) OR (stk.use_config_manage_stock = 1))', '1', 'stk.is_in_stock');
        }

        $collection->getSelect()->join(
            array('stk' => $collection->getTable('cataloginventory/stock_item')), $stkConditions, array('is_in_stock' => $ifCase, 'manage_stock', 'use_config_manage_stock'));
//        die((string)$collection->getSelect());
    }

    protected function _getCheckSql($expression, $true, $false)
    {
        if ($expression instanceof Zend_Db_Expr || $expression instanceof Zend_Db_Select) {
            $expression = sprintf("IF((%s), %s, %s)", $expression, $true, $false);
        } else {
            $expression = sprintf("IF(%s, %s, %s)", $expression, $true, $false);
        }

        return new Zend_Db_Expr($expression);
    }
}