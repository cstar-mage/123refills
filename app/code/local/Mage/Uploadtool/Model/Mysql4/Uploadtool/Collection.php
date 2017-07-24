<?php

class Mage_Uploadtool_Model_Mysql4_Uploadtool_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('uploadtool/uploadtool');
    }
}