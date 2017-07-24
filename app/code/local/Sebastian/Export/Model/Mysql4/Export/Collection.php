<?php

/**
 *
 * Copyright Sebastian Enzinger <sebastian@enzinger.de> www.sebastian-enzinger.de
 *
 * All rights reserved.
 *
**/

    class Sebastian_Export_Model_Mysql4_Export_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract

    {
        public function _construct()
        {
            parent::_construct();
            $this->_init('export/export');
        }
    }