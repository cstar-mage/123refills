<?php

/**
 * Observer events
 *
 * @category  ProxiBlue
 * @package   DynCatProd
 * @author    Lucas van Staden <sales@proxiblue.com.au>
 * @copyright 2016 Lucas van Staden (ProxiBlue)
 * @license   http://www.proxiblue.com.au/eula EULA
 * @link      http://www.proxiblue.com.au
 */
class ProxiBlue_DynCatProd_Model_Adminhtml_Observer
{

    /**
     * Event to add Tab to Category edit display
     *
     * @param  Varien_Event_Observer $observer
     *
     * @return ProxiBlue_DynCatProd_Model_Adminhtml_Observer
     */
    public function adminhtml_catalog_category_tabs(
        Varien_Event_Observer $observer
    )
    {
        try {
            $tabs = $observer->getEvent()->getTabs();
            // place in layout file !
            Mage::app()->getLayout()->getBlock('head')->addJs(
                'mage/adminhtml/rules.js'
            );
            Mage::app()->getLayout()->getBlock('head')->addJs(
                'dyncatprod/ext-rules.js'
            );
            Mage::app()->getLayout()->getBlock('head')->addCss(
                'dyncatprod/adminhtml.css'
            );
            Mage::app()->getLayout()->getBlock('head')->addJs(
                'dyncatprod/adminhtml.js'
            );
            if (Mage::getStoreConfig('dyncatprod/debug/enabled') && mage::getIsDeveloperMode()) {
                Mage::app()->getLayout()->getBlock('head')->addJs(
                    'dyncatprod/debug.js'
                );
            }
            if (mage::getStoreConfig('dyncatprod/ept/tooltips')) {
                Mage::app()->getLayout()->getBlock('head')->addJs(
                    'dyncatprod/tooltip-v0.js'
                );
                Mage::app()->getLayout()->getBlock('head')->addCss(
                    'dyncatprod/tooltips.css'
                );
            }


            $currentCategory = Mage::registry('current_category');
            if (!$currentCategory instanceof Mage_Catalog_Model_Category) {
                $rootId = Mage::app()->getStore(0)->getRootCategoryId();
                $currentCategory = Mage::getModel('catalog/category')->load(
                    $rootId
                );
            }


            $globalTabHtml = '';

            if ($currentCategory->getChildrenCount() > 0) {
                /**
                 * the main tab block * */
                $globalTabBlock = $tabs->getLayout()->createBlock(
                    'dyncatprod/adminhtml_catalog_category_tab_dyncatprod',
                    'category.dyncatprod.tab'
                );
                $globalTabBlock->setTemplate('dyncatprod/global_tab.phtml');
                /**
                 * the rules block
                 **/
                $globalRulesBlock = $tabs->getLayout()->createBlock(
                    'dyncatprod/adminhtml_catalog_category_tab_dyncatprod_rules_parent',
                    'category.dyncatprod.rules.parent'
                );
                $globalTabBlock->setChild(
                    'category_dyncatprod_rules',
                    $globalRulesBlock
                );

                $globalTabHtml = $globalTabBlock->toHtml();
            }

            /**
             * the rules list block
             **/
            $rulesListBlock = $tabs->getLayout()->createBlock(
                'dyncatprod/adminhtml_catalog_category_tab_dyncatprod_rules_list',
                'category.dyncatprod.rules.list'
            );
            $rulesListBlock->setTemplate('dyncatprod/rules/list.phtml');


            /**
             * the rules block
             **/
            $rulesBlock = $tabs->getLayout()->createBlock(
                'dyncatprod/adminhtml_catalog_category_tab_dyncatprod_rules_current',
                'category.dyncatprod.rules.current'
            );

            /**
             * the main tab block * */
            $tabBlock = $tabs->getLayout()->createBlock(
                'dyncatprod/adminhtml_catalog_category_tab_dyncatprod',
                'category.dyncatprod.tab'
            );
            $tabBlock->setTemplate('dyncatprod/tab.phtml');


            $tabBlock->setChild(
                'category_dyncatprod_rules',
                $rulesBlock
            );

            /** messages */
            $messageBlock = $tabs->getLayout()->createBlock(
                'core/template',
                'category.dyncatprod.rules.messages'
            );
            $messageBlock->setTemplate('dyncatprod/messages.phtml');


            if (mage::getStoreConfig('dyncatprod/ept/draggable_grid')) {
                Mage::app()->getLayout()->getBlock('head')->addJs(
                    'dyncatprod/dnd.js'
                );
                Mage::app()->getLayout()->getBlock('head')->addCss(
                    'dnd.css'
                );
            }


            if (mage::getStoreConfig('dyncatprod/ept/mode')
                != ProxiBlue_DynCatProd_Model_System_Config_Source_Mode::TAB_MODE_STANDALONE
                && mage::helper('dyncatprod')->isPre16() == false
            ) {
                $productsGrid = Mage::app()->getLayout()
                    ->createBlock(
                        'adminhtml/catalog_category_tab_product',
                        'category.product.grid'
                    )->setDefaultSort('position')
                    ->setDefaultDir('asc')
                    ->toHtml();

                $tabs->removeTab('products');

                $tabs->addTab(
                    'products',
                    array(
                        'label' => Mage::helper('catalog')->__(
                            'Category Products (Dynamic Rules)'
                        ),
                        'content' => $messageBlock->toHtml()
                            . $rulesListBlock->toHtml()
                            . $globalTabHtml
                            . $tabBlock->toHtml()
                            . $productsGrid
                    )
                );
            } else {
                $tabs->addTab(
                    'dyncatprod',
                    array(
                        'label' => Mage::helper('catalog')->__(
                            'Dynamic Rules'
                        ),
                        'content' => $messageBlock->toHtml()
                            . $rulesListBlock->toHtml()
                            . $globalTabHtml
                            . $tabBlock->toHtml()
                    )
                );
            }
        } catch (Exception $e) {
            // log any issues, but allow system to continue.
            mage::logException($e);
            if (Mage::getIsDeveloperMode()) {
                mage::throwException($e->getMessage());
            }
        }

        return $this;
    }

