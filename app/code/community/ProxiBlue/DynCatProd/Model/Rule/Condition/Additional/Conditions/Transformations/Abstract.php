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
class ProxiBlue_DynCatProd_Model_Rule_Condition_Additional_Conditions_Transformations_Abstract
    extends
    ProxiBlue_DynCatProd_Model_Rule_Condition_Additional_Conditions_Abstract
{

    /**
     * Internal cached helper object
     *
     * @var object
     */
    protected $_helper = null;
    protected $_inputType = 'text';
    protected $_subselectObject;


    public function __construct()
    {
        parent::__construct();
    }


    public function getHelper()
    {
        if ($this->_helper == null) {
            $this->_helper = mage::helper('dyncatprod');
        }

        return $this->_helper;
    }

    /**
     * validateLater
     *
     * Iterate all products found, and if a complex product type
     * determine if selected rule is valid
     *
     *
     *
     * @return boolean
     */
    public function validateLater($category)
    {
        /**
         * Array storage of data just don't work when we have massive catalogs to works with
         * Instead store the found id's in the new subselect model for later use
         */
        $this->_subselectObject = mage::getModel('dyncatprod/subselect')
            ->setCategory($category)
            ->clear();
        $pagesize = 300; // hard coded page size for transforms

        $productIds = $category->getDynamicProducts();
        $numProducts = count($productIds);
        $collection = Mage::getResourceModel('catalog/product_collection')
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('entity_id', array('in' => $productIds));
        unset($productIds);
        $pages = round($numProducts / $pagesize);
        if($pages == 0) { $pages = 1; }
        $currentPage = 1;
        if (Mage::getStoreConfig('dyncatprod/debug/enabled')
            && Mage::getStoreConfig('dyncatprod/debug/level') >= 100
        ) {
            // debugging this is hell, so limit the number of pages to pull
            $this->getHelper()->debug(
                "In debug mode with level 100. Only doing last page to speed up debugging."
                . $collection->getSelect(),
                5
            );
            $currentPage = $pages;
        }
        $this->getHelper()->debug(
            "Product collection before transformation of parents: "
            . $collection->getSelect(),
            5
        );
        $collection->setPageSize($pagesize);
        do {
            $memory = memory_get_peak_usage(true);
            $this->getHelper()->debug(
                "Filters: Processing page {$currentPage} / {$pages} using batch size of {$pagesize} with memory at {$memory}",
                10
            );
            //Tell the collection which page to load.
            $collection->setCurPage($currentPage);
            $collection->load();
            foreach ($collection as $product) {
                $this->getHelper()->debug(
                    "processing product: " . $product->getId(),
                    50
                );
                $this->getChildData($product);
            }
            $currentPage++;
            //make the collection unload the data in memory so it will pick up the next page when load() is called.
            $collection->clear();
            $this->_subselectObject->dumpDataToDb();
        } while ($currentPage <= $pages);

        $this->getHelper()->debug(
            "End of product transformation loop",
            4
        );

        $category->setDynamicProducts($this->_subselectObject->getAllData());
        $category->setDoPostedProducts(false);

        return true;
    }

    /**
     * Not really an attribute, but the functionality in the parent is generic enough
     * to allow us to validate our numbers with it :)
     *
     * @param mixed $validatedValue
     *
     * @return bool
     */
    public function validateAttribute($validatedValue)
    {
        return parent::validateAttribute($validatedValue);
    }
}
