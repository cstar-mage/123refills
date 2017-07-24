<?php

class Dolphin_Customcontactnew_Model_Mysql4_Customcontactnew_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('customcontactnew/customcontactnew');
    }
}