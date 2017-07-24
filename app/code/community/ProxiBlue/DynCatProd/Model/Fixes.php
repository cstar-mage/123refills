<?php

/**
 * Cron functions
 *
 * @category  ProxiBlue
 * @package   DynCatProd
 * @author    Lucas van Staden <sales@proxiblue.com.au>
 * @copyright 2016 Lucas van Staden (ProxiBlue)
 * @license   http://www.proxiblue.com.au/eula EULA
 * @link      http://www.proxiblue.com.au
 */
class ProxiBlue_DynCatProd_Model_Fixes
{

    protected $_helper = null;

    public static function getHelper()
    {
        return mage::helper('dyncatprod');
    }

    static function nullRules()
    {
        // fix issue with rules that are actually null, holding
        // basic rule data, which can screw things up.
        $categories = Mage::getModel('catalog/category')
            ->getCollection()
            ->addAttributeToSelect('*');
        foreach ($categories as $category) {
            $changed = false;
            /** own rules as potential parent */
            if ($category->getParentDynamicAttributes()
                || strlen(trim($category->getParentDynamicAttributes())) > 0
            ) {
                $data = unserialize($category->getParentDynamicAttributes());
                if (is_array($data) && count($data) == 1) {
                    $category->setParentDynamicAttributes(null);
                    $changed = true;
                }
                unset($data);
            }
            /** own rules */
            if ($category->getDynamicAttributes()
                || strlen(trim($category->getDynamicAttributes())) > 0
            ) {
                $data = unserialize($category->getDynamicAttributes());
                if (is_array($data) && count($data) == 1) {
                    $category->setDynamicAttributes(null);
                    $changed = true;
                }
            }
            if ($changed) {
                echo "Found category {$category->getName()} with no rules. Resetting the rule attributes to null\n";
                $category->save();
            }
        }
    }

    static function dynamicFlag()
    {
        // fix data related to a bug found in version 4.14, which marked products in categories
        // as dynamic, if no rules were present.
        $categories = Mage::getModel('catalog/category')
            ->getCollection()
            ->addAttributeToSelect('*');
        $resource = Mage::getSingleton('core/resource');
        $write = $resource->getConnection('core_write');
        $tableName = $resource->getTableName('catalog/category_product');
        foreach ($categories as $category) {
            $ruleData = mage::helper('dyncatprod')->loadRuleData($category);
            if (count($ruleData) == 0) {
                echo "Found category {$category->getName()} with no rules. Removing any products marked as dynamic\n";
                $query = "UPDATE {$tableName} SET is_dynamic = 0 WHERE category_id = "
                    . (int)$category->getId();
                $write->query($query);
            }
        }
    }

    static function clearRules()
    {
        // Simply iterate all categories, and clear rule attributes
        $categories = Mage::getModel('catalog/category')
            ->getCollection()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter(
                'parent_dynamic_attributes',
                array(
                    'notnull' => true)
            );
        echo "First dealing with PARENT rules...\n";
        foreach ($categories as $category) {
            echo "Found category {$category->getName()} with parent rules. Setting the rule to null\n";
            $category->setParentDynamicAttributes(null);
            $category->save();
        }
        // Simply iterate all categories, and clear rule attributes
        $categories = Mage::getModel('catalog/category')
            ->getCollection()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter(
                'dynamic_attributes',
                array(
                    'notnull' => true)
            );
        echo "\n\nNow dealing with category rules...\n";
        foreach ($categories as $category) {
            echo "Found category {$category->getName()} with rules. Setting the rule to null\n";
            $category->setDynamicAttributes(null);
            $category->save();
        }
    }
}
