<?php

class Ideal_Editor_Model_Mysql4_Editor extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the editor_id refers to the key field in your database table.
        $this->_init('editor/editor', 'editor_id');
    }
}