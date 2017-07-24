<?php

/**
 * Helper functions
 *
 * @category  ProxiBlue
 * @package   DynCatProd
 * @author    Lucas van Staden <sales@proxiblue.com.au>
 * @copyright 2016 Lucas van Staden (ProxiBlue)
 * @license   http://www.proxiblue.com.au/eula EULA
 * @link      http://www.proxiblue.com.au
 */
class ProxiBlue_DynCatProd_Helper_Data
    extends Mage_Core_Helper_Abstract
{

    public function addCategoryControl($controlData, $collection)
    {
        $currentControlData = $collection->getFlag('category_control');
        if (!is_array($currentControlData)) {
            $currentControlData = array(
                $controlData);
        } else {
            $currentControlData[] = $controlData;
        }
        $collection->setFlag(
            'category_control',
            $currentControlData
        );
    }

    /**
     * Reindex
     */
    public function reindex()
    {
        if (Mage::getStoreConfig('dyncatprod/rebuild/ignore_indexers')) {
            return $this;
        }
        if (Mage::getStoreConfig('dyncatprod/rebuild/disable_indexers')) {
            $pCollection = Mage::getSingleton('index/indexer')
                ->getProcessesCollection();
            foreach ($pCollection as $process) {
                if (Mage::getStoreConfig('dyncatprod/debug/enabled')) {
                    mage::log(
                        'Dynamic categories build enabling indexer: '
                        . $process->getIndexerCode()
                    );
                }
                $process->setMode(Mage_Index_Model_Process::MODE_REAL_TIME)
                    ->save();
                if (Mage::getStoreConfig('dyncatprod/debug/enabled')) {
                    mage::log(
                        'Dynamic categories rebuilding indexer: '
                        . $process->getIndexerCode()
                    );
                }
                $process->indexEvents();
            }
        }
    }

    /**
     * disable all indexes
     */
    public function disableIndexes()
    {
        if (Mage::getStoreConfig('dyncatprod/rebuild/ignore_indexers')) {
            return $this;
        }
        if (Mage::getStoreConfig('dyncatprod/rebuild/disable_indexers')) {
            $pCollection = Mage::getSingleton('index/indexer')
                ->getProcessesCollection();
            foreach ($pCollection as $process) {
                if (Mage::getStoreConfig('dyncatprod/debug/enabled')) {
                    mage::log(
                        'Dynamic categories build disabling indexer: '
                        . $process->getIndexerCode()
                    );
                }
                $process->setMode(Mage_Index_Model_Process::MODE_MANUAL)->save();
            }
        }
    }

    /**
     * Common routine to rebuild category.
     * Allows observer, cron and cli and tests to run the same code, thus allowing for
     * consistency
     *
     * @param type $category
     */
    public function rebuildCategory($category, $isCron = false)
    {
        // make sure we run as admin store
        // solves SUPP-3399253603536 where cron rebuilds
        // used flat tables on certain rules (using stock/visibility filters)
        Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
        $products = $this->getDynamicProductIds($category);
        $productsToAdd = array();
        if (is_array($products) && count($products) > 0) {
            $products = array_filter(
                $products,
                'is_numeric'
            );

            $category->setDynamicProducts($products);

            // was any data transformations requested?
            // check transformations
            // moved here so it transforms BEFORE save

            $this->testTransforms($category);

            $products = $category->getDynamicProducts();

            // fail-safe, to prevent integrity constraint
            // Make sue the products actually exist.
            // Some rules could be using sales
            // data (like sales reports) and try and insert products that
            // have been deleted from the catalog
            if (count($products) > 0) {
                $pagesize = mage::getStoreConfig(
                    'dyncatprod/rebuild/collection_pagesize'
                );
                $safeCollection = mage::getModel('catalog/product')
                    ->getCollection()
                    ->addAttributeToSelect('entity_id')
                    ->addFieldToFilter(
                        'entity_id',
                        array(
                            'in' => $products)
                    );
                $this->debug(
                    "Testing if products are still valid",
                    4
                );
                // remove GROUP and DISTINCT from collection, else
                // pagecount will be 1.
                $select = $safeCollection->getSelect();
                $group = $select->getPart(Zend_Db_Select::GROUP);
                $distinct = $select->getPart(Zend_Db_Select::DISTINCT);
                $select->reset(Zend_Db_Select::GROUP);
                $select->reset(Zend_Db_Select::DISTINCT);
                $safeCollection->setPageSize($pagesize);
                $pages = $safeCollection->getLastPageNumber();
                $currentPage = 1;
                $safeCollection->setPageSize($pagesize);
                $select->setPart(Zend_Db_Select::GROUP, $group);
                $select->setPart(Zend_Db_Select::DISTINCT, $distinct);
                $this->debug(
                    "SAFE COLLECTION:" . $safeCollection->getSelect()
                );
                do {
                    $this->debug(
                        "Valid Check: Processing page "
                        . "{$currentPage} / {$pages} "
                        . "using batch size of {$pagesize}",
                        5
                    );
                    //Tell the collection which page to load.
                    $safeCollection->setCurPage($currentPage);
                    $safeCollection->load();
                    $safeProductIds = $safeCollection->getAllIds();
                    $invalidProducts = array_diff(
                        $products,
                        $safeProductIds
                    );
                    if (count($invalidProducts) > 0) {
                        foreach (
                            $invalidProducts as $key => $noLongerValid
                        ) {
                            mage::log(
                                'Dynamic categories could not add product to
                                category as product no longer exists : '
                                . $noLongerValid
                            );
                            unset($products[$key]);
                        }
                    }
                    $currentPage++;
                    // make the collection unload the data in memory so it will
                    // pick up the next page when load() is called.
                    $safeCollection->clear();
                } while ($currentPage <= $pages);
                $this->debug(
                    "Valid Check: Flip Array",
                    5
                );
                $products = array_flip($products);
            }

            $category->setDynamicProducts($products);

            if (!Mage::getStoreConfig('dyncatprod/rebuild/max_exec')) {
                ini_set(
                    'max_execution_time',
                    Mage::getStoreConfig('dyncatprod/rebuild/max_exec_time')
                );
            }
            $resourceModel = Mage::getResourceModel('dyncatprod/category');
            $dynamicProducts = $resourceModel->getCurrentDynamicProducts(
                $category
            );
            if ($category->getIgnorePostedProducts()
                || Mage::getStoreConfig(
                    'dyncatprod/global_rule/remove_manual_cats'
                )
            ) {
                $postedProducts = array();
            } else {
                $postedProducts = $category->getPostedProducts();
            }
            if (!is_array($postedProducts)) {
                $postedProducts = array();
            }
            // filter out any dynamic products
            $nonDynamicProducts = array_diff_key(
                $postedProducts,
                $dynamicProducts
            );
            // and keep any set positions for the current dynamic
            // products into the new to assign products
            // I am sure there is a smart internal method to do this with,
            // but I am not getting it today,
            // so a loop it is
            if (!$category->getIgnoreManualPositions()) {
                $this->debug(
                    "Checking positions set",
                    4
                );
                reset($postedProducts);
                while (list($productId, $position) = each(
                    $postedProducts
                )) {
                    if (array_key_exists(
                        $productId,
                        $products
                    )) {
                        $products[$productId] = $position;
                    }
                }
                $category->setDynamicProducts($products);
                unset($products); // free memmory
            }

            $productsToAdd = $category->getDynamicProducts() + $nonDynamicProducts;

            $this->debug(
                "set posted products " . count($productsToAdd) . " on category " . $category->getId(),
                4
            );

            if (Mage::getStoreConfig('dyncatprod/global_rule/keep_manually')) {
                $dynamicProducts = $category->getDynamicProducts();
                $keepManuallyAssigned = array_diff_key($dynamicProducts, $nonDynamicProducts);
                $category->setDynamicProducts($keepManuallyAssigned);
            }

            $category->setPostedProducts($productsToAdd);

            $category->setIsDynamic(true);
        } else {
            // remove all the dynamic products from this category
            $category->setRemoveAllDynamic(true);
        }

        if (Mage::getStoreConfig('dyncatprod/rebuild/force_filters')) {
            $this->debug(
                "***** running filters on existing products *****  on category " . $category->getId(),
                4
            );
            $collection = $category->getProductCollection();
            $currentProducts = $collection->getAllIds();
            $category->setDynamicProducts($currentProducts);
            $this->testTransforms($category);
            $products = array_flip($category->getDynamicProducts());
            $currentProducts = array_flip($currentProducts);
            $dynamicProducts = array_diff_key(
                $products,
                $currentProducts
            );
            $category->setPostedProducts($products);
            $category->setDynamicProducts($dynamicProducts);
            $category->setIsDynamic(true);
        }

        $this->categoryControl($category, $productsToAdd);
        $this->attributesUpdate($category, $productsToAdd);
        $this->notification($isCron, $category);

    }

    /**
     * Generate a list of Product Ids that validate against the rules
     *
     * @param  object $category
     *
     * @return type
     */
    public function getDynamicProductIds($category)
    {
        try {
            if (is_object($category)) {
                $controlSelectString = '';
                $mainCollectionIds = array();
                $collection = $category->getProductCollection();
                $this->debug(
                    "INITIAL COLLECTION:"
                    . $collection->getSelect()
                );
                $ruleData = $this->loadRuleData($category);
                $object = new Varien_Object();
                if (count($ruleData) > 0) {
                    $ruleModel = Mage::getModel(
                        'dyncatprod/rule', array('prefix' => 'conditions')
                    );
                    $ruleModel->mergeAndLoad($ruleData, $category);
                    // remove from the collection the links to the flat tables
                    // we do not want to use flat tables as they may not contain all the
                    // attributes that are present in the rules.
                    $this->debug(
                        "Collection before removed flat tables,"
                        . " adding in distinct and group: "
                        . $collection->getSelect()
                    );
                    $this->removeCollectionPart($collection, 'cat_pro');
                    $collection->getSelect()->distinct(true);
                    $collection->getSelect()->group('e.entity_id');
                    $this->debug(
                        "Collection after removed flat tables,"
                        . " adding in distinct and group: "
                        . $collection->getSelect()
                    );
                    $controlSelectString = (string)$collection->getSelect();
                    $object->setCollection($collection);
                    $object->setCategory($category);
                    $result = $ruleModel->validate($object);
                    if ($result == false) {
                        return false;
                    }
                }
                // may have been replaced entirely
                if (is_object($object) && $object->getCollection()) {
                    $collection = $object->getCollection();
                }
                // skip any build where the resulting collection is the same as the original
                // this means no rules were defined, so we don't want to build
                $buildSelect = (string)$collection->getSelect();
                if ($controlSelectString == $buildSelect && $collection->getFlag('applied_a_rule') != true
                ) {
                    $this->debug(
                        "FINAL COLLECTION: NONE - Looks like no rules were built here,"
                        . " thus no rules to filter - "
                        . $collection->getSelect()
                    );
                } else {
                    $pagesize = mage::getStoreConfig(
                        'dyncatprod/rebuild/collection_pagesize'
                    );
                    $mainCollectionIds = array();
                    $this->debug(
                        "FINAL COLLECTION: " . $collection->getSelect()
                    );
                    // remove GROUP and DISTINCT from collection,
                    // else pagecount will be 1.
                    $select = $collection->getSelect();
                    $group = $select->getPart(Zend_Db_Select::GROUP);
                    $distinct = $select->getPart(Zend_Db_Select::DISTINCT);
                    $select->reset(Zend_Db_Select::GROUP);
                    $select->reset(Zend_Db_Select::DISTINCT);
                    $collection->setPageSize($pagesize);
                    $pages = $collection->getLastPageNumber();
                    $currentPage = 1;
                    $collection->setPageSize($pagesize);
                    $select->setPart(Zend_Db_Select::GROUP, $group);
                    $select->setPart(Zend_Db_Select::DISTINCT, $distinct);
                    $limiter = $select->getPart(Zend_Db_Select::LIMIT_COUNT);
                    $limitOffset = $select->getPart(Zend_Db_Select::LIMIT_OFFSET);
                    $collection->addAttributeToSelect('entity_id');
                    do {
                        $this->debug(
                            "Processing page {$currentPage} / {$pages}"
                            . " using batch size of {$pagesize}",
                            5
                        );
                        //Tell the collection which page to load.
                        $collection->setCurPage($currentPage);
                        if (Mage::getStoreConfig('dyncatprod/debug/enabled')
                            && Mage::getStoreConfig('dyncatprod/debug/level') >= 10
                        ) {
                            $collection->load(false, true);
                        } else {
                            $collection->load();
                        }
                        foreach ($collection as $product) {
                            /** saleable check  */
                            if ($saleableData = $category->getCheckSaleableState()) {
                                /**
                                 * Since this is running in admin, the store will result as admin store 0.
                                 * This will bring back incorrect saleable data, as we are not interested in the saleable
                                 * values of admin store.
                                 * Temporarily set the store to that of the selected store in rule (via website)
                                 */
                                $website = Mage::getModel('core/website')->load($saleableData['website_id']);
                                $store = Mage::getModel('core/store')->load(
                                    $website->getDefaultGroup()->getDefaultStoreId()
                                );
                                $currentStore = mage::app()->getStore();
                                mage::app()->setCurrentStore($store);
                                $productStockItem = Mage::getModel('cataloginventory/stock_item');
                                $productStockItem->assignProduct($product);
                                $operator = ($saleableData['operator'] == '==') ? false : true;
                                if ($product->isSaleable() == $operator) {
                                    $this->debug(
                                        "Skipping product {$product->getId()} due to isSaleable check",
                                        5
                                    );
                                    continue;
                                }
                                mage::app()->setCurrentStore($currentStore);
                            }
                            $mainCollectionIds[] = $product->getId();
                            if (is_null($limitOffset) && !is_null($limiter)
                                && count($mainCollectionIds) >= $limiter
                            ) {
                                $currentPage = $pages + 1;
                                break;
                            }
                        }
                        $currentPage++;
                        // make the collection unload the data in
                        // memory so it will pick up
                        // the next page when load() is called.
                        $collection->clear();
                    } while ($currentPage <= $pages);
                    if (!is_null($limitOffset)) {
                        $mainCollectionIds = array_slice($mainCollectionIds, $limitOffset, $limiter);
                    }
                }

                $category->setCategoryControl(
                    $collection->getFlag('category_control')
                );

                $category->setAttributesUpdate(
                    $collection->getFlag('attributes_update')
                );


                return $mainCollectionIds;
            }
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            mage::logException($e);
        }
    }

    /**
     * Load the multiple rule definitions to one array
     *
     * @param $category
     *
     * @return array
     */
    public function loadRuleData($category)
    {
        $ruleData = array();
        /** parent rules */
        $parentCategories = $this->getParentConditionCategories(
            $category
        );
        if (count($parentCategories) > 0) {
            foreach ($parentCategories as $parent) {
                $ruleData[] = unserialize(
                    $parent->getParentDynamicAttributes()
                );
            }
        }
        /** own rules as potential parent */
        if ($category->getParentDynamicAttributes()
            || strlen(trim($category->getParentDynamicAttributes())) > 0
        ) {
            $data = unserialize($category->getParentDynamicAttributes());
            if (count($data) > 1) {
                $ruleData[] = $data;
            }
            unset($data);
        }
        /** own rules */
        if ($category->getDynamicAttributes()
            || strlen(trim($category->getDynamicAttributes())) > 0
        ) {
            $data = unserialize($category->getDynamicAttributes());
            if (count($data) > 1) {
                $ruleData[] = $data;
            }
        }

        return $ruleData;
    }

    /**
     * get parent rules as array for given category
     *
     * @return array
     */
    public function getParentConditionCategories($category)
    {
        $parents = array();
        if (mage::getStoreConfig('dyncatprod/rebuild/ignore_parents')
            && $category->getParentDynamicAttributes() == false
            && $category->getDynamicAttributes() == false
        ) {
            return array();
        }
        if ($category->getIgnoreParentDynamic()) {
            return $parents;
        }
        $parentPath = $category->getPath();
        if (!is_null($parentPath)) {
            $parentPathArray = explode('/', $parentPath);
            if (is_array($parentPathArray)) {
                array_pop($parentPathArray);
                if (count($parentPathArray) > 0) {
                    $categories = Mage::getModel('catalog/category')->getCollection()
                        ->addAttributeToSelect('*')
                        ->addFieldToFilter(
                            'entity_id', array('in' => $parentPathArray)
                        );
                    $this->debug(
                        'Categories Collection: ' . $categories->getSelect(), 100
                    );
                    foreach ($categories as $key => $parentCategory) {
                        if ($parentCategory->getParentDynamicAttributes()
                            || strlen(trim($parentCategory->getParentDynamicAttributes()))
                            > 0
                        ) {
                            try {
                                $data = unserialize(
                                    $parentCategory->getParentDynamicAttributes()
                                );
                                if (count($data) > 1) {
                                    $parents[$key] = $parentCategory;
                                }
                            } catch (Exception $e) {
                                // fail silently, as it wasn't a string, so not wanted
                                // anyways
                            }

                        }
                    }

                    return $parents;
                }
            }
        }

        return array();
    }

    /**
     * Common debugger helper
     *
     * @param string $message
     * @param integer $level
     */
    public function debug($message, $level = 1)
    {
        if (Mage::getStoreConfig('dyncatprod/debug/enabled')
            && Mage::getStoreConfig('dyncatprod/debug/level') >= $level
        ) {
            mage::log(
                $message,
                Zend_Log::DEBUG,
                'dyncatprod.log',
                false
            );

            if (mage::registry('is_shell')
                && strpos(
                    $message,
                    'SELECT'
                ) === false
            ) {
                echo $message . "\n";
            }
        }
    }

    /**
     * Remove selective parts of the collection linking to tables
     *
     * @param  type $collection
     * @param  string $partName
     *
     * @return type
     */
    public function removeCollectionPart($collection, $partName)
    {
        $select = $collection->getSelect();
        $fromPart = $select->getPart(Zend_Db_Select::FROM);
        $select->reset(Zend_Db_Select::FROM);
        if (array_key_exists(
            $partName,
            $fromPart
        )) {
            unset($fromPart[$partName]);
            // also remove any reference to the table in the rest of the query
            $columns = $select->getPart(Zend_Db_Select::COLUMNS);
            $columnRemoved = false;
            foreach ($columns as $columnKey => $column) {
                if ($column[0] == $partName) {
                    unset($columns[$columnKey]);
                    $columnRemoved = true;
                }
            }
            if ($columnRemoved) {
                $select->setPart(
                    Zend_Db_Select::COLUMNS,
                    $columns
                );
            }
            $orderPart = $select->getPart(Zend_Db_Select::ORDER);
            $orderRemoved = false;
            foreach ($orderPart as $orderKey => $order) {
                if ($order[0] == $partName) {
                    unset($orderPart[$orderKey]);
                    $orderRemoved = true;
                }
            }
            if ($orderRemoved) {
                $select->setPart(
                    Zend_Db_Select::ORDER,
                    $orderPart
                );
            }
        }
        $select->setPart(
            Zend_Db_Select::FROM,
            $fromPart
        );

        return $collection;
    }


    /**
     * Attribute Updates
     *
     * @param $category
     *
     * @throws Exception
     */
    private function attributesUpdate($category, $productsToAdd)
    {
        if($updates = $category->getAttributesUpdate()){
            foreach ($updates->getConditions() as $cond) {
                $cond->validate($category, $updates, $productsToAdd);
            }
        }
    }

    /**
     * Category control
     *
     * @param $category
     *
     * @throws Exception
     */
    private function categoryControl($category, $productsToAdd)
    {
        // determine any special category control actions.
        $categoryControl = $category->getCategoryControl();
        if ($categoryControl) {
            foreach ($categoryControl as $control) {
                //action on parent?
                if ($control->getValue() == 'parent') {
                    $parentCatId = $category->getParentId();
                    $parentCategory = mage::getModel('catalog/category')->load(
                        $parentCatId
                    );
                    if ($parentCategory->getid()) {
                        // ok, so we have a parent, lets get all the
                        // children, or itself if none
                        if ($parentCategory->hasChildren()) {
                            $categoryLimit = explode(
                                ',',
                                $parentCategory->getAllChildren()
                            );
                        } else {
                            $categoryLimit = $parentCategory->getId();
                        }
                        // let see if there are any products in any of this
                        $productCollection = Mage::getResourceModel(
                            'catalog/product_collection'
                        )
                            ->joinField(
                                'category_id',
                                'catalog/category_product',
                                'category_id',
                                'product_id=entity_id',
                                null,
                                'left'
                            )
                            ->addAttributeToFilter(
                                'category_id',
                                array(
                                    'in' => $categoryLimit)
                            )
                            ->addAttributeToFilter(
                                'status',
                                Mage_Catalog_Model_Product_Status::STATUS_ENABLED
                            );
                        $productCollection->getSelect()->group('product_id')
                            ->distinct(true);
                        //LVSTODO: FIX THIS. Not very efficient.
                        $productCollection->load();
                        foreach ($control->getConditions() as $cond) {
                            if ($control->getAggregator() == 'any'
                                && count($productCollection->getItems()) > 0
                            ) {
                                $cond->validate($parentCategory);
                                $parentCategory->save();
                            } elseif ($control->getAggregator() == 'none'
                                && count($productCollection->getItems()) == 0
                            ) {
                                $cond->validate($parentCategory);
                                $parentCategory->save();
                            }
                        }
                    }
                } else {
                    foreach ($control->getConditions() as $cond) {
                        if ($control->getAggregator() == 'any'
                            && count($productsToAdd) > 0
                        ) {
                            $cond->validate($category);
                        } elseif ($control->getAggregator() == 'none'
                            && count($productsToAdd) == 0
                        ) {
                            $cond->validate($category);
                        }
                    }
                }
            }
        }
    }

    /**
     * Test and send notifications
     *
     * @param $isCron
     * @param $category
     */
    private function notification($isCron, $category)
    {
        if ($isCron && mage::getStoreConfig('dyncatprod/notify/enabled')
            && count($category->getPostedProducts()) < mage::getStoreConfig(
                'dyncatprod/notify/product_notify_count'
            )
        ) {
            $message = Mage::helper('core')->__(
                "Category '%s' (%s) was rebuilt with %s products.<br/><br/>"
                . "Notification is set to warn when less than %s products"
                . "are in the category",
                $category->getName(),
                $category->getId(),
                count($category->getPostedProducts()),
                mage::getStoreConfig('dyncatprod/notify/product_notify_count')
            );
            $this->sendEmail(
                $this->__(
                    "Dynamic Category Products Notification for %s",
                    $category->getName()
                ),
                $message
            );
        }
    }

    /**
     * Email notifications
     *
     * @return boolean
     */
    public function sendEmail($subject, $message)
    {
        try {
            return Mage::helper('dyncatprod/email')->sendEmail($subject,
                $message
                , Mage::getStoreConfig('dyncatprod/notify/identity_from')
                , Mage::getStoreConfig('dyncatprod/notify/identity_to')
            );

        } catch (Exception $e) {
            mage::logException($e);
            mage::log(
                "Could not send notification email. Please check
                exception log for details."
            );
        }

        return false;
    }



    /*
     * Get the correct column name to use in sql inserted into collections.
     * Magento versions seem to have changed the naming conventions.
     *
     * @param  type $columns
     * @param  type $field
     * @return type
     */

    /**
     * Test if this is a pre 1.6 install
     *
     * @return boolean
     */
    public function isPre16()
    {
        $magentoVersion = Mage::getVersionInfo();
        if ($magentoVersion['minor'] < 6) {
            return true;
        }

        return false;
    }

    public function getColumnName($columns, $field)
    {
        foreach ($columns as $column) {
            if (array_key_exists(
                    '2',
                    $column
                )
                && $column[2] == $field
            ) {
                return $column[0];
            }
        }
        $this->debug('Could not determine column name for field ' . $field, 1);

        return $field;
    }

    /**
     * Test if given category has parent categories with parent rules
     *
     * @param $category
     *
     * @return bool
     */

    public function hasParentsWithRules($category)
    {
        $parentsWithRules = $this->getParentConditionCategories(
            $category
        );
        if (is_array($parentsWithRules) && count($parentsWithRules) > 0) {
            return true;
        }

        return false;
    }


    /**
     * Test transformation rules to run
     * Each transformation rule must have it's own registry entry to allow
     * the rules to be used at the same time.
     * LVSTODO: Investigate usage of an array rather than single entry for each, allowing for more dynamic code
     *
     * @param $category
     */

    private function testTransforms($category)
    {
        if ($transformParents = mage::registry('transform_parents')) {
            mage::unregister('transform_parents');
            if (is_object($transformParents) && method_exists($transformParents, 'validateLater')) {
                $transformParents->validateLater($category);
            }
        }
        if ($transformSimples = mage::registry('transform_simples')) {
            mage::unregister('transform_simples');
            if (is_object($transformSimples) && method_exists($transformSimples, 'validateLater')) {
                $transformSimples->validateLater($category);
            }
        }
        if ($transform = mage::registry('transform_by_count')) {
            mage::unregister('transform_by_count');
            if (is_object($transform) && method_exists($transform, 'validateLater')) {
                $transform->validateLater($category);
            }
        }
        if ($transform = mage::registry('transform_by_final_price')) {
            mage::unregister('transform_by_final_price');
            if (is_object($transform) && method_exists($transform, 'validateLater')) {
                $transform->validateLater($category);
            }
        }

        if ($category->getDoPostedProducts() || $category->getRemoveAllDynamic()) {
            $resourceModel = Mage::getResourceModel('dyncatprod/category');
            $resourceModel->removeDynamicProducts($category);
        }
        if ($category->getDoPostedProducts()) {
            // link the transformed product data
            mage::getModel('dyncatprod/subselect')
                ->setCategory($category)
                ->setPostedProducts(true);
        }
    }


}
