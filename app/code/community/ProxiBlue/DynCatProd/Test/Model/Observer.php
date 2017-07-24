<?php

/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 17/02/15
 * Time: 10:17 PM
 */
class ProxiBlue_DynCatProd_Test_Model_Observer extends EcomDev_PHPUnit_Test_Case
{

    /**
     * Category rule:*
     *
     * @test
     * @dataProvider dataProvider
     */
    public function dynamicRule($ruleData, $parentRuleData, $expectedId)
    {
        // reset category
        mage::helper('dyncatprod')->disableIndexes();
        $category = Mage::getModel('catalog/category');
        $category->setName('dynamic unit test');
        $category->setUrlKey('unittest-category');
        $category->setIsActive(1);
        $category->setDisplayMode('PRODUCTS');
        $category->setIsAnchor(1); //for active achor
        $category->setStoreId(Mage::app()->getStore()->getId());
        $parentCategory = Mage::getModel('catalog/category')->load(2);
        $category->setPath($parentCategory->getPath());
        /** @noinspection PhpUndefinedMethodInspection */
        $category->setDynamicAttributes($ruleData);
        $category->setParentDynamicAttributes($parentRuleData);
        /** @noinspection PhpUndefinedMethodInspection */
        $category->setIsDynamicCronRun(true);
        $category->setIsDynamic(true);
        $category->save();
        mage::helper('dyncatprod')->debug(
            "Unit Test Category id is " . $category->getId(),
            5
        );
        mage::helper('dyncatprod')->debug(
            "Unit Test Expected id is " . $expectedId,
            5
        );
        mage::helper('dyncatprod')->debug(
            "Unit Test rule data id is " . $ruleData,
            5
        );
        mage::helper('dyncatprod')->rebuildCategory(
            $category,
            true
        );
        $category->save();
        $category = mage::getModel('catalog/category')->load($category->getId());
        $productCollection = Mage::getResourceModel('catalog/product_collection')
            ->addCategoryFilter($category);
        $productCount = $productCollection->getSize();
        $category->delete();
        $expected = $this->expected("1-{$expectedId}");
        $this->assertEquals(
            $expected->getProductCount(),
            $productCount,
            "Expected id: {$expectedId}"
        );
        unset($category);
    }


}
