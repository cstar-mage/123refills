<?php

class Ideal_Stud_Model_Mysql4_Clarity extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {           
        $this->_init('stud/clarity', 'clarity_id');
    }
}