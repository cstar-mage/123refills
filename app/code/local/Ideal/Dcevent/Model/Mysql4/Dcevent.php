<?php

class Ideal_Dcevent_Model_Mysql4_Dcevent extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the dcevent_id refers to the key field in your database table.
        $this->_init('dcevent/dcevent', 'dcevent_id');
    }
}