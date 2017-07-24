<?php

class Ranvi_Feed_Model_Mysql4_Custom_Attribute_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract

{

    public function _construct()

    {

        parent::_construct();

        $this->_init('ranvi_feed/custom_attribute');

    }

    

}