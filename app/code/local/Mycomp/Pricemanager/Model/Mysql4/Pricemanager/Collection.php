<?php

class Mycomp_Pricemanager_Model_Mysql4_Pricemanager_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('pricemanager/pricemanager');
    }
}