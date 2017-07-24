<?php

/*
 * Copyright 2013-2015 Price Waiter, LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 *
 */

class PriceWaiter_NYPWidget_Block_Adminhtml_Signup extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('pricewaiter/signup.phtml');
    }

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $el)
    {
        return $this->_toHtml();
    }

    public function getButtonHtml()
    {
        // If they have already set their API key, don't show the button.
        if (Mage::getStoreConfig('pricewaiter/configuration/api_key')) {
            return;
        }

        $button = $this->getLayout()->createBlock('adminhtml/widget_button')->setData(
            array(
                'id' => 'nypwidget_signup',
                'label' => $this->helper('adminhtml')->__('Sign Up for PriceWaiter'),
                'disabled' => true
            )
        );

        return $button->toHtml();
    }

    public function getTokenUrl()
    {
        return Mage::helper('adminhtml')->getUrl('adminhtml/adminhtml_pricewaiter/token');
    }

    public function getSecretUrl()
    {
        return Mage::helper('adminhtml')->getUrl('adminhtml/adminhtml_pricewaiter/secret');
    }
}
