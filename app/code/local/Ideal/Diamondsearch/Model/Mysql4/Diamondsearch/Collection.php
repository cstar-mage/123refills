<?php

class Ideal_Diamondsearch_Model_Mysql4_Diamondsearch_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('diamondsearch/diamondsearch');
    }
}