    /**
     * Event to save admin
     *
     * @param  Varien_Event_Observer $observer
     *
     * @return ProxiBlue_DynCatProd_Model_Adminhtml_Observer
     */
    public function catalog_category_prepare_save(
        Varien_Event_Observer $observer
    )
    {
        try {
            $event = $observer->getEvent();
            if ($data = $event->getRequest()->getParams()) {
                $rebuild = false;
                $saveOnly = false;
                $dynamicAttributes = array('conditions' => 'dynamic_attributes',
                                           'parent_conditions' => 'parent_dynamic_attributes');
                if (array_key_exists('rule', $data)) {
                    foreach ($dynamicAttributes as $_dynamicAttribute => $_dynamicAttributeName) {
                        if (array_key_exists($_dynamicAttribute, $data['rule'])) {
                            try {
                                $conditions = null;
                                if (array_key_exists('general', $data)
                                    && array_key_exists($_dynamicAttributeName, $data['general'])
                                    && strpos($data['general'][$_dynamicAttributeName], 'OVERRIDE:') !== false
                                ) {
                                    $rebuild = true;
                                    $conditions = str_replace(
                                        'OVERRIDE:', '', $data['general'][$_dynamicAttributeName]
                                    );
                                    mage::helper('dyncatprod')->debug('Rule override action ', 5);
                                } else {
                                    if (count($data['rule'][$_dynamicAttribute]) > 1) {
                                        $rebuild = true;
                                        $conditions = serialize(
                                            $data['rule'][$_dynamicAttribute]
                                        );
                                    }

                                }

                                $event->getCategory()->setData(
                                    $_dynamicAttributeName,
                                    $conditions
                                );

                            } catch (Exception $e) {
                                mage::log(
                                    'Could not save serialized dynamic rules '
                                    . $_dynamicAttribute
                                    . ' - Potentially the conditions were not serialized'
                                );
                                mage::logException($e);
                            }
                        } else {
                            // is this a child with parent rules?
                            if (mage::helper('dyncatprod')->hasParentsWithRules($event->getCategory())) {
                                $rebuild = true;
                            }
                        }
                    }
                    if (array_key_exists('skip_build', $data) && $data['skip_build']) {
                        mage::helper('dyncatprod')->debug(
                            "Category dynamic rules not build. Skip build was set.",
                            1
                        );
                        $rebuild = false;
                        $saveOnly = true;
                    }
                    if (mage::getStoreConfig('dyncatprod/rebuild/flip_save_rebuild')
                        && !array_key_exists('force_build', $data)
                    ) {
                        mage::helper('dyncatprod')->debug(
                            "Category dynamic rules not build. Force build not set and flip save option active.",
                            1
                        );
                        $rebuild = false;
                        $saveOnly = true;
                    }
                    if ($rebuild) {
                        //get the product ids and attach to category
                        if (Mage::getStoreConfig('dyncatprod/rebuild/delayed')
                            == false
                        ) {
                            mage::helper('dyncatprod')->debug(
                                "start rebuild category routine",
                                4
                            );
                            mage::helper('dyncatprod')->rebuildCategory(
                                $event->getCategory()
                            );

                            $event->getCategory()->setDynamicRebuildDatetime(
                                Mage::getModel('core/date')->date('Y-m-d H:i:s')
                            );
                            mage::helper('dyncatprod')->debug(
                                "end rebuild category routine",
                                4
                            );
                        } else {
                            // flag this category for a delayed build
                            $rebuild = Mage::getModel('dyncatprod/delaybuild');
                            $rebuild->load(
                                $event->getCategory()->getId(),
                                'category_id'
                            );
                            if (!$rebuild->getId()) {
                                $rebuild->setCategoryId(
                                    $event->getCategory()->getId()
                                );
                                $rebuild->save();
                            }
                            Mage::getSingleton('adminhtml/session')->addSuccess(
                                Mage::helper('catalog')->__(
                                    'The category has been scheduled for rebuild.'
                                )
                            );
                        }
                    } elseif (!$saveOnly) {
                        $event->getCategory()->setRemoveAllDynamic(true);
                    }
                }
                unset($data['rule']);
            }
        } catch (Exception $e) {
            // log any issues, but allow system to continue.
            mage::logException($e);
            mage::throwException($e->getMessage());
        }

        return $this;
    }

