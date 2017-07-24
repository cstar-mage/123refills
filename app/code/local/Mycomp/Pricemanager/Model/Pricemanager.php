<?php

class Mycomp_Pricemanager_Model_Pricemanager extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('pricemanager/pricemanager');
    }
}