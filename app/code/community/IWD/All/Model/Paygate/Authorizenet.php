<?php

class IWD_All_Model_Paygate_Authorizenet extends Mage_Paygate_Model_Authorizenet
{
    protected function _buildRequest(Varien_Object $payment)
    {
        $request = parent::_buildRequest($payment);
        $iwd = Mage::helper('iwdall')->getAuthorizenetTrackingCode();
        $request->setXSolutionId($iwd);
        return $request;
    }
}
