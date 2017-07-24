<?php

/**
 * Class IWD_OrderManager_Model_Api_Orderinfo_v2
 */
class IWD_OrderManager_Model_Api_Orderinfo_v2 extends IWD_OrderManager_Model_Api_Abstract_Api
{
    /**
     * Log file name
     */
    const LOG_FILE = 'om_api1.log';

    /**
     * @param array $data
     * @return array
     */
    public function changeOrderStatus(array $data)
    {
        $response = array();
        $id = md5(time());
        $this->log('changeOrderStatus api request ' . date('d-m-Y H:i:s') . ' ' . $id);
        $this->log($data);

        foreach ($data as $key => $obj) {
            $response[$key]['order_id'] = $obj->order_id;
            $response[$key]['order_status'] = $obj->order_status;
            try {
                $params = array();
                $params['order_id'] = $obj->order_id;
                $params['status'] = $obj->order_status;
                $order = Mage::getModel('iwd_ordermanager/order_api_info')->init($params);
                $oldStatus = $order->getStatus();
                Mage::getModel('iwd_ordermanager/order_api_info')->updateOrderInfo($params);
                Mage::unregister('_singleton/iwd_ordermanager/api_logger');
                $response[$key]['status'] = 1;
                $response[$key]['message'] = 'Order status was changed from ' . $oldStatus . ' to ' . $obj->order_status;
            } catch (Exception $e) {
                $response[$key]['status'] = 0;
                $response[$key]['message'] = $e->getMessage();
            }
        }

        $this->log('changeOrderStatus api response ' . date('d-m-Y H:i:s') . ' ' . $id);
        $this->log($response);
        return array('result' => $response);
    }
}