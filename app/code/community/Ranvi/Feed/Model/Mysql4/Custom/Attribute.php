<?php

class Ranvi_Feed_Model_Mysql4_Custom_Attribute extends Mage_Core_Model_Mysql4_Abstract

{

    public function _construct()

    {

        $this->_init('ranvi_feed/custom_attribute', 'id');

    }

    

}