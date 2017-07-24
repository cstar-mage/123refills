<?php
/**
 * Custom
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Custom
 * @package    Message_Contactform
 * @author     Custom Development Team
 * @copyright  Copyright (c) 2013 Custom. (http://www.magerevol.com)
 * @license    http://opensource.org/licenses/osl-3.0.php
 */
class Message_Contactform_Block_Form extends Mage_Core_Block_Template
{
    protected function _prepareLayout()
    {
        $this->getLayout()->getBlock('head')->addCss('css/contactform/contactform_default.css');
        return parent::_prepareLayout();
    }
    
     public function getContactform()     
     { 
        if (!$this->hasData('contactform')) {
            $this->setData('contactform', Mage::registry('contactform'));
        }
        return $this->getData('contactform');
     }
}