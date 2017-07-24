<?php

class IWD_OrderManager_Block_Adminhtml_Flags_Types_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'iwd_ordermanager';
        $this->_controller = 'adminhtml_flags_types';

        $this->_updateButton('save', 'label', Mage::helper('iwd_ordermanager')->__('Save Column'));

        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick' => "editForm.submit($('edit_form').action+'back/edit/')",
            'class' => 'save',
        ), -100, 100);
    }

    public function getHeaderText()
    {
        if ($this->isEdit()) {
            return Mage::helper('iwd_ordermanager')->__("Edit Column '%s'", $this->getFormData()->getName());
        }

        return Mage::helper('iwd_ordermanager')->__('Add New Column');
    }

    protected function isEdit()
    {
        return $this->getFormData() && $this->getFormData()->getId();
    }

    protected function getFormData()
    {
        return Mage::registry('iwd_om_flags_types');
    }
}
