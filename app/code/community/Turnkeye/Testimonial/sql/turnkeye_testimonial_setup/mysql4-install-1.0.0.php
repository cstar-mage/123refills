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
 * Installation script
 *
 * @category   Turnkeye
 * @package    Turnkeye_Testimonial
 * @author     Viacheslav Fedorenko <v.fedorenko@turnkeye.com>
 */

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$table = $installer->getTable('testimonials');

$installer->run("
    create table IF NOT EXISTS {$table} (
        testimonial_id int(11) unsigned not null auto_increment,
        testimonial_position int(11) default 0,
        testimonial_name varchar(50) not null default '',
        testimonial_text text not null default '',
        testimonial_img varchar(128) default NULL,
        testimonial_sidebar tinyint(4) NOT NULL,
        PRIMARY KEY(testimonial_id)
    ) engine=InnoDB default charset=utf8;
");

$installer->endSetup();
