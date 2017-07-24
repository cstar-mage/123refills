<?php

/**
 *
 *
 * @category  ProxiBlue
 * @package   DynCatProd
 * @author    Lucas van Staden <sales@proxiblue.com.au>
 * @copyright 2016 Lucas van Staden (ProxiBlue)
 * @license   http://www.proxiblue.com.au/eula EULA
 * @link      http://www.proxiblue.com.au
 */
class ProxiBlue_DynCatProd_Model_Resource_Category
    extends Mage_Catalog_Model_Resource_Eav_Mysql4_Category
{

    /**
     * Remove all / only dynamic products from category
     *
     * @param  object $category
     *
     * @return \ProxiBlue_DynCatProd_Model_Resource_Category
     */
    public function removeDynamicProducts($category)
    {
        $categoryId = $category->getId();
        $adapter = $this->_getWriteAdapter();
        $cond = array(
            'is_dynamic = 1',
            'category_id=?' => $categoryId
        );
        $adapter->delete($this->_categoryProductTable, $cond);

        return $this;
    }

    /**
     * Mark dynamic products as dynamic in link table
     *
     * @param  object $category
     *
     * @return \ProxiBlue_DynCatProd_Model_Resource_Category
     */
    public function markProductsAsDynamic($category)
    {
        mage::helper('dyncatprod')->debug(__FUNCTION__ . " in " . __FILE__ . " at " . __LINE__, 20);
        $categoryId = $category->getId();
        $productIds = $category->getDynamicProducts();
        //mage::helper('dyncatprod')->debug("Product Ids : " . print_r($productIds, true) . " with category " . $categoryId, 20);
        if (is_array($productIds)) {

            $adapter = $this->_getWriteAdapter();
            $where = array(
                'product_id IN(?)' => array_keys($productIds),
                'category_id=?'    => $categoryId
            );
            $bind = array('is_dynamic' => 1);
            $adapter->update($this->_categoryProductTable, $bind, $where);
            #mage::helper('dyncatprod')->debug("update table : " . $this->_categoryProductTable, 20);
            #mage::helper('dyncatprod')->debug("update bind : " . print_r($bind,true), 20);
            #mage::helper('dyncatprod')->debug("update where : " . print_r($where,true), 20);
        }

        return $this;
    }

    /**
     * For each dynamic assigned product, remove any linkage it may have to
     * other categories that is not dynamic
     *
     * @param $category
     */
    public function removeProductsNonDynamic($category)
    {
        $productIds = $category->getDynamicProducts();
        if (is_array($productIds)) {
            $adapter = $this->_getWriteAdapter();
            $where = array(
                'product_id IN(?)' => array_keys($productIds),
                'is_dynamic = ?'   => 0
            );

            $result = $adapter->delete($this->_categoryProductTable, $where);
            mage::helper('dyncatprod')->debug(
                'Products had their non dynamic categories removed: ' . print_r(
                    $productIds, true
                ), 3
            );
        }
    }

    /**
     * get Current Dynamic products for category
     *
     * @param  object $category
     *
     * @return array  $currentDynamicIds
     */
    public function getCurrentDynamicProducts($category)
    {
        $categoryId = $category->getId();
        $adapter = $this->_getReadAdapter();
        $select = $adapter->select()->from($this->_categoryProductTable)
            ->where("is_dynamic = ?", 1)
            ->where("category_id = ?", $categoryId);
        $result = $adapter->fetchAll($select);
        array_walk($result, array($this, 'processCurrentIdsCallback'));
        $flatten = $this->flattenArray($result);

        return $flatten;
    }

    private function flattenArray($array)
    {
        $return = array();
        foreach ($array as $value) {
            $productId = key($value);
            $return[$productId] = $value[$productId];
        }

        return $return;
    }

    /**
     * get Current products for category
     *
     * @param  object $category
     *
     * @return array  $currentDynamicIds
     */
    public function getCurrentProducts($category)
    {
        $categoryId = $category->getId();
        $adapter = $this->_getReadAdapter();
        $select = $adapter->select()->from($this->_categoryProductTable)
            //->where("is_dynamic = ?", 1)
            ->where("category_id = ?", $categoryId);
        $result = $adapter->fetchAll($select);
        array_walk($result, array($this, 'processCurrentIdsCallback'));
        $flatten = $this->flattenArray($result);

        return $flatten;
    }

    public function processCurrentIdsCallback(&$result)
    {
        $result = array($result['product_id'] => $result['position']);
    }

    public function buildAnchors($category)
    {
        if ($allChildren = $category->getAllChildren()) {
            $bind = array(
                'entity_id' => $category->getId(),
                'c_path'    => $category->getPath() . '/%'
            );
        }
        $adapter = $this->_getReadAdapter();
        $select = $adapter->select();
        $select->from(
            array('main_table' => $this->getTable('catalog/category_product')),
            new Zend_Db_Expr('DISTINCT main_table.product_id')
        )
            ->joinInner(
                array('e' => $this->getTable('catalog/category')),
                'main_table.category_id=e.entity_id',
                array()
            )
            ->where('e.entity_id = :entity_id')
            ->orWhere('e.path LIKE :c_path');
        $anchorProducts = $adapter->fetchAll($select, $bind);

        return $anchorProducts;
    }

}
