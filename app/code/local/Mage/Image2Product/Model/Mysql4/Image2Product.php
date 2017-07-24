<?php
class Mage_Image2Product_Model_Mysql4_Image2Product extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the uploadtool_id refers to the key field in your database table.
        $this->_init('image2product/image2product', 'image2product_id');
    }
}
?>