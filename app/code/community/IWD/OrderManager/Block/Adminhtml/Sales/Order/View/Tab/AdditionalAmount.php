<?php

class IWD_OrderManager_Block_Adminhtml_Sales_Order_View_Tab_AdditionalAmount extends IWD_OrderManager_Block_Adminhtml_Sales_Order_View_Tab_Fee
{
    /**
     * @return string
     */
    public function getCouponCode()
    {
        return $this->getOrder() ? $this->getOrder()->getCouponCode() : '';
    }

    /**
     * @return bool
     */
    public function isCouponCodeEnabled()
    {
        return Mage::getStoreConfig('iwd_ordermanager/edit/enable_edit_coupon') &&
            Mage::getSingleton('admin/session')->isAllowed('iwd_ordermanager/order/actions/coupon');
    }
}
