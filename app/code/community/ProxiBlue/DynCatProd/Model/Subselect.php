<?php

/**
 * Model to hold and control subselect data in place of arrays
 *
 * @category  ProxiBlue
 * @package   DynCatProd
 * @author    Lucas van Staden <sales@proxiblue.com.au>
 * @copyright 2016 Lucas van Staden (ProxiBlue)
 * @license   http://www.proxiblue.com.au/eula EULA
 * @link      http://www.proxiblue.com.au
 */
class ProxiBlue_DynCatProd_Model_Subselect
    extends Mage_Core_Model_Abstract
{

    const DUMP_TO_DB_COUNT = 1000;

    protected $_preDumpData = array();
    protected $_helper = null;

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->_init('dyncatprod/subselect');

        return $this;
    }

    public function addItem($itemId)
    {
        $this->_preDumpData[] = array(
            'category_id' => (int)$this->getCategory()->getId(),
            'product_id' => (int)$itemId);
        if (count($this->_preDumpData) == self::DUMP_TO_DB_COUNT) {
            mage::helper('dyncatprod')->debug(
                "Writing data to db",
                10
            );
            $this->dumpDataToDb();
        }

        return $this;
    }

    public function dumpDataToDb()
    {
        if (count($this->getPreDumpData()) == 0) {
            $this->getCategory()->setRemoveAllDynamic(true);
            return;
        }
        $this->getCategory()->setDoPostedProducts(true);
        $this->_getResource()->save($this);
        $this->_preDumpData = array(); // reset
    }

    public function setPostedProducts($truncate = true)
    {
        try {
            if ($truncate) {
                // clear out any products for this category
                $this->_getResource()->delete($this->getCategory());
            }
            $collection = $this->getCollection()
                ->addFieldToSelect('product_id')
                ->addFieldToFilter(
                    'category_id',
                    $this->getCategory()->getId()
                );

            $pagesize = mage::getStoreConfig(
                'dyncatprod/rebuild/collection_pagesize'
            );
            $collection->setPageSize($pagesize);
            $collection->getSelect()->distinct(true);
            $totalItemsInserted = $collection->getSize();
            $pages = $collection->getLastPageNumber();

            $currentPage = 1;
            $this->getHelper()->debug(
                "Start of custom postedProducts",
                5
            );
            do {
                $memory = memory_get_peak_usage(true);
                $this->getHelper()->debug(
                    "Posted Products: Processing page {$currentPage} / {$pages} using batch size of {$pagesize} with memory at {$memory}",
                    5
                );
                //Tell the collection which page to load.
                $collection->setCurPage($currentPage);
                $collection->load();
                $this->_getResource()->linkProductsToCategory(
                    $collection->getItems(),
                    $this->getCategory()
                );

                $currentPage++;
                //make the collection unload the data in memory so it will pick up the next page when load() is called.
                $collection->clear();
            } while ($currentPage <= $pages);
            // clear out this batch
            $this->getCategory()->setIsChangedProductList(true);
            $this->getHelper()->debug(
                "End of custom postedProducts. Inserted " . $totalItemsInserted . " items",
                5
            );
        } catch (Exception $e) {
            self::getHelper()->debug(
                "ERROR setting posted products for :" . $this->getCategory()->getName()
                . ' ' . $this->getCategory()->getPath()
                . " - Message was: " . $e->getMessage()
            );
        }
        $this->clear();
    }

    public function getHelper()
    {
        if ($this->_helper == null) {
            $this->_helper = mage::helper('dyncatprod');
        }

        return $this->_helper;
    }

    public function getPreDumpData()
    {
        return $this->_preDumpData;
    }

    public function clear()
    {
        $this->_getResource()->deleteSubselect($this->getCategory());

        return $this;
    }

    public function getAllData()
    {
        $productIds = array();
        $collection = $this->getCollection()
            ->addFieldToSelect('product_id')
            ->addFieldToFilter(
                'category_id',
                $this->getCategory()->getId()
            );
        $pagesize = mage::getStoreConfig(
            'dyncatprod/rebuild/collection_pagesize'
        );
        $collection->setPageSize($pagesize);
        $pages = $collection->getLastPageNumber();
        $currentPage = 1;
        do {
            Mage::helper('dyncatprod')->debug(
                "Extracting results form subselect system: Processing page "
                . "{$currentPage} / {$pages} "
                . "using batch size of {$pagesize}",
                10
            );
            //Tell the collection which page to load.
            $collection->setCurPage($currentPage);
            $collection->load();
            foreach($collection as $row) {
                $productIds[] = $row->getProductId();
            }
            $currentPage++;
            $collection->clear();
        } while ($currentPage <= $pages);
        $this->clear();
        return $productIds;
    }

}
