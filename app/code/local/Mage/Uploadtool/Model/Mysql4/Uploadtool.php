<?php

class Mage_Uploadtool_Model_Mysql4_Uploadtool extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the uploadtool_id refers to the key field in your database table.
        $this->_init('uploadtool/uploadtool', 'uploadtool_id');
    }
}