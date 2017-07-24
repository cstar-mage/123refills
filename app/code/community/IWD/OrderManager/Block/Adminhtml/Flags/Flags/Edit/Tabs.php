<?php

class IWD_OrderManager_Block_Adminhtml_Flags_Flags_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('ordermanager_flag_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('iwd_ordermanager')->__('Label Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('form_tab_flag_general', array(
            'label' => Mage::helper('iwd_ordermanager')->__('General Information'),
            'title' => Mage::helper('iwd_ordermanager')->__('General Information'),
            'content' => $this->getLayout()->createBlock('iwd_ordermanager/adminhtml_flags_flags_edit_tab_general')->toHtml(),
        ));

        $this->addTab('form_tab_flag_settings', array(
            'label' => Mage::helper('iwd_ordermanager')->__('Settings'),
            'title' => Mage::helper('iwd_ordermanager')->__('Settings'),
            'content' => $this->getLayout()->createBlock('iwd_ordermanager/adminhtml_flags_flags_edit_tab_settings')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}
