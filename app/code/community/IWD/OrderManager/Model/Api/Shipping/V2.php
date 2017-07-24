<?php

/**
 * Class IWD_OrderManager_Model_Api_Shipping_v2
 */
class IWD_OrderManager_Model_Api_Shipping_v2 extends IWD_OrderManager_Model_Api_Abstract_Api
{
    /**
     * @param array $data
     * @return array
     */
    public function changeShippingMethod(array $data)
    {
        $response = array();
        $id = md5(time());
        $this->log('changeShippingMethod api request ' . date('d-m-Y H:i:s') . ' ' . $id);
        $this->log($data);
        foreach ($data as $key => $obj) {
            try {
                $orderId = $obj->order_id;
                if (!isset($obj->shipping[0])) {
                    Mage::throwException('Invalid shipping params');
                }

                $shipping = $obj->shipping[0];
                $response[$key]['order_id'] = $orderId;
                $message = '';
                $params = $this->_prepareShippingParams($orderId, $shipping, $message);
                Mage::getModel('iwd_ordermanager/api_shipping')->updateOrderShipping($params);
                Mage::unregister('_singleton/iwd_ordermanager/api_logger');
                $response[$key]['status'] = 1;
                $response[$key]['message'] = $message;
            } catch (Exception $e) {
                $response[$key]['status'] = 0;
                $response[$key]['message'] = $e->getMessage();
            }
        }

        $this->log('changeShippingMethod api response ' . date('d-m-Y H:i:s') . ' ' . $id);
        $this->log($response);
        return array('result' => $response);
    }

    /**
     * @param $orderId
     * @param $shipping
     * @param $message
     * @return array
     */
    protected function _prepareShippingParams($orderId, $shipping, &$message)
    {
        $params = array();
        $params['order_id'] = $orderId;
        $rateName = $shipping->name;
        $params['shipping_method_radio'] = $rateName;
        if (!empty($shipping->amount_excl_tax) && !empty($shipping->amount_incl_tax)) {
            $params['s_amount_excl_tax'][$rateName] = $shipping->amount_excl_tax;
            $params['s_amount_incl_tax'][$rateName] = $shipping->amount_incl_tax;
        }

        $order = Mage::getModel('iwd_ordermanager/order_api_info')->init($params);
        $oldAmount = Mage::helper('core')->currency($order->getBaseShippingInclTax(), true, false);
        $code = @explode('_', $rateName)[0];
        $rateGroups = Mage::getModel('iwd_ordermanager/api_shipping')->getShippingRates($order);
        if (isset($rateGroups[$code][$rateName])) {
            $rate = $rateGroups[$code][$rateName];
            if (empty($shipping->amount_excl_tax) || empty($shipping->amount_incl_tax)) {
                $store = Mage::getModel('core/store')->load($order->getStoreId());
                $params['s_amount_excl_tax'][$rateName] = Mage::helper('tax')->getShippingPrice(
                    $rate->getPrice(),
                    Mage::helper('tax')->displayShippingPriceIncludingTax(),
                    $order->getShippingAddress(),
                    null,
                    $store
                );
                $params['s_amount_incl_tax'][$rateName] = Mage::helper('tax')->getShippingPrice(
                    $rate->getPrice(),
                    true,
                    $order->getShippingAddress(),
                    null,
                    $store
                );
            }
        }

        $oldDescription = $rate->getMethodTitle() ? $rate->getCarrierTitle() . ' - ' . $rate->getMethodTitle() : $rate->getMethodDescription();
        if (!empty($shipping->description)) {
            $params['s_description'][$rateName] = $shipping->description;
            $newDescription = $shipping->description;
        } else {
            $newDescription = '';
            if (isset($rate) && $rate) {
                $params['s_description'][$rateName] = $oldDescription;
                $newDescription = $oldDescription;
            }
        }

        $newAmount = Mage::helper('core')->currency($params['s_amount_incl_tax'][$rateName], true, false);
        $message = 'Shipping method was changed from "' . $oldDescription . '"(' . $rateName . ') ' . $oldAmount . ' to "' . $newDescription . '(' . $rateName . ') ' . $newAmount . '';

        return $params;
    }
}