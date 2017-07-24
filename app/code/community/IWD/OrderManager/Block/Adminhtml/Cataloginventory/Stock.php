<?php

class IWD_OrderManager_Block_Adminhtml_Cataloginventory_Stock extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'iwd_ordermanager';
        $this->_controller = 'adminhtml_cataloginventory_stock';
        $this->_headerText = Mage::helper('iwd_ordermanager')->__('Sources');

        parent::__construct();
    }
}