<?php

class Mage_Uploadtool_Model_Uploadtool extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('uploadtool/uploadtool');
    }
}