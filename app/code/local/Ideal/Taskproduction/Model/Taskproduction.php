<?php

class Ideal_Taskproduction_Model_Taskproduction extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('taskproduction/taskproduction');
    }
}