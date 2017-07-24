<?php

class Jewelerslink_Jewelryshare_Model_Mysql4_Jewelryshare_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('jewelryshare/jewelryshare');
    }
}