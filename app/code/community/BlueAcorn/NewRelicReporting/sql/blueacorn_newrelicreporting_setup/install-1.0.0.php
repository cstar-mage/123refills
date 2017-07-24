<?php
/**
 * @package     BlueAcorn\Reporting
 * @version     1.1
 * @author      Magento, Inc. <eeadmin@magentocommerce.com>
 * @copyright   Copyright © 2014 Magento, Inc.
 */

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('blueacorn_newrelicreporting/module'))
    ->addColumn(
        'entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary'  => true,
        ), 'Module ID'
    )
    ->addColumn(
        'name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'Module Name'
    )
    ->addColumn(
        'active', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'Module Active Status'
    )
    ->addColumn(
        'codepool', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'Module Codepool'
    )
    ->addColumn(
        'version', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'Module Version'
    )
    ->addColumn(
        'state', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'Module State'
    )
    ->addColumn(
        'updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            'nullable' => false,
        ), 'Updated at'
    )
    ->addIndex(
        $installer->getIdxName('blueacorn_newrelicreporting/module', array('entity_id')),
        array('entity_id')
    )
    ->setComment('Module Status Table');
$installer->getConnection()->createTable($table);

//reporting_counts table

$counts = $installer->getConnection()
    ->newTable($installer->getTable('blueacorn_newrelicreporting/counts'))
    ->addColumn(
        'entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary'  => true,
        ), 'Entity ID'
    )->addColumn(
        'type', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'Item Reported'
    )->addColumn(
        'count', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned' => true
        ), 'Count Value'
    )->addColumn(
        'updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            'nullable' => false,
            'default'  => Varien_Db_Ddl_Table::TIMESTAMP_INIT
        ), 'Updated at'
    )->setComment('Reporting for all count related events generated via the cron job');

$installer->getConnection()->createTable($counts);

//reporting_orders table

$orders = $installer->getConnection()
    ->newTable($installer->getTable('blueacorn_newrelicreporting/orders'))
    ->addColumn(
        'entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary'  => true,
        ), 'Module ID'
    )->addColumn(
        'customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned' => true,
            'nullable' => true
        ), 'Customer ID'
    )->addColumn(
        'total', Varien_Db_Ddl_Table::TYPE_DECIMAL, array(20, 2), array(
            'unsigned' => true
        ), 'Total From Store'
    )->addColumn(
        'total_base', Varien_Db_Ddl_Table::TYPE_DECIMAL, array(20, 2), array(
            'unsigned' => true
        ), 'Total From Base Currency'
    )->addColumn(
        'item_count', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned' => true,
            'nullable' => false
        ), 'Line Item Count'
    )->addColumn(
        'updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            'nullable' => false,
            'default'  => Varien_Db_Ddl_Table::TIMESTAMP_INIT
        ), 'Updated at'
    )->setComment('Reporting for all orders');

$installer->getConnection()->createTable($orders);


//reporting_users table

$users = $installer->getConnection()
    ->newTable($installer->getTable('blueacorn_newrelicreporting/users'))
    ->addColumn(
        'entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary'  => true,
        ), 'Entity ID'
    )->addColumn(
        'type', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'User Type'
    )->addColumn(
        'action', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'Action Performed'
    )->addColumn(
        'updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            'nullable' => false,
            'default'  => Varien_Db_Ddl_Table::TIMESTAMP_INIT
        ), 'Updated at'
    )->setComment('Reorting for user actions');

$installer->getConnection()->createTable($users);

//reporting_system_update table
$system = $installer->getConnection()
    ->newTable($installer->getTable('blueacorn_newrelicreporting/system'))
    ->addColumn(
        'entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary'  => true,
        ), 'Entity ID'
    )->addColumn(
        'type', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'Update Type'
    )->addColumn(
        'action', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'Action Performed'
    )->addColumn(
        'updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            'nullable' => false,
            'default'  => Varien_Db_Ddl_Table::TIMESTAMP_INIT
        ), 'Updated at'
    )->setComment('Reorting for user actions');

$installer->getConnection()->createTable($system);
