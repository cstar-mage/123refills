<?php

class Dolphin_ProductQA_Model_Mysql4_ProductQA_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('productqa/productqa');
    }
}