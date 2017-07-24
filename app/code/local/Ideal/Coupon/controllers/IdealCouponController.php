<?php

class Ideal_Coupon_IdealCouponController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        $this->loadLayout();

        $layout = $this->getLayout();
        $contentBlock = $layout->getBlock('content');
        $contentBlock->append(
            $this->getLayout()->createBlock('IdealCoupon/Coupons_Grid', 'idealcoupon.coupons')
        );

        $this->renderLayout();
    }

    public function editAction()
    {
        $this->loadLayout();

        Mage::register('idealcoupon_coupon', Mage::getModel('IdealCoupon/Coupon'));
        $id = (int)$this->getRequest()->getParam('id');

        Mage::register('idealcoupon_coupon_id', $id);

        if ($id) {
            Mage::registry('idealcoupon_coupon')->load($id, 'sales_rule_id');
        }

        $layout = $this->getLayout();
        $leftBlock = $layout->getBlock('left');
        $leftBlock->append(
            $this->getLayout()->createBlock('IdealCoupon/Coupons_Edit_Tabs', 'idealcoupon.coupon_form')
        );

        $contentBlock = $layout->getBlock('content');
        $contentBlock->append(
            $this->getLayout()->createBlock('IdealCoupon/Coupons_Edit', 'idealcoupon.coupon_tabs')
        );

        $this->renderLayout();
    }

    public function saveAction()
    {
        $post = $this->getRequest()->getParams();

        $salesRuleId = (int)$post['sales_rule_id'];

        $coupon = Mage::getModel('IdealCoupon/Coupon')->load($salesRuleId, 'sales_rule_id');

        if (!$coupon->getId()) {
            $coupon->setSalesRuleId($salesRuleId);
        }

        $coupon->setUrl($post['url']);

        $coupon->save();

        if ($this->getRequest()->getParam('back')) {
            $this->_redirect(
                '*/*/edit',
                array(
                    'id' => $salesRuleId
                )
            );
            return;
        }

        $this->_redirect('*/*/index');
    }
}