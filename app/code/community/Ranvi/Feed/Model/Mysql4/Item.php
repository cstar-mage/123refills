<?php

class Ranvi_Feed_Model_Mysql4_Item extends Mage_Core_Model_Mysql4_Abstract

{

    public function _construct()

    {

        $this->_init('ranvi_feed/item', 'id');

    }

    

}