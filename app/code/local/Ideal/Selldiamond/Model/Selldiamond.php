<?php

class Ideal_Selldiamond_Model_Selldiamond extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('selldiamond/selldiamond');
    }
}