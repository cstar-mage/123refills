<?php

class Ideal_Testing_Model_Testing extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('testing/testing');
    }
}