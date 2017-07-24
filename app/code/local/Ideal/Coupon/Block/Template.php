<?php

class Ideal_Coupon_Block_Template extends Mage_Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate('idealcoupon/template.phtml');

        parent::__construct();
    }

    public function getRuleModel()
    {
        $ruleModel = $this->getData('rule_model');

        if (empty($ruleModel->getId())) {
            return NULL;
        }

        return $ruleModel;
    }
}