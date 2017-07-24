<?php

/**
 * MageWorx
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MageWorx EULA that is bundled with
 * this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.mageworx.com/LICENSE-1.0.html
 *
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@mageworx.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the extension
 * to newer versions in the future. If you wish to customize the extension
 * for your needs please refer to http://www.mageworx.com/ for more information
 * or send an email to sales@mageworx.com
 *
 * @category   MageWorx
 * @package    MageWorx_Adminhtml
 * @copyright  Copyright (c) 2009 MageWorx (http://www.mageworx.com/)
 * @license    http://www.mageworx.com/LICENSE-1.0.html
 */

/**
 * MageWorx Adminhtml extension
 *
 * @category   MageWorx
 * @package    MageWorx_Adminhtml
 * @author     MageWorx Dev Team <dev@mageworx.com>
 */
class MageWorx_Adminhtml_Block_Customoptions_Options_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {

    public function __construct() {
        $this->_objectId = 'group_id';
        $this->_blockGroup = 'mageworx';
        $this->_controller = 'customoptions_options';
        $helper = Mage::helper('customoptions');

        parent::__construct();

        $this->_updateButton('save', '', array(
            'label' => $helper->__('Save Options'),
            'onclick' => 'saveOptionsForm()',
            'class' => 'save',
            'sort_order' => 10
            ), 1);

        $this->_updateButton('delete', '', array(
            'label' => $helper->__('Delete Options'),
            'onclick' => "deleteConfirm('{$helper->__('If you delete this item(s) all the options inside will be deleted as well?')}', '{$this->getUrl('*/*/delete', array('group_id' => (int) $this->getRequest()->getParam('group_id')))}')",
            'class' => 'delete',
            'sort_order' => 10
        ));

        $this->_addButton('duplicate', array(
            'label' => $helper->__('Duplicate'),
            'onclick' => "location.href='{$this->getUrl('*/*/duplicate', array('group_id' => (int) $this->getRequest()->getParam('group_id')))}'",
            'class' => 'duplicate',
            'sort_order' => 10
        ));

        $this->_addButton('saveandcontinue', array(
            'label' => $helper->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
            'sort_order' => 10
                ), -100);

        $this->_formScripts[] = "
        	function saveOptionsForm() {
        		applySelectedProducts('save')
            }
            function saveAndContinueEdit() {
                applySelectedProducts('saveandcontinue')
            }
        ";
    }

    public function getHeaderText() {
        if (Mage::registry('customoptions_data') && Mage::registry('customoptions_data')->getId()) {
            return Mage::helper('customoptions')->__("Edit Options '%s'", $this->htmlEscape(Mage::registry('customoptions_data')->getTitle()));
        } else {
            return Mage::helper('customoptions')->__('Add Options');
        }
    }

}