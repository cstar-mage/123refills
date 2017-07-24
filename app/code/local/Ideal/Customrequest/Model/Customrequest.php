<?php

class Ideal_Customrequest_Model_Customrequest extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('customrequest/customrequest');
    }
}