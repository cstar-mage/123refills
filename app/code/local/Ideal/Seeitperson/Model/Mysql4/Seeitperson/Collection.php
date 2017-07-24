<?php

class Ideal_Seeitperson_Model_Mysql4_Seeitperson_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('seeitperson/seeitperson');
    }
}