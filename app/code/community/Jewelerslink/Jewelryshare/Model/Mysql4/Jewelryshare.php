<?php

class Jewelerslink_Jewelryshare_Model_Mysql4_Jewelryshare extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the jewelryshare_id refers to the key field in your database table.
        $this->_init('jewelryshare/jewelryshare', 'code_id');
    }
}