    /**
     * Remove the prefix of a value
     *
     * @param string $value
     *
     * @return string
     */
    public function removeValuePrefix($value)
    {
        if (strpos(
            $value,
            '_'
        )) {
            $strip = explode(
                '_',
                $value
            );
            $value = array_pop($strip);
            $strip = explode(
                '.',
                $value
            );
            $value = array_shift($strip);
        }

        return $value;
    }

    /**
     * Event to update categories that contains any of the attributes that
     * changed for the products
     *
     * @param  Varien_Event_Observer $observer
     *
     * @return ProxiBlue_DynCatProd_Model_Adminhtml_Observer
     */
    public function catalog_product_save_after(Varien_Event_Observer $observer)
    {
        try {
            if (!Mage::getStoreConfig('dyncatprod/rebuild/product_save')) {
                $data = $observer->getProduct()->getData();
                ksort($data);
                $origData = $observer->getProduct()->getOrigData();
                if (is_array(
                    $origData
                )) { //new products will not have $origData set
                    ksort($origData);
                    $sameKeys = array_keys(
                        array_intersect_key(
                            $data,
                            $origData
                        )
                    );
                } else {
                    $sameKeys = array_keys($data);
                    $origData = array();
                }
                foreach ($sameKeys as $key) {
                    if (!array_key_exists(
                            $key,
                            $origData
                        )
                        || $data[$key] != $origData[$key]
                    ) {
                        $rebuild = Mage::getModel('dyncatprod/rebuild');
                        $rebuild->load(
                            $key,
                            'attribute_code'
                        );
                        if (!$rebuild->getId()) {
                            $rebuild->setAttributeCode($key);
                            $rebuild->save();
                        }
                    }
                }
                $test = 1;
            }
        } catch (Exception $e) {
            // log any issues, but allow system to continue.
            mage::logException($e);
            //mage::throwException($e->getMessage());
        }

        return $this;
    }

