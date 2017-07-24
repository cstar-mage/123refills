<?php
/**
 * Rules Controller
 *
 * @category  ProxiBlue
 * @package   DynCatProd
 * @author    Lucas van Staden <sales@proxiblue.com.au>
 * @copyright 2016 Lucas van Staden (ProxiBlue)
 * @license   http://www.proxiblue.com.au/eula EULA
 * @link      http://www.proxiblue.com.au
 */
require_once "Mage/Adminhtml/controllers/Catalog/CategoryController.php";

class ProxiBlue_DynCatProd_Catalog_CategoryController
    extends Mage_Adminhtml_Catalog_CategoryController
{

    public function copyrulesAction()
    {
        $category = mage::getModel('catalog/category')->load($this->getRequest()->getParam('id'));
        if (!$category->getId()) {
            $this->_forward('edit');
        }
        $copyFrom = mage::getModel('catalog/category')->load($this->getRequest()->getParam('copyFrom'));
        if (!$copyFrom->getId()) {
            $this->_forward('edit');
        }
        $category->setData(
            $this->getRequest()->getParam('copyType'), $copyFrom->getData($this->getRequest()->getParam('copyType'))
        );
        $category->save();

        $this->_forward('edit');

        return $this;
    }

    public function updaterulesAction()
    {
        $category = mage::getModel('catalog/category')->load($this->getRequest()->getParam('id'));
        if (!$category->getId()) {
            return;
        }
        $copyFrom = $this->getRequest()->getParam('copyFrom');
        $category->setData($this->getRequest()->getParam('copyType'), $copyFrom);
        $category->save();

        $this->_forward('edit');

    }

    public function refreshListAction()
    {
        $cacheModel = Mage::app()->getCache();
        $cacheModel->clean(
            Zend_Cache::CLEANING_MODE_MATCHING_TAG,
            array('DYNCATPROD_CATEGORY_LIST')
        );
        $this->_forward('categoryList');
    }

    public function categoryListAction()
    {
        $cacheName = 'dyncatprod_category_list_cache';
        $cachedData = Mage::app()->getCache()
            ->load($cacheName);

        if (is_string($cachedData) && count($cachedData) > 0) {
            $arr = unserialize($cachedData);
        } else {
            $category = Mage::getModel('catalog/category');
            $tree = $category->getTreeModel();
            $tree->load();
            $arr = array();
            $name = '';
            foreach ($tree->getCollection() as $cat) {
                $path = explode('/', $cat->getPath());
                foreach ($path as $catPath) {
                    $parentCat = mage::getModel('catalog/category')->load($catPath);
                    if ($parentCat->getId() != $cat->getId()) {
                        $name = $parentCat->getName();
                    }
                }
                $catName = $cat->getName();
                if (empty($catName)) {
                    continue;
                }
                if (count($arr) > 0) {
                    $arr[$cat->getId()] = $name . ' ==> ' . $cat->getName();
                } else {
                    $arr[$cat->getId()] = $name . $cat->getName();
                }
            }

            $cacheModel = Mage::app()->getCache();
            $cacheModel
                ->save(
                    serialize($arr),
                    $cacheName,
                    array('DYNCATPROD_CATEGORY_LIST'), 600
                );

        }

        $this->getResponse()->setHeader(
            'Content-type',
            'application/json'
        )->setBody($this->_success($arr));
    }

    /**
     * Success wrappper
     *
     * @var String
     *
     * @return string
     */
    protected function _success($content)
    {
        return Zend_Json::encode(
            array(
                "error" => false,
                "content" => $content
            )
        );
    }


}
