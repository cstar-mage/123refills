<?php

/**
 * Class IWD_OrderManager_Adminhtml_Sales_OrderinfoController
 */
class IWD_OrderManager_Adminhtml_Sales_OrderinfoController extends IWD_OrderManager_Controller_Abstract
{
    /**
     * @return array
     */
    protected function getForm()
    {
        $result = array('status' => 1);

        $order = $this->getOrder();

        $result['form'] = $this->getLayout()
            ->createBlock('iwd_ordermanager/adminhtml_sales_order_info_form')
            ->setData('order', $order)
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
        Mage::getModel('iwd_ordermanager/order_info')->updateOrderInfo($params);

        return $result;
    }

    /**
     * @return mixed
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('iwd_ordermanager/order/actions/edit_order_information');
    }
}
