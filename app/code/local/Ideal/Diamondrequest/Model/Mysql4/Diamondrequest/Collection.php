<?php

class Ideal_Diamondrequest_Model_Mysql4_Diamondrequest_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('diamondrequest/diamondrequest');
    }
}