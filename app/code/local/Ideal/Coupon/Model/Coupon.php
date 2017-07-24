<?php

class Ideal_Coupon_Model_Coupon extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        parent::_construct();
        $this->_init('IdealCoupon/coupon');
    }
}