<?php

class Mage_Uploadproduct_Model_Mysql4_Uploadproduct extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the uploadproduct_id refers to the key field in your database table.
        $this->_init('uploadproduct/uploadproduct', 'uploadproduct_id');
    }
}