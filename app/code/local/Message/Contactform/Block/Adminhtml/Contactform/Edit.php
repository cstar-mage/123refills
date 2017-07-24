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
class Message_Contactform_Block_Adminhtml_Contactform_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'contactform';
        $this->_controller = 'adminhtml_contactform';
        
//        $this->_updateButton('save', 'label', Mage::helper('contactform')->__('Save Message'));
        $this->_updateButton('delete', 'label', Mage::helper('contactform')->__('Delete Message'));
		$this->_removeButton('save');
                $this->_removeButton('reset');
//        $this->_addButton('saveandcontinue', array(
//            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
//            'onclick'   => 'saveAndContinueEdit()',
//            'class'     => 'save',
//        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('contactform_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'contactform_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'contactform_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('contactform_data') && Mage::registry('contactform_data')->getId() ) {
            return Mage::helper('contactform')->__("View message from '%s'", $this->htmlEscape(Mage::registry('contactform_data')->getName()));
        } else {
            return Mage::helper('contactform')->__('Add Message');
        }
    }
}