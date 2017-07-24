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

class PriceWaiter_NYPWidget_Model_PaymentMethod extends Mage_Payment_Model_Method_Abstract
{
    protected $_code = 'nypwidget';

    protected $_isGateway = false;
    protected $_canOrder = true;
    protected $_canAuthorize = false;
    protected $_canCapture = false;
    protected $_canCapturePartial = false;
    protected $_canRefund = false;
    protected $_canVoid = true;
    protected $_canUseInternal = true;
    protected $_canUseCheckout = false;
    protected $_canUseForMultishipping = false;

    public function authorize(Varien_Object $payment, $amount)
    {
        return $this;
    }

    public function capture(Varien_Object $payment, $amount)
    {
        return $this;
    }

    public function void(Varien_Object $payment)
    {
        return $this;
    }

    public function isAvailable($quote = null)
    {
        return false;
    }
}
