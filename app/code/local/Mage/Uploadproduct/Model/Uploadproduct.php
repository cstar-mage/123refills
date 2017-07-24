<?php

class Mage_Uploadproduct_Model_Uploadproduct extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('uploadproduct/uploadproduct');
    }
}