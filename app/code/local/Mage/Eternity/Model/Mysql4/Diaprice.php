<?php 
class Mage_Eternity_Model_Mysql4_Diaprice extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {   
        $this->_init('eternity/diaprice', 'id');
    }
}