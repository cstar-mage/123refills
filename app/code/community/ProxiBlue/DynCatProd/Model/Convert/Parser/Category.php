<?php

class ProxiBlue_DynCatProd_Model_Convert_Parser_Category
    extends Mage_Eav_Model_Convert_Parser_Abstract
{

    protected $_categoryModel;
    protected $_storeId;
    protected $_store;


    /**
     * Retrieve category model cache
     *
     * @return Mage_Catalog_Model_Product
     */
    public function getCategoryModel()
    {
        if (is_null($this->_categoryModel)) {
            $categoryModel = Mage::getModel('catalog/category');
            $this->_categoryModel = Mage::objects()->save($categoryModel);
        }
        return Mage::objects()->load($this->_categoryModel);
    }

    /**
     * Retrieve current store model
     *
     * @return Mage_Core_Model_Store
     */
    public function getStore()
    {
        if (is_null($this->_store)) {
            try {
                $store = Mage::app()->getStore($this->getVar('store'));
            } catch (Exception $e) {
                $this->addException(
                    Mage::helper('catalog')->__('Invalid store specified'),
                    Varien_Convert_Exception::FATAL
                );
                throw $e;
            }
            $this->_store = $store;
        }
        return $this->_store;
    }

    /**
     * Retrieve store ID
     *
     * @return int
     */
    public function getStoreId()
    {
        if (is_null($this->_storeId)) {
            $this->_storeId = $this->getStore()->getId();
        }
        return $this->_storeId;
    }

    /**
     * Unparse (prepare data) loaded products
     *
     * @return Mage_Catalog_Model_Convert_Parser_Product
     */
    public function unparse()
    {
        $categories = Mage::getModel('catalog/category')
            ->getCollection()
            ->addAttributeToSelect('*')
            ->setStoreId($this->getStoreId())
            ->addAttributeToFilter(
                array(
                    array('attribute' => 'dynamic_attributes', 'neq' => NULL),
                    array('attribute' => 'parent_dynamic_attributes', 'neq' => NULL)
                ), null, 'left'
            );

        foreach ($categories as $i => $category) {

            // first make sure there are no stub rules, which was prom an old bug.
            // we don't want to replicate that
            $changed = 0;
            $data = unserialize($category->getDynamicAttributes());
            if (is_array($data) && count($data) == 1) {
                $category->setDynamicAttributes(null);
                $changed = 1;
            }
            $data = unserialize($category->getParentDynamicAttributes());
            if (is_array($data) && count($data) == 1) {
                $category->setParentDynamicAttributes(null);
                $changed = 1;
            }

            $position = Mage::helper('catalog')->__('Line %d, CATEGORY: %s', ($i + 1), $category->getId());
            $this->setPosition($position);
            $path = explode('/', $category->getPath());
            $catPath = array();
            $rootCat = Mage::app()->getStore($this->getVar('store'))->getRootCategoryId();
            foreach ($path as $pathId) {
                $pathCategory = mage::getModel('catalog/category')->load($pathId);
                if ($pathCategory->getId() >= $rootCat) {
                    $catPath[] = $pathCategory->getName();
                }
            }
            $path = implode('/', $catPath);

            if (!is_null($category->getDynamicAttributes()) || !is_null($category->getParentDynamicAttributes())) {
                $row = array(
                    'store' => $this->getStore()->getCode(),
                    'category_id' => $category->getId(),
                    'dynamic_attributes' => $category->getDynamicAttributes(),
                    'parent_dynamic_attributes' => $category->getParentDynamicAttributes(),
                    'ignore_parent_dynamic' => $category->getIgnoreParentDynamic()
                );


                $batchModelId = $this->getBatchModel()->getId();
                $this->getBatchExportModel()
                    ->setId(null)
                    ->setBatchId($batchModelId)
                    ->setBatchData($row)
                    ->setStatus(1)
                    ->save();

                unset($row);
            }
            if ($changed == 1) {
                // svae potentially cleaned category
                $category->save();
            }
        }

        return $this;
    }

    public function parse()
    {
        // depricated
    }
}
