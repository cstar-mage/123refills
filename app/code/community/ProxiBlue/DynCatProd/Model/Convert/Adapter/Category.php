<?php

class ProxiBlue_DynCatProd_Model_Convert_Adapter_Category
    extends Mage_Dataflow_Model_Convert_Adapter_Abstract
{
    protected $_categoryModel;

    public function load()
    {
        return $this;
    }

    public function save()
    {
        return $this;
    }

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


    public function saveRow(array $importData)
    {

        $requiredFields = array(
            'store',
            'category_id',
            'dynamic_attributes',
            'parent_dynamic_attributes',
            'ignore_parent_dynamic'
        );

        //Make sure required fields exist
        if (!$this->checkFieldsExist($requiredFields, $importData)) {
            return false;
        }
        $category = $this-> getCategoryModel()->load($importData['category_id']);
        if (!$category->getId()) {
            $message = Mage::helper('dataflow')->__(
                'Skip import row, category with ID "%s" does not exist!', $importData['category_id']
            );
            Mage::throwException($message);
        }
        unset($importData['category_name']);
        unset($importData['store']);
        $category->addData($importData);
        $category->save();
    }

    protected function checkFieldsExist(array $fields, array $importData)
    {
        $rowValid = true;
        foreach ($fields as $field) {
            if (!isset($importData[$field])) {
                $message = Mage::helper('dataflow')->__('Skip import row, required field "%s" not defined', $field);
                $rowValid = false;
                Mage::throwException($message);
            }
        }

        return $rowValid;
    }
}
