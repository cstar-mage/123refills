<?php

/**
 * Class IWD_OrderManager_Adminhtml_Sales_AdditionalController
 */
class IWD_OrderManager_Adminhtml_Sales_AdditionalController extends IWD_OrderManager_Controller_Abstract
{
    /**
     * return void
     */
    public function applyFeeAction()
    {
        $result = array('status' => 1);

        try {
            /**
             * @var $additionalFee IWD_OrderManager_Model_Order_AdditionalFee
             */
            $additionalFee = Mage::getModel('iwd_ordermanager/order_additionalFee');

            $additionalFee->setAdditionalAmount($this->getAdditionalAmount())
                ->setAdditionalAmountInclTax($this->getAdditionalAmountInclTax())
                ->setAdditionalTaxPercent($this->getAdditionalTaxPercent())
                ->setFeeDescription($this->getAdditionalDescription());

            $additionalFee->applyAdditionalFeeToOrder($this->getOrder());
        } catch (Exception $e) {
            $result = array('status' => 0, 'error' => $e->getMessage());
        }

        $this->prepareResponse($result);
    }

    /**
     * @return float
     */
    protected function getAdditionalAmount()
    {
        return $this->getRequest()->getParam('amount', 0);
    }

    /**
     * @return float
     */
    protected function getAdditionalAmountInclTax()
    {
        return $this->getRequest()->getParam('amount_incl_tax', 0);
    }

    /**
     * @return float
     */
    protected function getAdditionalTaxPercent()
    {
        return $this->getRequest()->getParam('percent', 0);
    }

    /**
     * @return string
     */
    protected function getAdditionalDescription()
    {
        return $this->getRequest()->getParam('description', 'Custom Amount');
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('iwd_ordermanager/order/actions/custom_amount');
    }
}
