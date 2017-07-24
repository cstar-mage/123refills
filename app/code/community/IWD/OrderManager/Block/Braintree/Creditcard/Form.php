<?php
if (file_exists(Mage::getBaseDir('code') . '/community/IWD/RecurringPayments/Block/Payments/Braintree/Rewrite/Form.php')) {
    if (!class_exists('Braintree_Payments_Block_Creditcard_Form', false)) {
        include_once(Mage::getBaseDir('code') . '/community/IWD/RecurringPayments/Block/Payments/Braintree/Rewrite/Form.php');
    }

    class IWD_OrderManager_Block_Braintree_Creditcard_Form_Rewrite extends IWD_RecurringPayments_Block_Payments_Braintree_Rewrite_Form
    {


    }
} elseif (file_exists(Mage::getBaseDir('code') . '/community/IWD/BraintreePayments/Block/Creditcard/Form.php')) {
    if (!class_exists('IWD_BraintreePayments_Block_Creditcard_Form', false)) {
        include_once(Mage::getBaseDir('code') . '/community/IWD/BraintreePayments/Block/Creditcard/Form.php');
    }

    class IWD_OrderManager_Block_Braintree_Creditcard_Form_Rewrite extends IWD_BraintreePayments_Block_Creditcard_Form
    {


    }
} elseif (file_exists(Mage::getBaseDir('code') . '/local/Braintree/Payments/Block/Creditcard/Form.php')) {
    if (!class_exists('Braintree_Payments_Block_Creditcard_Form', false)) {
        include_once(Mage::getBaseDir('code') . '/local/Braintree/Payments/Block/Creditcard/Form.php');
    }

    class IWD_OrderManager_Block_Braintree_Creditcard_Form_Rewrite extends Braintree_Payments_Block_Creditcard_Form
    {


    }
} else {
    class IWD_OrderManager_Block_Braintree_Creditcard_Form_Rewrite extends Mage_Core_Block_Template
    {
        public function _toHtml()
        {
            return '';
        }
    }
}

class IWD_OrderManager_Block_Braintree_Creditcard_Form extends IWD_OrderManager_Block_Braintree_Creditcard_Form_Rewrite
{

    protected function _construct()
    {
        parent::_construct();
        if ($this->isOrderManagerEdit()) {
            $this->setTemplate('iwd/ordermanager/braintree/creditcard/form.phtml');
        }
    }

    private function isOrderManagerEdit()
    {
        return ($this->getRequest()->getControllerModule() == 'IWD_OrderManager_Adminhtml' &&
            $this->getRequest()->getControllerName() == 'sales_payment' &&
            $this->getRequest()->getActionName() == 'getForm'
        );
    }

}
