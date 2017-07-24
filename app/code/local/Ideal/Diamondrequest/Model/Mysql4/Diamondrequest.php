<?php

class Ideal_Diamondrequest_Model_Mysql4_Diamondrequest extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the customcontact_id refers to the key field in your database table.
        $this->_init('diamondrequest/diamondrequest', 'diamondrequest_id');
    }
}