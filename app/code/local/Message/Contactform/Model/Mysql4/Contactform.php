<?php
/**
 * Message
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
 * @copyright  Copyright (c) 2013 Message. (http://www.magerevol.com)
 * @license    http://opensource.org/licenses/osl-3.0.php
 */
class Message_Contactform_Model_Mysql4_Contactform extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the contactform_id refers to the key field in your database table.
        $this->_init('contactform/contactform', 'qc_id');
    }
}