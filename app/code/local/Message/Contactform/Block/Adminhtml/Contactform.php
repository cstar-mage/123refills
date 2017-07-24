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
class Message_Contactform_Block_Adminhtml_Contactform extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_contactform';
    $this->_blockGroup = 'contactform';
    $this->_headerText = Mage::helper('contactform')->__('Messages');
    $this->_addButtonLabel = Mage::helper('contactform')->__('Add Message');

    parent::__construct();
    $this->_removeButton('add');
  }
}