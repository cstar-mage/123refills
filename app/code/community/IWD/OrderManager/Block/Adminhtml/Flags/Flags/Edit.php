<?php

class IWD_OrderManager_Block_Adminhtml_Flags_Flags_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'iwd_ordermanager';
        $this->_controller = 'adminhtml_flags_flags';

        $this->_updateButton('save', 'label', Mage::helper('iwd_ordermanager')->__('Save Label'));

        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick' => "editForm.submit($('edit_form').action+'back/edit/')",
            'class' => 'save',
        ), -100, 100);
    }

    public function getHeaderText()
    {
        if ($this->isEdit()) {
            return Mage::helper('iwd_ordermanager')->__("Edit Label '%s'", $this->getFormData()->getName());
        }

        return Mage::helper('iwd_ordermanager')->__('Add New Label');
    }

    protected function isEdit()
    {
        return $this->getFormData() && $this->getFormData()->getId();
    }

    protected function getFormData()
    {
        return Mage::registry('iwd_om_flags');
    }
}
