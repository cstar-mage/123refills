<?php

class Ideal_Taskproduction_Model_Mysql4_Taskproduction_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('taskproduction/taskproduction');
    }
}