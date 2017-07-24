<?php

class IWD_OrderManager_Block_Adminhtml_Sales_Order_View_Tab_Fee extends IWD_OrderManager_Block_Adminhtml_Sales_Order_Create_Fee
{
    /**
     * @var Mage_Sales_Model_Order
     */
    protected $_order;

    /**
     * @return Mage_Sales_Model_Order
     */
    public function getOrder()
    {
        if (is_null($this->_order) && ($orderId = $this->getOrderId())) {
            $this->_order = Mage::getModel('sales/order')->load($orderId);
        }

        return $this->_order;
    }

    /**
     * @return int
     */
    protected function getOrderId()
    {
        return Mage::app()->getRequest()->getParam('order_id', 0);
    }

    /**
     * @return float|int
     */
    public function getMinimalAmount()
    {
        return $this->getOrder()
            ? (($this->getOrder()->getGrandTotal() - $this->getOrder()->getIwdOmFeeAmount()) * -1)
            : 0;
    }

    /**
     * @return mixed
     */
    public function applyUrl()
    {
        return Mage::helper('adminhtml')->getUrl('*/sales_additional/applyFee');
    }

    /**
     * @return string
     */
    public function getAdditionalAmount()
    {
        $amount = (float)($this->getOrder() ? $this->getOrder()->getIwdOmFeeAmount() : 0);
        return empty($amount) ? '' : (string)number_format($amount, 2, '.', '');
    }

    /**
     * @return float
     */
    public function getAdditionalAmountInclTax()
    {
        $amount = (float)($this->getOrder() ? $this->getOrder()->getIwdOmFeeAmountInclTax() : 0);
        return empty($amount) ? $this->getAdditionalAmount() : (string)number_format($amount, 2, '.', '');
    }


    /**
     * @return string
     */
    public function getTaxPercent()
    {
        $percent = (float)($this->getOrder() ? $this->getOrder()->getIwdOmFeeTaxPercent() : 0);
        return empty($percent) ? '0.00' : (string)number_format($percent, 2, '.', '');
    }

    /**
     * @return string
     */
    public function getAdditionalAmountDescription()
    {
        return $this->getOrder() ? $this->getOrder()->getIwdOmFeeDescription() : '';
    }

    /**
     * @return bool
     */
    public function isCreatingOrder()
    {
        return 0;
    }

    /**
     * @return bool
     */
    public function isAdditionalDiscountEnabled()
    {
        return (bool)Mage::getStoreConfig('iwd_ordermanager/edit/enable_custom_amount') &&
            Mage::getSingleton('admin/session')->isAllowed('iwd_ordermanager/order/actions/custom_amount');
    }
}
