<?php

class Ideal_Seeitperson_Model_Seeitperson extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('seeitperson/seeitperson');
    }
}