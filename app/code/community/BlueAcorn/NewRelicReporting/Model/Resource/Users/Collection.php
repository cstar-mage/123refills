<?php

/**
 * @package     BlueAcorn\DatabaseLogging
 * @version     1.1
 * @author      Magento, Inc. <eeadmin@magentocommerce.com>
 * @copyright   Copyright © 2014 Magento, Inc.
 */
class BlueAcorn_NewRelicReporting_Model_Resource_Users_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Initialize resource
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('blueacorn_newrelicreporting/users');
    }
}