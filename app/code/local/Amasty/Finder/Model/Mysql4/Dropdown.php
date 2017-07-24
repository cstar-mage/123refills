<?php
/**
 * @copyright   Copyright (c) 2009-2012 Amasty (http://www.amasty.com)
 */  
class Amasty_Finder_Model_Mysql4_Dropdown extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        $this->_init('amfinder/dropdown', 'dropdown_id');
    }
}