<?php

class Ideal_Dcevent_Model_Mysql4_Dcevent_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('dcevent/dcevent');
    }
}