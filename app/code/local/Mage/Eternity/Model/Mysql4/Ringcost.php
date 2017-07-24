<?php 
class Mage_Eternity_Model_Mysql4_Ringcost extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {   
        $this->_init('eternity/ringcost', 'id');
    }
}