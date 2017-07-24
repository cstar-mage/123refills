<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Mswebdesign
 * @package    Mswebdesign_Mswebdesign_CustomOrderNumber
 * @copyright  Copyright (c) 2013 münster-webdesign.net (http://www.muenster-webdesign.net)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author     Christian Grugel <cgrugel@muenster-webdesign.net>
 */
class Mswebdesign_CustomOrderNumber_Model_Adminhtml_System_Config_Source_Dateprefix
{
    public function toOptionArray()
    {
        return array(
            array('value' => '', 'label'=>Mage::helper('mswebdesign_customordernumber')->__('No date prefix')),
            array('value' => 'Y', 'label'=>Mage::helper('mswebdesign_customordernumber')->__('YYYY (Example: 2013)'))
        );
    }
}