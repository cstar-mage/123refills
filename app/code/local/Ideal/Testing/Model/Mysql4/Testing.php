<?php

class Ideal_Testing_Model_Mysql4_Testing extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the testing_id refers to the key field in your database table.
        $this->_init('testing/testing', 'testing_id');
    }
}