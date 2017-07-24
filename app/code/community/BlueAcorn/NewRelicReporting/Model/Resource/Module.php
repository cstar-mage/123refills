<?php

/**
 * @package     BlueAcorn\Reporting
 * @version     1.1
 * @author      Magento, Inc. <eeadmin@magentocommerce.com>
 * @copyright   Copyright © 2014 Magento, Inc.
 */
class BlueAcorn_NewRelicReporting_Model_Resource_Module extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Initialize resource
     */
    protected function _construct()
    {
        $this->_init('blueacorn_newrelicreporting/module', 'entity_id');
    }
}