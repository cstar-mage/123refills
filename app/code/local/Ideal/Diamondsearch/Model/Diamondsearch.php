<?php

class Ideal_Diamondsearch_Model_Diamondsearch extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('diamondsearch/diamondsearch');
    }
}