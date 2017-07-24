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
class ProxiBlue_DynCatProd_Model_Resource_Subselect
    extends Mage_Core_Model_Mysql4_Abstract
{

    /**
     * Catalog products table name
     *
     * @var string
     */
    protected $_catProductTable;

    public function _construct()
    {
        $this->_init(
            'dyncatprod/subselect',
            'category_id'
        );
        $this->_catProductTable = $this->getTable(
            'catalog/category_product'
        );
    }

    public function save(Mage_Core_Model_Abstract $object)
    {
        $data = $object->getPreDumpData();
        if (is_array($data) && count($data) > 0) {
            $adapter = $this->_getWriteAdapter();
            try {
                $adapter->insertMultiple(
                    $this->getTable('dyncatprod/subselect'),
                    $data
                );
            } catch (Exception $e) {
                mage::helper('dyncatprod')->debug(
                    'ERROR with a batch of data into subselect table. Message was: '
                    . $e->getMessage()
                );
                mage::helper('dyncatprod')->debug(
                    'Attempting to locate the row that caused the issue....'
                );
                mage::helper('dyncatprod')->debug(
                    'Starting insert of singular data rows for this batch....'
                );
                $numrows = count($data);
                foreach ($data as $key => $row) {
                    try {
                        mage::helper('dyncatprod')->debug(
                            'Inserting single row....' . $key . ' / '
                            . $numrows, 5
                        );
                        $adapter->insertMultiple(
                            $this->getTable('dyncatprod/subselect'),
                            $row
                        );
                    } catch (Exception $e) {
                        mage::helper('dyncatprod')->debug(
                            'ERROR inserting a single row of data. Message was: '
                            . $e->getMessage()
                            , 10
                        );
                        mage::helper('dyncatprod')->debug(
                            'Data was : ' . print_r($row, true), 10
                        );
                    }
                }
            }
        }

        return $this;
    }

    public function delete(Mage_Core_Model_Abstract $object)
    {
        $adapter = $this->_getWriteAdapter();
        $cond = array(
            'category_id=?' => $object->getId(),
            'is_dynamic=?'  => 1
        );
        $adapter->delete(
            $this->_catProductTable,
            $cond
        );
    }

    public function deleteSubselect($category)
    {
        $adapter = $this->_getWriteAdapter();
        $cond = array(
            'category_id=?' => $category->getId()
        );
        $adapter->delete(
            $this->getTable('dyncatprod/subselect'),
            $cond
        );
    }

    public function linkProductsToCategory($insert, $category)
    {
        $adapter = $this->_getWriteAdapter();
        $data = array();
        foreach ($insert as $row) {
            // test that the given product still exists, else it will not add to the catalog

            $data[] = array(
                'category_id' => (int)$category->getId(),
                'product_id'  => (int)$row->getProductId(),
                'position'    => 0,
                'is_dynamic'  => 1
            );
        }
        if (count($data) > 0) {
            try {
                $adapter->insertMultiple(
                    $this->_catProductTable,
                    $data
                );
            } catch (Exception $e) {
                mage::helper('dyncatprod')->debug(
                    'ERROR inserting a batch of data. Message was: '
                    . $e->getMessage(), 10
                );
                mage::helper('dyncatprod')->debug(
                    'Attempting to locate the row that caused the issue', 10
                );
                mage::helper('dyncatprod')->debug(
                    'Starting insert of sigular data rows for this batch', 10
                );
                $numrows = count($data);
                foreach ($data as $key => $row) {
                    try {
                        mage::helper('dyncatprod')->debug(
                            'Inserting single row....' . $key . ' / '
                            . $numrows, 10
                        );
                        $adapter->insertMultiple(
                            $this->_catProductTable,
                            $row
                        );
                    } catch (Exception $e) {
                        mage::logException($e);
                        mage::helper('dyncatprod')->debug(
                            'ERROR inserting a single row of data. Message was: '
                            . $e->getMessage(), 10
                        );
                        mage::helper('dyncatprod')->debug(
                            'Data was : ' . print_r($row, true), 10
                        );
                    }
                }
            }
        }
    }

}
