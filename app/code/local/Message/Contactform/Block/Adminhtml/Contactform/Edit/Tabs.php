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
class Message_Contactform_Block_Adminhtml_Contactform_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('contactform_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('contactform')->__('Message Detail'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('contactform')->__('Message Detail'),
          'title'     => Mage::helper('contactform')->__('Message Detail'),
          'content'   => $this->getLayout()->createBlock('contactform/adminhtml_contactform_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}