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

class PriceWaiter_NYPWidget_Model_Observer
{
    // Adds the "PriceWaiter" tab to the "Manage Categories" page
    public function addTab(Varien_Event_Observer $observer)
    {
        $tabs = $observer->getEvent()->getTabs();
        $tabs->addTab('pricewaiter', array(
            'label' => Mage::helper('catalog')->__('PriceWaiter'),
            'content' => $tabs->getLayout()->createBlock(
                    'nypwidget/category')->toHtml(),
        ));
        return true;
    }

    // Saves "PriceWaiter" options from Category page
    public function saveCategory(Varien_Event_Observer $observer)
    {
        $category = $observer->getEvent()->getCategory();
        $postData = $observer->getEvent()->getRequest()->getPost();
        $enabled = $postData['pricewaiter']['enabled'];
        $ctEnabled = $postData['pricewaiter']['ct_enabled'];

        // Save the current setting, by category, and store
        $nypcategory = Mage::getModel('nypwidget/category')->loadByCategory($category, $category->getStore()->getId());
        $nypcategory->setData('nypwidget_enabled', $enabled);
        $nypcategory->setData('nypwidget_ct_enabled', $ctEnabled);
        $nypcategory->save();

        return true;
    }
}
