<?php

class Ideal_Editor_Model_Mysql4_Editor_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('editor/editor');
    }
}