<?php

/**
 * Class IWD_OrderManager_Adminhtml_Sales_CouponController
 */
class IWD_OrderManager_Adminhtml_Sales_CouponController extends IWD_OrderManager_Controller_Abstract
{
    /**
     * @var Mage_Sales_Model_Quote|null
     */
    protected $quote = null;

    /**
     * @var array
     */
    protected $result = array();

    /**
     * @return void
     */
    protected function applyCouponAction()
    {
        $this->result = array('status' => 1);

        try {
            $coupon = $this->getCouponCode();
            $this->applyCoupon($coupon);

            $orderId = $this->getOrderId();
            $this->getLogger()->addCommentToOrderHistory($orderId, false);
        } catch (Exception $e) {
            $this->result = array('status' => 0, 'error' => $e->getMessage());
        }

        $this->prepareResponse($this->result);
    }

    /**
     * @param $coupon
     * @return void
     */
    protected function applyCoupon($coupon)
    {
        $this->syncQuote();
        $this->getOrderedItemsForm();
        $this->setCouponCode($coupon);
        $this->getQuoteItems();
    }

    /**
     * @return void
     */
    protected function syncQuote()
    {
        $order = $this->getOrder();
        Mage::getModel('iwd_ordermanager/order_converter')->syncQuote($order);
    }

    /**
     * @return void
     */
    protected function getQuoteItems()
    {
        $result = array();
        $params = array(
            'discount_percent',
            'discount_amount',
            'base_discount_amount',
            'tax_before_discount',
        );

        $quoteItems = $this->getQuote()->getAllItems();
        foreach ($quoteItems as $item) {
            $id = $item->getItemId();
            foreach ($params as $param) {
                $result[$id][$param] = $item->getData($param);
            }
        }

        $orderItems = $this->getOrder()->getAllItems();
        foreach ($orderItems as $item) {
            $orderItemId = $item->getItemId();
            $quoteItemId = $item->getQuoteItemId();
            if ($quoteItemId != $orderItemId) {
                $result[$orderItemId] = $result[$quoteItemId];
                unset($result[$quoteItemId]);
            }
        }

        $this->result['items'] = $result;
    }

    /**
     * @return void
     */
    protected function getOrderedItemsForm()
    {
        $orderId = $this->getOrderId();
        $order = $this->getOrder();
        $orderedItems = $order->getItemsCollection();

        $this->result['form'] = $this->getLayout()
            ->createBlock('iwd_ordermanager/adminhtml_sales_order_items_form')
            ->setTemplate('iwd/ordermanager/items/form.phtml')
            ->setData('ordered', $orderedItems)
            ->setData('order_id', $orderId)
            ->toHtml();
    }

    /**
     * @param $couponCode
     */
    protected function setCouponCode($couponCode)
    {
        $this->getQuote()->getShippingAddress()->setCollectShippingRates(true);
        $this->getQuote()->setCouponCode($couponCode)->collectTotals()->save();

        if ($couponCode) {
            if ($couponCode == $this->getQuote()->getCouponCode()) {
                $message = $this->__('Coupon code "%s" was applied.', Mage::helper('core')->escapeHtml($couponCode));
                $this->result['message']['success'] = $message;
                $this->getLogger()->addToLog($message);
            } else {
                $this->result['status'] = 0;
                $this->result['message']['error'] = $this->__(
                    'Coupon code "%s" is not valid.',
                    Mage::helper('core')->escapeHtml($couponCode)
                );
            }
        } else {
            $message = $this->__('Coupon code was canceled');
            $this->result['message']['success'] = $message;
            $this->getLogger()->addToLog($message);
        }
    }

    /**
     * @return IWD_OrderManager_Model_Logger
     */
    protected function getLogger()
    {
        return Mage::getSingleton('iwd_ordermanager/logger');
    }

    /**
     * @return Mage_Sales_Model_Quote
     */
    protected function getQuote()
    {
        if (empty($this->quote)) {
            $orderId = $this->getOrderId();
            $this->quote = Mage::getModel('iwd_ordermanager/order_converter')->getQuoteForOrder($orderId);
        }

        return $this->quote;
    }

    /**
     * @return string
     */
    protected function getCouponCode()
    {
        return Mage::app()->getRequest()->getParam('coupon_code', '');
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('iwd_ordermanager/order/actions/coupon');
    }
}
