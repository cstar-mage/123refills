<?php

/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 8/02/15
 * Time: 10:02 PM
 */
class ProxiBlue_DynCatProd_Block_Adminhtml_Catalog_Category_Tab_Dyncatprod_Rules_List
    extends Mage_Core_Block_Template
{

    /** informational display that category will include parent rules **/
    public function getParentConditionCategories()
    {
        return mage::helper('dyncatprod')->getParentConditionCategories(
            Mage::registry('current_category')
        );
    }

    public function getCategoryParentRuleModel($category)
    {
        $ruleModel = Mage::getModel(
            'dyncatprod/rule', array('prefix' => 'parent_conditions')
        );
        $data = array(
            'parent_conditions' => $category->getData(
                'parent_dynamic_attributes'
            ));
        $ruleModel->preLoadPost(
            $data,
            $category
        );
        $result = $ruleModel->asString();

        return $result;
    }

}