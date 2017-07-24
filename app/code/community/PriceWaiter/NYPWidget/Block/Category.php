<?php

/*
 * Copyright 2013-2015 Price Waiter, LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */

class PriceWaiter_NYPWidget_Block_Category extends Mage_Adminhtml_Block_Template
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    public function __construct()
    {
        $this->setTemplate('pricewaiter/categorytab.phtml');
    }

    private function _getCategory()
    {
        $category = Mage::registry('category');
        $nypcategory = Mage::getModel('nypwidget/category')->loadByCategory($category, $category->getStore()->getId());

        return $nypcategory;
    }

    public function getIsEnabled()
    {
        $category = $this->_getCategory();
        return $category->isActive(true);
    }

    public function getIsConversionToolsEnabled()
    {
        $category = $this->_getCategory();
        return $category->isConversionToolsEnabled(true);
    }

    public function getTabLabel()
    {
        return $this->__('PriceWaiter Widget');
    }

    public function getTabTitle()
    {
        return $this->__('PriceWaiter');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }

}
