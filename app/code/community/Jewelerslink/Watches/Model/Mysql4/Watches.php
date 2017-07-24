<?php

class Jewelerslink_Watches_Model_Mysql4_Watches extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the watches_id refers to the key field in your database table.
        $this->_init('watches/watches', 'code_id');
    }
}