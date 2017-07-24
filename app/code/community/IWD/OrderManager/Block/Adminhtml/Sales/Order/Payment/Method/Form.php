<?php

class IWD_OrderManager_Block_Adminhtml_Sales_Order_Payment_Method_Form extends Mage_Adminhtml_Block_Sales_Order_Create_Billing_Method_Form
{
    public function _toHtml()
    {
        $form = parent::_toHtml();
        return preg_replace('/(<input.+value)="[0-9]+"(.*>)/i', '$1$2', $form);
    }
}