<?php

class Ideal_Diamondsearch_Model_Mysql4_Diamondsearch extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the diamondsearch_id refers to the key field in your database table.
        $this->_init('diamondsearch/diamondsearch', 'id');
    }
}