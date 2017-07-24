<?php

class Ideal_Diamondrequest_Model_Diamondrequest extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('diamondrequest/diamondrequest');
    }
}