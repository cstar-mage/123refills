<?php

class IWD_OrderManager_Block_Adminhtml_Cataloginventory_Stock_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('iwd_ordermanager_stock_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('iwd_ordermanager')->__('Source Information'));
    }

    protected function _beforeToHtml()
    {
        $helper = Mage::helper('iwd_ordermanager');

        $this->addTab('form_tab_stock_general', array(
            'label' => $helper->__('General'),
            'title' => $helper->__('General'),
            'content' => $this->getLayout()
                ->createBlock('iwd_ordermanager/adminhtml_cataloginventory_stock_edit_tab_general')->toHtml(),
        ));

        $this->addTab('form_tab_stock_address', array(
            'label' => $helper->__('Address'),
            'title' => $helper->__('Address'),
            'content' => $this->getLayout()
                ->createBlock('iwd_ordermanager/adminhtml_cataloginventory_stock_edit_tab_address')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}