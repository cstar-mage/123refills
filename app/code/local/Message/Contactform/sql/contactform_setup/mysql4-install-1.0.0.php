<?php
/**
 * Magerevol
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Message
 * @package    Message_Contactform
 * @author     Message Development Team
 * @copyright  Copyright (c) 2013 Magerevol. (http://www.magerevol.com)
 * @license    http://opensource.org/licenses/osl-3.0.php
 */
 
//`subject` varchar(255) DEFAULT NULL,
 
$installer = $this;

$installer->startSetup();

$installer->run("



-- DROP TABLE IF EXISTS {$this->getTable('mr_contactform')};
CREATE TABLE {$this->getTable('mr_contactform')} (
                   `qc_id` bigint(20) NOT NULL AUTO_INCREMENT,                   
                   `cname` varchar(100) DEFAULT NULL,                             
                   `email` varchar(100) NOT NULL,                                
                   `telephone` varchar(20) DEFAULT NULL,                             
                   `comment` text NOT NULL,                                      
                   `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,  
                   PRIMARY KEY (`qc_id`)                                         
                 ) ENGINE=InnoDB DEFAULT CHARSET=utf8;   
    ");

$installer->endSetup(); 