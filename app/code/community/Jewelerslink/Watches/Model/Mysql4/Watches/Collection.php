<?php

class Jewelerslink_Watches_Model_Mysql4_Watches_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('watches/watches');
    }
}