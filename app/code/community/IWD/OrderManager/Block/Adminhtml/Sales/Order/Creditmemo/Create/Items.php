<?php

class IWD_OrderManager_Block_Adminhtml_Sales_Order_Creditmemo_Create_Items extends Mage_Adminhtml_Block_Sales_Order_Creditmemo_Create_Items
{
    protected function _toHtml()
    {
        $this->setTemplate('iwd/ordermanager/creditmemo/items.phtml');
        return parent::_toHtml();
    }
}