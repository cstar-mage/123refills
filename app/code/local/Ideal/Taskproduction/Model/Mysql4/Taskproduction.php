<?php

class Ideal_Taskproduction_Model_Mysql4_Taskproduction extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the taskproduction_id refers to the key field in your database table.
        $this->_init('taskproduction/taskproduction', 'taskproduction_id');
    }
}