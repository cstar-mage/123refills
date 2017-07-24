<?php

class Ideal_Brandmanager_Model_Mysql4_Brandmanager_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('brandmanager/brandmanager');
    }
}