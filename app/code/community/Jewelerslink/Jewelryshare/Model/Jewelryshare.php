<?php

class Jewelerslink_Jewelryshare_Model_Jewelryshare extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('jewelryshare/jewelryshare');
    }
}