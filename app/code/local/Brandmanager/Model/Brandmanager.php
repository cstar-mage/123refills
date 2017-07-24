<?php

class Ideal_Brandmanager_Model_Brandmanager extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('brandmanager/brandmanager');
    }
}