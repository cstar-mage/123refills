<?php

/**
 * Class IWD_OrderManager_Adminhtml_Sales_MassactionController
 */
class IWD_OrderManager_Adminhtml_Sales_MassactionController extends IWD_OrderManager_Controller_Abstract
{
    public function updateAction()
    {
        try {
            $this->saveMassaction();
            $result = array('status' => 1);
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log($e->getMessage());
            $result = array('status' => 0, 'error' => $e->getMessage());
        }

        $this->prepareResponse($result);
    }

    protected function saveMassaction()
    {
        $options = $this->getRequest()->getParam('options', '{}');

        Mage::getModel('iwd_ordermanager/sales_massaction')->saveMassactionForCurrentUser($options);
    }
}
