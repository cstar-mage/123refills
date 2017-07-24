<?php

class Ideal_Brandmanager_Model_Mysql4_Brandmanager extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the brandmanager_id refers to the key field in your database table.
        $this->_init('brandmanager/brandmanager', 'brandmanager_id');
    }
}