<?php

class Ideal_Stud_Model_Carat extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('stud/carat');
    }
}