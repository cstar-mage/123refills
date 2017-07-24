<?php

class Ideal_Stud_Model_Mysql4_Carat extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {           
        $this->_init('stud/carat', 'carat_id');
    }
}