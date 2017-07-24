<?php

class Dolphin_Customcontactnew_Model_Mysql4_Customcontactnew extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the customcontact_id refers to the key field in your database table.
        $this->_init('customcontactnew/customcontactnew', 'customcontact_id');
    }
}