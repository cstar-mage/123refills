<?php
class Mage_Uploadtool_Model_Mysql4_Diamondinquiries_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected function _construct()
    {  
    	parent::_construct();
        $this->_init('uploadtool/diamondinquiries');
    }  
}