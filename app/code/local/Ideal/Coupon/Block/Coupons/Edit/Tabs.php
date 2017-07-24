<?php

class Ideal_Coupon_Block_Coupons_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('coupon_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle('Tabs');
    }

    protected function _beforeToHtml()
    {
        $this->addTab('coupons',
            array(
                'label'     => Mage::helper('catalog')->__('Coupons'),
                'title'     => Mage::helper('catalog')->__('Coupons'),
                'content'   => $this->getLayout()->createBlock('IdealCoupon/Coupons_Edit_Tab_Coupon')->toHtml(),
            ));

        return parent::_beforeToHtml();
    }

}