<?php

class Ideal_Financing_Model_Mysql4_Financing extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the financing_id refers to the key field in your database table.
        $this->_init('financing/financing', 'financing_id');
    }
}