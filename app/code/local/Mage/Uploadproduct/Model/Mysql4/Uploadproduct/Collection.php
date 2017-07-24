<?php

class Mage_Uploadproduct_Model_Mysql4_Uploadproduct_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('uploadproduct/uploadproduct');
    }
}