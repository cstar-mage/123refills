<?php

class Mage_Image2Product_Model_Mysql4_Image2Product_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('image2product/image2product');
    }
}
?>