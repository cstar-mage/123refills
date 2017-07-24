<?php

class Jewelerslink_Watches_Model_Watches extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('watches/watches');
    }
}