    /**
     * After all db transaction were committed, and we have the final data
     *
     * Deal with transformations as a final step.
     * Deal with final indexing.
     * Deal with scheduling child categories from rebuilding as well.
     *
     * @param Varien_Event_Observer $observer
     *
     * @return ProxiBlue_DynCatProd_Model_Adminhtml_Observer
     */
    public function catalog_category_save_commit_after(Varien_Event_Observer $observer)
    {
        try {

            $category = $observer->getCategory();
            if ($category->getIsDynamic()) {
                if (!Mage::getStoreConfig(
                    'dyncatprod/rebuild/force_indexer'
                )
                ) {
                    // normal category save indexing does not detect that the dynamic products
                    // has changed, thus indexing does not happen.
                    // manually initiate this prior to the normal category save indexing
                    $indexEvent = Mage::getSingleton('index/indexer')->logEvent(
                        $category,
                        Mage_Catalog_Model_Category::ENTITY,
                        Mage_Index_Model_Event::TYPE_SAVE,
                        false
                    );
                    Mage::getSingleton('index/indexer')
                        ->getProcessByCode('catalog_category_product')
                        ->setMode(Mage_Index_Model_Process::MODE_REAL_TIME)
                        ->processEvent($indexEvent);
                }

                // does this category have any parent rules defined?
                if ($category->getParentDynamicAttributes()
                    || strlen(trim($category->getParentDynamicAttributes())) > 0
                ) {
                    $rules = unserialize($category->getParentDynamicAttributes());
                    if (count($rules) > 1) {
                        mage::helper('dyncatprod')->debug(
                            "category with parent rules detected in save",
                            5
                        );
                        if ($allChildren = $category->getAllChildren()) {
                            mage::helper('dyncatprod')->debug(
                                "Need to rebuild all child categories: " . $allChildren,
                                5
                            );
                            $allChildren = explode(',', $allChildren);
                            $categories = Mage::getModel('catalog/category')->getCollection()
                                ->addAttributeToSelect('*')
                                ->addFieldToFilter(
                                    'entity_id', array('in' => $allChildren)
                                );
                            $categories->load();
                            $rebuilt = array();
                            foreach ($categories as $childCategory) {
                                if ($childCategory->getId() != $category->getid()) {
                                    // flag this category for a delayed build
                                    $rebuild = Mage::getModel('dyncatprod/delaybuild');
                                    $rebuild->load(
                                        $childCategory->getId(),
                                        'category_id'
                                    );
                                    if (!$rebuild->getId()) {
                                        $rebuild->setCategoryId(
                                            $childCategory->getId()
                                        );
                                        $rebuild->save();
                                    }
                                    $rebuilt[] = $childCategory->getId();
                                }
                            }
                            if (count($rebuilt) > 0) {
                                $plural = (count($rebuilt) > 1) ? 'categories' : 'category';
                                $rebuilt = implode(',', $rebuilt);
                                Mage::getSingleton('adminhtml/session')->addSuccess(
                                    Mage::helper('catalog')->__(
                                        'The child %s %s has been scheduled for rebuild.', $plural, $rebuilt
                                    )
                                );
                            }
                        } else {
                            mage::helper('dyncatprod')->debug(
                                "category with parent rules have no children, ignoring",
                                5
                            );
                        }
                    }
                }
                // is this category in the rebuild list?
                // if so/remove it as it was just rebuilt.
                $rebuild = Mage::getModel('dyncatprod/delaybuild');
                $rebuild->load(
                    $category->getId(),
                    'category_id'
                );
                if ($rebuild->getId()) {
                    $rebuild->delete();
                }
            }
        } catch (Exception $e) {
            // log any issues, but allow system to continue.
            mage::logException($e);
            //mage::throwException($e->getMessage());
        }

        return $this;

    }

    /**
     * Force a re-index of the category catalog_product after the dynamic data
     * was saved
     *
     * @param  Varien_Event_Observer $observer
     *
     * @return ProxiBlue_DynCatProd_Model_Adminhtml_Observer
     */
    public function catalog_category_save_after(Varien_Event_Observer $observer)
    {
        try {
            $category = $observer->getCategory();
            $resourceModel = Mage::getResourceModel('dyncatprod/category');
            if ($category->getRemoveAllDynamic()
            ) {
                $resourceModel->removeDynamicProducts($category);
            }
            if ($category->getIsDynamic()) {
                $resourceModel->markProductsAsDynamic($category);
                if ($category->getRemoveProductsManualAssigned()
                    || Mage::getStoreConfig(
                        'dyncatprod/global_rule/remove_manual_prod'
                    )
                ) {
                    $resourceModel->removeProductsNonDynamic($category);
                }

                $category->setIsChangedProductList(true);
            }

        } catch (Exception $e) {
            // log any issues, but allow system to continue.
            mage::logException($e);
            //mage::throwException($e->getMessage());
        }

        return $this;
    }
}
