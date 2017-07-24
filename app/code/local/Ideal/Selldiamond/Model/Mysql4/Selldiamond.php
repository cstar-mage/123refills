<?php

class Ideal_Selldiamond_Model_Mysql4_Selldiamond extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the selldiamond_id refers to the key field in your database table.
        $this->_init('selldiamond/selldiamond', 'selldiamond_id');
    }
}