<?php

/**
 * Class IWD_OrderManager_Adminhtml_Sales_CustomerController
 */
class IWD_OrderManager_Adminhtml_Sales_CustomerController extends IWD_OrderManager_Controller_Abstract
{
    /**
     * @return array
     */
    protected function getForm()
    {
        $result = array('status' => 1);

        $orderId = $this->getOrderId();
        $order = $this->getOrder();
        $fields = Mage::getModel('iwd_ordermanager/order_customer')->CustomerInfoOrderField($order);

        $result['form'] = $this->getLayout()
            ->createBlock('iwd_ordermanager/adminhtml_sales_order_account_form')
            ->setData('order_id', $orderId)
            ->setData('order', $fields)
            ->toHtml();

        return $result;
    }

    /**
     * @return array
     */
    protected function updateInfo()
    {
        $result = array('status' => 1);

        $params = $this->getRequest()->getParams();
        Mage::getModel('iwd_ordermanager/order_customer')->updateOrderCustomer($params);

        return $result;
    }

    /**
     * @return mixed
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')
            ->isAllowed('iwd_ordermanager/order/actions/edit_account_information');
    }
}
