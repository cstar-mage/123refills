<?php
/**
 * TurnkeyE Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0).
 * It is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you are unable to obtain it through the world-wide-web, please send
 * an email to info@turnkeye.com so we can send you a copy immediately.
 *
 * @category   Turnkeye
 * @package    Turnkeye_Testimonial
 * @copyright  Copyright (c) 2010-2012 TurnkeyE Co. (http://turnkeye.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Upgrade script 1.1.1 -> 1.1.2
 *
 * @category   Turnkeye
 * @package    Turnkeye_Testimonial
 * @author     Viacheslav Fedorenko <v.fedorenko@turnkeye.com>
 */

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$table_from = $installer->getTable('testimonials');
$table_to = $installer->getTable('turnkeye_testimonial');

$installer->run("
    rename table {$table_from} to {$table_to};
");

$installer->endSetup();
