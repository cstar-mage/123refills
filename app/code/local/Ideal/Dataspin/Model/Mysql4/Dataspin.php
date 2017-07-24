<?php

class Ideal_Dataspin_Model_Mysql4_Dataspin extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the dataspin_id refers to the key field in your database table.
        $this->_init('dataspin/dataspin', 'dataspin_id');
    }
}