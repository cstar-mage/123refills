<?php

class Ideal_Evolved_Model_Mysql4_Evolved extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the evolved_id refers to the key field in your database table.
        $this->_init('evolved/evolved', 'evolved_id');
    }
}