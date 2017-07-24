<?php

class Dolphin_ProductQA_Model_ProductQA extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('productqa/productqa');
    }
}