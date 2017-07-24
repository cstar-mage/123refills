<?php

class Mycomp_Pricemanager_Model_Mysql4_Pricemanager extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the pricemanager_id refers to the key field in your database table.
        $this->_init('pricemanager/pricemanager', 'pricemanager_id');
    }
}