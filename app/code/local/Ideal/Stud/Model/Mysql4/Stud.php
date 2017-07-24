<?php

class Ideal_Stud_Model_Mysql4_Stud extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the stud_id refers to the key field in your database table.
        $this->_init('stud/stud', 'diamondstud_id');
    }
}