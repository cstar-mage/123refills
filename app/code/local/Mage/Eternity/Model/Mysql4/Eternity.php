<?php

class Mage_Eternity_Model_Mysql4_Eternity extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the eternity_id refers to the key field in your database table.
        $this->_init('eternity/eternity', 'eternity_id');
    }
}