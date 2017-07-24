<?php

class Ideal_Customrequest_Model_Mysql4_Customrequest_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('customrequest/customrequest');
    }
}