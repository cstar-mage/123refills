<?php

class Ideal_Coupon_Model_Observer extends Mage_Core_Model_Abstract
{
    public function __construct()
    {
        $this->processSessionVariable();
        return parent::__construct();
    }

    public function layoutGenerateBlocksAfter()
    {
        if (Mage::app()->getStore()->isAdmin()) {
            return;
        }
        
        $ruleModel = $this->getSalesRuleModel();

        if (!$this->validateSalesRuleModel($ruleModel)) {
            return;
        }

        $couponBlock = $this->_getApp()->getLayout()->createBlock('IdealCoupon/Template')->setData('rule_model', $ruleModel);
        $this->_getApp()->getLayout()->getBlock('content')->append($couponBlock);
    }

    public function salesQuoteSaveAfter()
    {
        if ($this->_getCart()->getItemsCount() == 0) {
            return;
        }

        $ruleModel = $this->getSalesRuleModel();

        if (!$this->validateSalesRuleModel($ruleModel)) {
            return;
        }

        $couponCode = $ruleModel->getCouponCode();

        $oldCouponCode = $this->_getQuote()->getCouponCode();

        if (!strlen($couponCode) && !strlen($oldCouponCode)) {
            return;
        }

        if ($couponCode == $oldCouponCode) {
            return;
        }

        try {
            $codeLength = strlen($couponCode);
            $isCodeLengthValid = $codeLength && $codeLength <= Mage_Checkout_Helper_Cart::COUPON_CODE_MAX_LENGTH;

            $this->_getQuote()->getShippingAddress()->setCollectShippingRates(true);
            $this->_getQuote()->setCouponCode($isCodeLengthValid ? $couponCode : '')
                ->collectTotals()
                ->save();

            if ($codeLength) {
                if ($isCodeLengthValid && $couponCode == $this->_getQuote()->getCouponCode()) {
                    $this->_getCheckoutSession()->addSuccess(
                        Mage::helper('IdealCoupon')->__('Coupon code "%s" was applied.', Mage::helper('core')->escapeHtml($couponCode))
                    );
                    $this->_getCheckoutSession()->setCartCouponCode($couponCode);
                } else {
                    $this->_getCheckoutSession()->addError(
                        Mage::helper('IdealCoupon')->__('Coupon code "%s" is not valid.', Mage::helper('core')->escapeHtml($couponCode))
                    );
                }
            } else {
                $this->_getCheckoutSession()->addSuccess(Mage::helper('IdealCoupon')->__('Coupon code was canceled.'));
            }

        } catch (Mage_Core_Exception $e) {
            $this->_getCheckoutSession()->addError($e->getMessage());
        } catch (Exception $e) {
            $this->_getCheckoutSession()->addError(Mage::helper('IdealCoupon')->__('Cannot apply the coupon code.'));
            Mage::logException($e);
        }
    }

    /**
     * Perform actions to session variable
     */
    protected function processSessionVariable()
    {
        $variable = $this->_getApp()->getRequest()->getParam('ref');

        if (!empty($variable)) {
            Mage::getSingleton('core/session')->setRefillsCouponCode($variable);
        }
    }

    /**
     * Get Session Variable value
     * 
     * @return string|NULL
     */
    protected function getSessionVariable()
    {
        $variable = Mage::getSingleton('core/session')->getRefillsCouponCode();
        return empty($variable) ? NULL : $variable;
    }

    /**
     * Get Sales Rule Id
     * 
     * @return int|NULL
     */
    protected function getSalesRuleId()
    {
        $variable = $this->getSessionVariable();
        
        if (empty($variable)) {
            return NULL;
        }
        $couponUrlModel = Mage::getModel('IdealCoupon/Coupon');
        $ruleId = $couponUrlModel->load($variable, 'url')->getSalesRuleId(); 
        
        return empty($ruleId) ? NULL : (int)$ruleId;
    }

    /**
     * Get Sales Rule Model
     * 
     * @return Mage_SalesRule_Model_Rule|NULL
     */
    protected function getSalesRuleModel()
    {
        $ruleId = $this->getSalesRuleId();
        return is_null($ruleId) ? NULL : Mage::getModel('salesrule/rule')->load($ruleId);
    }

    /**
     * Validate
     *
     * @param $ruleModel Mage_SalesRule_Model_Rule
     * @return boolean
     */
    protected function validateSalesRuleModel($ruleModel)
    {
        $isValid = true;

        if (is_null($ruleModel) || $ruleModel->getIsActive() != 1) {
            $isValid = false;
        }

        return $isValid;
    }

    /**
     * Retrieve shopping cart model object
     *
     * @return Mage_Checkout_Model_Cart
     */
    protected function _getCart()
    {
        return Mage::getSingleton('checkout/cart');
    }

    /**
     * Get current active quote instance
     *
     * @return Mage_Sales_Model_Quote
     */
    protected function _getQuote()
    {
        return $this->_getCart()->getQuote();
    }

    /**
     * Get checkout session model instance
     *
     * @return Mage_Checkout_Model_Session
     */
    protected function _getCheckoutSession()
    {
        return Mage::getSingleton('checkout/session');
    }
    
    /**
     * Get App
     * 
     * @return Mage_Core_Model_App
     */
    protected function _getApp()
    {
        return Mage::app();
    }
}